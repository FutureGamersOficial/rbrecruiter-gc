<?php

namespace App\Services;

use App\Vacancy;
use App\Application;

class VacancyApplicationService
{

    /**
     * Finds all applications associated with $model.
     *
     * @param Vacancy $model The model you want to search through.
     * @return Illuminate\Support\Collection A collection of applications
     */
    public function findApplications(Vacancy $model)
    {

        $applications = collect([]);

        foreach(Application::all() as $application)
        {
            if ($application->response->vacancy->id == $model->id)
            {
                $applications->push($application);
            }
        }

        return $applications;

    }


}