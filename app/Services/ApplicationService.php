<?php


namespace App\Services;

use ContextAwareValidator;
use App\Application;
use App\Events\ApplicationDeniedEvent;
use App\Exceptions\ApplicationNotFoundException;
use App\Exceptions\IncompleteApplicationException;
use App\Exceptions\UnavailableApplicationException;
use App\Exceptions\VacancyNotFoundException;
use App\Notifications\ApplicationMoved;
use App\Notifications\NewApplicant;
use App\Response;
use App\User;
use App\Vacancy;
use Illuminate\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ApplicationService
{
    public function renderForm($vacancySlug)
    {
        $vacancyWithForm = Vacancy::with('forms')->where('vacancySlug', $vacancySlug)->get();

        $firstVacancy = $vacancyWithForm->first();

        if (!$vacancyWithForm->isEmpty() && $firstVacancy->vacancyCount !== 0 && $firstVacancy->vacancyStatus == 'OPEN') {
            return view('dashboard.application-rendering.apply')
                ->with([
                    'vacancy' => $vacancyWithForm->first(),
                    'preprocessedForm' => json_decode($vacancyWithForm->first()->forms->formStructure, true),
                ]);
        } else {

            throw new ApplicationNotFoundException('The application you\'re looking for could not be found or it is currently unavailable.', 404);

        }
    }

    /**
     * Fills a vacancy's form with submitted data.
     *
     * @throws UnavailableApplicationException Thrown when the application has no vacancies or is closed
     * @throws VacancyNotFoundException Thrown when the associated vacancy is not found
     * @throws IncompleteApplicationException Thrown when there are missing fields
     */
    public function fillForm(User $applicant, array $formData, $vacancySlug): bool
    {
        $vacancy = Vacancy::with('forms')->where('vacancySlug', $vacancySlug)->get();

        if ($vacancy->isEmpty()) {

            throw new VacancyNotFoundException('This vacancy doesn\'t exist; Please use the proper buttons to apply to one.', 404);

        }

        if ($vacancy->first()->vacancyCount == 0 || $vacancy->first()->vacancyStatus !== 'OPEN') {

            throw new UnavailableApplicationException("This application is unavailable.");
        }

        Log::info('Processing new application!');

        $formStructure = json_decode($vacancy->first()->forms->formStructure, true);
        $responseValidation = ContextAwareValidator::getResponseValidator($formData, $formStructure);


        Log::info('Built response & validator structure!');

        if (!$responseValidation->get('validator')->fails()) {
            $response = Response::create([
                'responseFormID' => $vacancy->first()->forms->id,
                'associatedVacancyID' => $vacancy->first()->id, // Since a form can be used by multiple vacancies, we can only know which specific vacancy this response ties to by using a vacancy ID
                'responseData' => $responseValidation->get('responseStructure'),
            ]);

            Log::info('Registered form response!', [
                'applicant' => $applicant->name,
                'vacancy' => $vacancy->first()->vacancyName
            ]);

            $application = Application::create([
                'applicantUserID' => $applicant->id,
                'applicantFormResponseID' => $response->id,
                'applicationStatus' => 'STAGE_SUBMITTED',
            ]);

            Log::info('Submitted an application!', [
                'responseID' => $response->id,
                'applicant' => $applicant->name
            ]);

            foreach (User::all() as $user) {
                if ($user->hasRole('admin')) {
                    $user->notify((new NewApplicant($application, $vacancy->first()))->delay(now()->addSeconds(10)));
                }
            }

            return true;

        }

        Log::warning('Application form for ' . $applicant->name . ' contained errors, resetting!');

        throw new IncompleteApplicationException('There are one or more errors in your application. Please make sure none of your fields are empty, since they are all required.');
    }

    public function updateStatus(Application $application, $newStatus)
    {
        switch ($newStatus) {
            case 'deny':

                event(new ApplicationDeniedEvent($application));
                $message = __("Application denied successfully.");

                break;

            case 'interview':
                Log::info(' Moved application ID ' . $application->id . 'to interview stage!');
                $message = __('Application moved to interview stage!');

                $application->setStatus('STAGE_INTERVIEW');
                $application->user->notify(new ApplicationMoved());

                break;

            default:
                throw new \LogicException("Wrong status parameter. Please notify a developer.");
        }

        return $message;
    }

    /**
     * @throws \Exception
     */
    public function delete(Application $application): ?bool
    {
        return $application->delete();
    }


    public function canVote($votes): bool
    {
        $allvotes = collect([]);

        foreach ($votes as $vote) {
            if ($vote->userID == Auth::user()->id) {
                $allvotes->push($vote);
            }
        }

        return !(($allvotes->count() == 1));
    }
}
