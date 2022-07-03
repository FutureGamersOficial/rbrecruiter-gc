<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App{
/**
 * App\Absence
 *
 * @property int $id
 * @property int $requesterID
 * @property string $start
 * @property string $predicted_end
 * @property int $available_assist
 * @property string $reason
 * @property string $status
 * @property int|null $reviewer
 * @property string|null $reviewed_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\User $requester
 * @method static \Database\Factories\AbsenceFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Absence newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Absence newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Absence query()
 * @method static \Illuminate\Database\Eloquent\Builder|Absence whereAvailableAssist($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Absence whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Absence whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Absence wherePredictedEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Absence whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Absence whereRequesterID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Absence whereReviewedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Absence whereReviewer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Absence whereStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Absence whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Absence whereUpdatedAt($value)
 */
	class Absence extends \Eloquent {}
}

namespace App{
/**
 * App\Application
 *
 * @property int $id
 * @property int $applicantUserID
 * @property int $applicantFormResponseID
 * @property string $applicationStatus
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Appointment|null $appointment
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Comment[] $comments
 * @property-read int|null $comments_count
 * @property-read \App\OneoffApplicant|null $oneoffApplicant
 * @property-read \App\Response|null $response
 * @property-read \App\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Vote[] $votes
 * @property-read int|null $votes_count
 * @method static \Illuminate\Database\Eloquent\Builder|Application newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Application newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Application query()
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereApplicantFormResponseID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereApplicantUserID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereApplicationStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereUpdatedAt($value)
 */
	class Application extends \Eloquent {}
}

namespace App{
/**
 * App\Appointment
 *
 * @property int $id
 * @property string $appointmentDescription
 * @property string $appointmentDate
 * @property int $applicationID
 * @property string $appointmentLocation
 * @property string $appointmentStatus
 * @property int $userAccepted
 * @property string|null $meetingNotes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Application|null $application
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereApplicationID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereAppointmentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereAppointmentDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereAppointmentLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereAppointmentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereMeetingNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereUserAccepted($value)
 */
	class Appointment extends \Eloquent {}
}

namespace App{
/**
 * App\Ban
 *
 * @property int $id
 * @property int $userID
 * @property string $reason
 * @property string|null $bannedUntil
 * @property int $authorUserID
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $isPermanent
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Ban newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ban newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ban query()
 * @method static \Illuminate\Database\Eloquent\Builder|Ban whereAuthorUserID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ban whereBannedUntil($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ban whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ban whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ban whereIsPermanent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ban whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ban whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ban whereUserID($value)
 */
	class Ban extends \Eloquent {}
}

namespace App{
/**
 * App\Comment
 *
 * @property int $id
 * @property int $authorID
 * @property int $applicationID
 * @property string $text
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Application $application
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Comment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereApplicationID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereAuthorID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereUpdatedAt($value)
 */
	class Comment extends \Eloquent {}
}

namespace App{
/**
 * App\Form
 *
 * @property int $id
 * @property string $formName
 * @property string $formStructure
 * @property string $formStatus
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Response|null $responses
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Vacancy[] $vacancies
 * @property-read int|null $vacancies_count
 * @method static \Illuminate\Database\Eloquent\Builder|Form newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Form newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Form query()
 * @method static \Illuminate\Database\Eloquent\Builder|Form whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Form whereFormName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Form whereFormStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Form whereFormStructure($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Form whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Form whereUpdatedAt($value)
 */
	class Form extends \Eloquent {}
}

namespace App{
/**
 * App\OneoffApplicant
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property int $application_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Application|null $application
 * @method static \Illuminate\Database\Eloquent\Builder|OneoffApplicant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OneoffApplicant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OneoffApplicant query()
 * @method static \Illuminate\Database\Eloquent\Builder|OneoffApplicant whereApplicationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OneoffApplicant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OneoffApplicant whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OneoffApplicant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OneoffApplicant whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OneoffApplicant whereUpdatedAt($value)
 */
	class OneoffApplicant extends \Eloquent {}
}

namespace App{
/**
 * App\Options
 *
 * @property int $id
 * @property string $option_name
 * @property string $option_value
 * @property string $friendly_name
 * @property string|null $option_category
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Options newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Options newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Options query()
 * @method static \Illuminate\Database\Eloquent\Builder|Options whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Options whereFriendlyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Options whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Options whereOptionCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Options whereOptionName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Options whereOptionValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Options whereUpdatedAt($value)
 */
	class Options extends \Eloquent {}
}

namespace App{
/**
 * App\Profile
 *
 * @property int $id
 * @property string|null $profileShortBio
 * @property string|null $profileAboutMe
 * @property string $avatarPreference
 * @property string|null $socialLinks
 * @property int $userID
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Profile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Profile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Profile query()
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereAvatarPreference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereProfileAboutMe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereProfileShortBio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereSocialLinks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereUserID($value)
 */
	class Profile extends \Eloquent {}
}

namespace App{
/**
 * App\Response
 *
 * @property int $id
 * @property int $responseFormID
 * @property int $associatedVacancyID
 * @property string $responseData
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Application|null $application
 * @property-read \App\Form|null $form
 * @property-read \App\Vacancy|null $vacancy
 * @method static \Illuminate\Database\Eloquent\Builder|Response newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Response newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Response query()
 * @method static \Illuminate\Database\Eloquent\Builder|Response whereAssociatedVacancyID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Response whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Response whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Response whereResponseData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Response whereResponseFormID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Response whereUpdatedAt($value)
 */
	class Response extends \Eloquent {}
}

namespace App{
/**
 * App\Team
 *
 * @property int $id
 * @property int|null $owner_id
 * @property string $name
 * @property string|null $description
 * @property string $status
 * @property int $openJoin
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\TeamFile[] $files
 * @property-read int|null $files_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Mpociot\Teamwork\TeamInvite[] $invites
 * @property-read int|null $invites_count
 * @property-read \App\User|null $owner
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @property-read int|null $users_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Vacancy[] $vacancies
 * @property-read int|null $vacancies_count
 * @method static \Illuminate\Database\Eloquent\Builder|Team newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Team newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Team query()
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereOpenJoin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereUpdatedAt($value)
 */
	class Team extends \Eloquent {}
}

namespace App{
/**
 * App\TeamFile
 *
 * @property int $id
 * @property int $uploaded_by
 * @property int $team_id
 * @property string $name
 * @property string|null $caption
 * @property string|null $description
 * @property string $fs_location
 * @property string $extension
 * @property int|null $size
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Team $team
 * @property-read \App\User $uploader
 * @method static \Illuminate\Database\Eloquent\Builder|TeamFile allTeams()
 * @method static \Database\Factories\TeamFileFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamFile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TeamFile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TeamFile query()
 * @method static \Illuminate\Database\Eloquent\Builder|TeamFile whereCaption($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamFile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamFile whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamFile whereExtension($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamFile whereFsLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamFile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamFile whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamFile whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamFile whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamFile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamFile whereUploadedBy($value)
 */
	class TeamFile extends \Eloquent {}
}

namespace App{
/**
 * App\User
 *
 * @property int $id
 * @property string|null $uuid
 * @property string $name
 * @property string $email
 * @property int $administratively_locked Account locked by settings changes, e.g. 2fa grace period timeout
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string|null $username
 * @property string|null $dob
 * @property string $originalIP
 * @property string $password
 * @property string|null $deleted_at
 * @property string|null $twofa_secret
 * @property string|null $remember_token
 * @property string|null $password_last_updated
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $current_team_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Absence[] $absences
 * @property-read int|null $absences_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Application[] $applications
 * @property-read int|null $applications_count
 * @property-read \App\Ban|null $bans
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Comment[] $comments
 * @property-read int|null $comments_count
 * @property-read \Mpociot\Teamwork\TeamworkTeam|null $currentTeam
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\TeamFile[] $files
 * @property-read int|null $files_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Mpociot\Teamwork\TeamInvite[] $invites
 * @property-read int|null $invites_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \App\Profile|null $profile
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Mpociot\Teamwork\TeamworkTeam[] $teams
 * @property-read int|null $teams_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Vote[] $votes
 * @property-read int|null $votes_count
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAdministrativelyLocked($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCurrentTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereOriginalIP($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePasswordLastUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwofaSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUuid($value)
 */
	class User extends \Eloquent implements \Illuminate\Contracts\Auth\MustVerifyEmail {}
}

namespace App{
/**
 * App\Vacancy
 *
 * @property int $id
 * @property string $vacancyName
 * @property string $vacancyDescription
 * @property string|null $vacancyFullDescription
 * @property string $vacancySlug
 * @property string $permissionGroupName
 * @property string $discordRoleID
 * @property int $vacancyFormID
 * @property int $vacancyCount
 * @property string $vacancyStatus
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Form $forms
 * @property-read string $vacancy_full_description
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Team[] $teams
 * @property-read int|null $teams_count
 * @method static \Illuminate\Database\Eloquent\Builder|Vacancy newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Vacancy newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Vacancy query()
 * @method static \Illuminate\Database\Eloquent\Builder|Vacancy whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vacancy whereDiscordRoleID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vacancy whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vacancy wherePermissionGroupName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vacancy whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vacancy whereVacancyCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vacancy whereVacancyDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vacancy whereVacancyFormID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vacancy whereVacancyFullDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vacancy whereVacancyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vacancy whereVacancySlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vacancy whereVacancyStatus($value)
 */
	class Vacancy extends \Eloquent {}
}

namespace App{
/**
 * App\Vote
 *
 * @property int $id
 * @property int $userID
 * @property string $allowedVoteType
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Application[] $application
 * @property-read int|null $application_count
 * @property-read \App\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Vote newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Vote newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Vote query()
 * @method static \Illuminate\Database\Eloquent\Builder|Vote whereAllowedVoteType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vote whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vote whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vote whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vote whereUserID($value)
 */
	class Vote extends \Eloquent {}
}

