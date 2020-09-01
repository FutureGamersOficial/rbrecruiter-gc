<?php
/*
 * -- Information for translators | READ BEFORE TRANSLATING ANYTHING ---
 * In this file, only translate messages to the right, in this fashion:
 * 'something' => 'translate-me'
 * Also, don't translate, change, or move placeholders (:this-is-a-placeholder) starting with a colon.
 * Try to keep the message as close to the original in meaning as possible. These simple rules also apply to other files you're translating, such as:
 * auth.php, pagination.php, passwords.php, and validation.php.
 * It is VERY important that you "escape" single quotes with a backslash if they're present in your language, like this: I\'m an escaped quote
 *
 * Additionally, don't change anything in square or curly brackets, and don't remove pipe (|) characters.
 * If you see two messages separated by pipe, then usually the left side is singular and the right side is plural, so translate accordingly.
 *
 * Thank you for translating!
 */

return [

    // ============== REUSABLE STRINGS =======================

    'reusable' => [
        'created_at' => 'Created at',
        'updated_at' => 'Updated at',
        'actions' => 'Actions',
        'delete' => 'Delete',
        'status' => 'Status',
        'view' => 'View',
        'view_c' => 'View Details',
        'no_access' => 'Application Access Denied',
        'validation_err' => 'Validation error!',
        'description' => 'Description',
        'join_date' => 'Join Date',
        'my_acc' => 'My Account',
        'confirm' => 'Please Confirm',
        'confirm_plain' => 'Confirm',
        'confirm_click' => 'Click to Confirm',
        'date' => 'Date',
        'datetime' => 'Time & Date',
        'location' => 'Location',
        'none_yet' => 'None yet',
        'reason' => 'Reason',
        'days' => 'Days',
        'weeks' => 'Weeks',
        'months' => 'Months',
        'years' => 'Years',
        'yes' => 'Yes',
        'no' => 'No',
        'roles' => 'Roles',
        'member_since' => 'Member since :date',
        'lookup' => 'Lookup :ipAddress',
        'abt' => 'About',
        'acc' => 'Account',
        'settings' => 'Settings',
        'profile' => 'My Profile',
        'code' => 'code',
        'here' => 'here',
        'auth_req' => 'Please authenticate'
    ],


    // ============== HOMEPAGE MESSAGES ======================

    'home' => 'Home',
    'homepagetxt' => 'Homepage',
    'login' => 'Sign in',
    'logout' => 'Sign out',
    'register' => 'Sign up',
    'dashboard' => 'Dashboard',
    'back' => 'Go back',
    'homepage_welcome' => 'Welcome to our team management center!',
    'homepage_explainer_line1' => 'Here, you can apply for open staff member positions, view your application status, and manage your profile.',
    'homepage_explainer_line2' => 'Sign up with Email to continue.',
    'footer_copy' => 'All rights reserved',
    'global_error' => 'An error occurred',
    'global_success' => 'Success!',
    'txt_learn_more' => 'Learn more',
    'opening_nodetails' => 'There don\'t seem to be any details',
    'opening_nodetails_exp' => 'This opening does not have any details yet.',
    'details_m_title' => 'Opening details',
    'open_positions' => 'Open Positions',
    'last_updated' => 'Last updated',
    'open_position_count' => '{1} There is :count open position!|[2,*] There are :count open positions!',
    'ineligible_days_remaining' => 'Ineligible (:days) day(s) remaining',
    'txt_apply' => 'Apply', // Context: Apply as in applying for a "job", e.g. registering for a job
    'txt_application' => 'Application',
    'application_closed' => 'Applications Closed',
    'application_closed_intro' => 'Hello there!',
    'application_closed_intro_line2' => <<<EOT
      We are currently not hiring any new staff members at the moment. If you'd like to apply, check out our Discord's
      announcement channel for news when a new position opens.
      Our application cycle usually lasts two weeks, so if you're seeing this, it's because it finished, and new one will begin soon.
EOT,
    'where_work' => 'Where you\'ll work',
    'join_team' => 'Join The Team',
    'join_team_cta' => 'Join the team today and help out network grow and prosper!',
    'contact_cta' => 'Any questions? Leave a message!',
    'contact_disclaimer' => '*This is not an application form. Any applications sent here will be ignored.',
    'contactlabel_name' => 'Name',
    'contactlabel_email' => 'E-mail',
    'contactlabel_subject' => 'Subject (ex. Site Suggestion)',
    'contactlabel_send' => 'Send',



    // ======================== AUTHENTICATION MESSAGES ===========================

    '2fa_txt' => 'Two-Factor Authentication',
    '2fa_sronly' => 'Two-factor secret code (You can find this on Google Authenticator)',
    '2fa_lostcode' => 'Don\'t know the code?',
    '2fa_cancel_login' => 'Cancel login (logout)',

    'terms' => 'Terms of Use',
    'ppolicy' => 'Privacy Policy',

    'signin_cta' => 'Sign into your account',
    'password' => 'Password',
    'remember_me' => 'Remember me',
    'forgot_pw' => 'Forgot password?',
    'register_cta' => 'Register here',
    'no_acc' => 'Don\'t have an account?',
    'register_acc' => 'Register a new account',
    'pwsec' => [
        'line1' => 'Basic password security',
        'line2' => 'For your security, we implement strict password policies. It\'s also advisable to let your password manager or browser generate and save passwords for you (if it\'s a private device).',
        'line3' => 'Passwords must be a combination of: ',
        'line4' => 'A minimum of 10 characters;',
        'line5' => 'At least 3 uppercase characters;',
        'line6' => 'At least 3 numbers;',
        'line7' => 'Any number of special characters.'
    ],
    'sronly_confirmpassword' => 'Confirm Password', // hint: sronly stands for screen-reader only
    'sronly_mcusername' => 'Minecraft Username (Premium)',
    'have_account' => 'Have an account with us?',
    'login_here' => 'Login here',
    'register_txt' => 'Register',

    // ===================== DASHBOARD & COMPONENT MESSAGES ===========================

    'modal_close' => 'Close',
    'component_nopermission' => 'We\'re sorry, but you do not have permission to access this web page.',
    'component_accessdenied' => 'Access Denied',
    'component_contact' => 'Please contact your administrator if you believe this was in error.',
    'welcome_back' => 'Welcome back,',
    'eligible' => 'Eligible',
    'ineligible' => 'Ineligible',
    'eligibility_status' => 'Your current application eligibility status: :badgeStatus',
    'ongoing_apps' => 'Ongoing apps',
    'denied_apps' => 'Denied apps',
    'users_staff' => 'Total Users + Staff',
    'new_apps' => 'New applications',
    'v_backlog' => 'Vote backlog',
    'ranks' => 'Available ranks',
    'open' => 'Open',
    'closed' => 'Closed',
    'upcoming' => 'Your upcoming interviews',
    'soon' => 'Coming soon',


    //=================== ADMINISTRATION MESSAGES (for all administration pages) ===============

    'adm' => 'Administration',
    'devtools' => 'Developer Tools',
    'devoptions' => 'Developer Options',
    'forceeval' => 'Please choose an application to force re-evaluation',
    'appid' => 'Application ID',
    'no_valid_app' => 'There are no valid applications',
    'choose_app' => 'Choose an application',
    'dispatch_event' => 'Dispatch event now',
    'devtools_warn' => 'Do not use these options if you don\'t know what you\'re doing, even if you have access to this page.',
    'warn' => 'Warning',
    'override_votes' => 'Override Vote Evaluation',
    'artisan_evaluate' => 'Artisan: Evaluate Votes Now', // Tip: Artisan is a program name, therefore not translatable
    'devtools_info' => 'This panel may be also used to completely override the vote system in stalemate scenarios',


    'forms' => 'Forms',
    'positions' => 'Positions', // Context: Positions as in job opening
    'edit_form' => 'Edit Form',
    'edt' => 'Editor',
    'edit' => 'Edit',
    'edt_action' => 'Editing',
    'txtbox' => 'Textbox',
    'multiline' => 'Multi line answer',
    'checkbox' => 'Checkbox',
    'field_type' => 'Choose a field type',
    'save_exit' => 'Save & Quit',
    'new_field' => 'New field',
    'vacancy_edit' => 'Vacancy Editor',
    'new_vacancy' => 'New Vacancy',
    'form_consistency' => 'For consistency purposes, grayed out fields can\'t be edited.',

    'vacancy' => [
        'add' => 'Add vacancy',
        'name' => 'Vacancy Name',
        'description' => 'Vacancy Description',
        'details' => 'Vacancy Details',
        'markdown' => 'Markdown Supported',
        'no_details' => 'No details yet... Add some!',
        'permission_group' => 'Permission Group',
        'permission_group_tooltip' => 'The permission group from your server/network\'s permissions manager. Compatible with Luckperms and PEX.',
        'discord_roleid' => 'Discord Role ID',
        'discord_roleid_tooltip' => 'Discord Desktop: Go to your Account Settings > Appearance -> Advanced and toggle Developer Mode. On your server\'s roles tab, right click any role to copy it\'s ID.',
        'current_form' => 'Current Form (uneditable)',
        'remaining_slots' => 'Remaining slots',
        'free_slots' => 'Free slots',
        'free_slots_tooltip' => 'How many submissions before the vacancy stops accepting new applicants?',
        'save' => 'Save Changes',
        'cancel' => 'Cancel',
        'close_vacancy' => 'Close Position',
        'description_tooltip' => 'Add things like admission requirements, rank resposibilities and roles, and anything else you feel is necessary',
        ''

    ],

    'form' => 'Form',

    'form_builder' => [
        'builder' => 'Form Builder',
        'builder_name' => 'Application Form Management Tool',
        'name_form' => 'Name your form...',
        'save_form' => 'Save Form',
    ],

    'form_preview' => [
        'preview' => 'Preview',
        'title' => 'Application Form Preview',
        'looks' => 'This is how your form looks like to applicants',
        'f_info' => 'You may edit it and add more fields later.',
        ''
    ],

    'forms_p' => [

        'available_forms' => 'Available forms',
        'form_title' => 'Form title',
        'empty_noforms' => 'Nothing to see here! Please add some forms first.',
        'new_form' => 'NEW FORM'
    ],

    'players' => [

        'reg_players' => 'Registered players',
        'reg_players_staff' => 'See Registered Players (Applicant Pool)',
        'total_banned' => 'Total Banned Players',
        'search' => 'Search players',
        'f_p_search' => 'Full/partial email search',
        'p_disclaimer' => 'Please note: This list only includes players registered in the team management portal. In a future release, all network players will be shown here.',
        'listing' => 'Player Listing',
        'reg_date' => 'Registration Date',
        'ign' => 'IGN', // Context: Short for In-Game Name
        'banned' => 'Banned',
        'active' => 'Active',
        'no_reg' => 'There are no registered players!',
        'no_reg_exp' => <<<EOT
          Registered players are those without a staff role in the team management application.
          There may be other users registered in the platform, but they won't be displayed here.
EOT,
        'see_staff' => 'See Staff Members'

    ],

    'positions_p' => [

        'application_form' => 'Application Form',
        'select_form' => 'Select a form...',
        'no_form_error' => <<<EOT
           You cannot create a vacancy without any forms with which people would apply.
           create a form first, then, create a vacancy.
           A single form is allowed to have multiple vacancies, so you can attach future vacancies to the same form if you'd like.
EOT,
        'new_pos' => 'NEW POSITION',
        'empty_pos_warning' => 'Nothing to see here! Open some vacancies first. This will get applicants pouring in! (hopefully)',
        'manage_forms' => 'MANAGE APPLICATION FORMS',

    ],

    'settings' => [

        'settings' => 'Settings',
        'settings_header' => 'Notification Settings',
        'settings_p' => 'Change which notifications are sent here.',
        'back_btn' => 'Back to Dashboard'

    ],

    'staff' => [

        'members' => 'Staff Members',
        'active_sm' => 'Active Staff Members',
        'm_listing' => 'Member Listing',
        'f_name' => 'Full Name',
        'rank' => 'Rank',
    ],

    // ======================== APPLICATION RENDERING MESSAGES =========================

    'application_r' => [

        'appl_submit_warn' => 'Are you sure you want to submit your application? Please review each of your answers carefully before doing so.',
        'appl_submit_doublewarn' => 'Please note: Applications CANNOT be modified once they\'re submitted!',
        'acceptsend' => 'Accept & Send',
        'review' => 'Review',
        'applying_for' => 'You are applying for: :name',
        'welcome' => [
            'yrs_old' => 'Years old', // Context: "years old" as in: Tom is 24 years old
            'line1' => 'We\'re glad you\'ve decided to apply. Generally, applications take 48 hours to be processed and reviewed. Depending on the circumstances and the volume of applications, you may receive an answer in a shorter time.',
            'line2' => 'Please fill out the form below. Keep all answers concise and complete. Please keep in mind that the age requirement is at least :agerqr.',
            'line3' => 'Asking about your application will result in instant denial. Everything you need to know is here.'
        ],
        'app_timeout' => 'Your account is not permitted to submit another application. Please wait :days more days before trying to submit an application.'
    ],


    'application_m' => [
        'title' => 'Application Management',
        'all_apps' => 'All Applications',
        'modal_confirm' => 'Are you sure?',
        'really_delete' => 'Really delete this?',


        'outstanding_sm' => 'Outstanding',
        'outstanding_apps' => 'Outstanding applications',
        'outstanding_subm' => 'Outstanding (Submitted)',

        'interview_q' => 'Interview Queue',
        'interview_p' => 'Interview',
        'interview_s' => 'Interview Scheduled',
        'finished_int' => 'Finished Interviews',
        'schedule_int' => 'Schedule Interviews',
        'p_review' => 'Peer Review',
        'applicant' => 'Applicant',
        'interviewee' => 'Interviewee',
        'pending_int' => 'Pending Interview',
        'schedule' => 'Schedule',

        'view_interview_queue' => 'View Interview Queue',
        'view_approval_queue' => 'View Approval Queue',
        'view_outstanding_queue' => 'View Outstanding Queue',

        'approved' => 'Approved',
        'denied' => 'Denied',
        'unknown_stat' => 'Unknown',

        'consequence_irreversible' => 'IRREVERSIBLE',
        'delete_action_warning' => 'This action is :consequence.',
        'delete_explainer' => 'Comments, appointments and any votes attached to this application WILL be deleted too. Please make sure this application really needs to be deleted.',

        'all_apps_header' => 'You\'re looking at all applications ever received',
        'all_apps_exp' => 'Here, you have quick and easy access to all applications ever received by the system.',

        'no_apps' => 'There are no applications here',
        'no_apps_exp' => 'We couldn\'t find any applications. Maybe no one has applied yet? Please try again later.',
        'int_applications' => 'Applications',

        'no_apps_pending_int' => 'No Applications Pending Interview',
        'no_apps_pending_int_exp' => 'There are no applications that have been moved up to the Interview stage. Please check the outstanding queue.There are no applications that have been moved up to the Interview stage. Please check the outstanding queue.',
        'upcoming_int' => 'My Upcoming Interviews',
        'pending_schedule' => 'Pending Schedule',

        'no_upcoming' => 'There are no upcoming interviews',
        'no_upcoming_exp' => 'Please check other queues down in the application process. Applicants here may have already been interviewed.',

        'no_outstanding' => 'Seeing no applications? Check with an Administrator to make sure that there are available open positions.',
        'no_outstanding_exp' => 'Advertising on relevant forums made for this purpose is also a good idea.',

        'applicant_name' => 'Applicant Name',
        'application_date' => 'Application Date',

        'no_pending' => 'There are no pending applications',
        'no_pending_exp' => 'It seems like no one new has applied yet. Checkout the interview and approval queues for applications that might have moved up the ladder by now.',

        'voting_reminder' => [

            'title' => 'Voting Reminder',
            'line1' => 'Applications which gain more than 50% of positive votes are automatically approved after one day.',
            'line2' => 'Conversely, applications that do not reach this number are automatically denied.',
            'line3' => 'Please note that the vote system can be overridden'

        ],

        'no_pending_review' => 'There are no applications pending review',
        'no_pending_review_exp' => 'Check the other queues for any applications! Applications will be shown here as soon as their interview is completed. You\'ll be able to view meeting notes and vote based on your observations.',

    ],

    // ============= PROFILE & USER MESSAGES ===============

    'profile' => [

        'title' => ':name\'s profile',
        'profile' => 'Profile',
        'users' => 'Users',
        'account_banned' => 'Account banned',
        'account_banned_exp' => 'This user has been banned by the moderators.',
        'ban_confirm' => 'Please confirm that you want to ban this user account. You\'ll need to add a reason and expiration date to confirm this. Bans don\'t transfer to connected Minecraft networks (yet).',
        'leave_empty' => 'Leave empty for a permanent ban',
        'duration' => 'Duration',
        'p_duration' => 'Punishment duration',
        'p_duration_exp' => 'e.g. Spamming',
        'ban' => 'Ban',

        'terminate_notice' => 'You are about to terminate a staff member',
        'terminate_notice_warning' => 'Terminating a staff member will remove their privileges on the team management site and Network.
                They will be notified of their termination. Make sure to have discussed this with them first.',
        'terminate_notice_consequence' => 'THIS PROCESS IS IRREVERSIBLE AND IMMEDIATE',
        'terminate_txt' => 'Terminate Staff Member',

        'delete_acc_warn' => 'WARNING: This is a potentially destructive action!',
        'delete_acc_consequence' => 'Deleting a user\'s account is an irreversible process. Historic and current applications, votes, and profile content, as well as any personally identifiable information will be immediately erased.',
        'type_to_confirm' => 'Type to confirm:',
        'type_placeholder' => 'Please type the above',

        'delete_acc' => 'Delete Account',
        'edit_acc' => 'Edit Account',

        'ban_acc' => 'Ban Account',
        'unban_acc' => 'Unban Account',

        'search_result' => 'Search results',

        'origin_cc' => 'Origin country',
        'state_prov' => 'State/Province',
        'district' => 'District (if any)',
        'city' => 'City',
        'zipcode' => 'Zipcode',
        'coords' => 'Coordinates',
        'european' => 'European?',
        'isp' => 'ISP', // Internet service provider
        'org' => 'Organization (if any)',
        'ctype' => 'C. Type', // Internet Connection type
        'timezone' => 'Timezone',
        'noresults' => 'This query returned no results.',

        'edituser' => 'Edit PII and Roles', // PII: Personally identifiable information
        'edituser_consequence' => 'Warning! This is a sensitive setting! Changing this could have unintended consequences!',
        'acc_management' => 'Account Management (Admin)',
        'discord_tag' => 'User\'s Discord Tag: :discordTag',
        'account_settings' => 'Account Settings',

        '2fa_welcome' => 'We\'re glad you decided to increase your account\'s security!',
        'supported_apps' => 'Supported apps you can install: ',
        'scan_code' => 'Scan the :scannable code with your preferred app, and then copy the code here.',
        'otp' => 'One-time code',
        '2fa_enable' => 'Enable 2FA',
        '2fa_remove_consequence' => 'Removing two-factor authentication will reduce the security of your account.',
        '2fa_password_confirm' => 'Confirm your password to continue',
        '2fa_password_confirm_exp' => 'To prevent unauthorized changes, a password is always required for sensitive operations.',
        '2fa_disable_consent' => '"I understand the possible consequences of disabling two factor authentication"',
        '2fa_remove' => 'Remove 2FA',

        'security_lgotherdev' => 'For your security, you\'ll need to re-enter your password before logging out other devices. If you believe your account has been compromised, please change your password instead, as that will automatically log out anyone else who might using your account, and prevent them from signing back in.',
        'password_reenter' => 'Re-enter your password',

        'acc_security' => 'Account Security',
        '2fa' => 'Two Factor Authentication',
        'sessions' => 'Sessions',
        'contact_settings' => 'Contact Settings (E-Mail)',

        'change_password' => 'Change Password',
        'change_password_exp' => 'Change your password here. This will log you out from all existing sessions for your security.',

        'old_pass' => 'Old Password',
        'forgot_pw' => 'Forgot your password? Reset it :link',
        'new_pw' => 'New Password',

        '2fa_enable_success' => 'Hooray! 2FA is setup correctly for your account. A code will be asked each time you login.',
        '2fa_avail' => 'Two-factor auth is available for your account.',
        '2fa_avail_exp' => ' Enabling this security option greatly increases your account\'s security in case your password ever gets stolen.',

        'session_manager' => 'Session Manager',
        'terminate_others' => 'Terminating other sessions is generally a good idea if your account has been compromised.',
        'current_session' => 'Your current session: logged in from :ipAddress',
        'flush_session' => 'Flush sessions',
        'personal_data_change' => 'Need to change personal data? You can do so here.',
        'current_email' => 'Current Email Address',
        'new_email' => 'New Email Address',
        'current_password' => 'Current Password',
        'security_nochangepw' => 'For security reasons, you cannot make important account changes without confirming your password. You\'ll also need to verify your new email.',
        'change_email' => 'Change Email Address',

        'basic_info' => 'Basic Information',
        'fl_name' => 'First / Last Name',
        'shortbio' => 'Short Bio',
        'about_me' => 'About Me',
        'pref_media' => 'Preferences & Media',
        'avatar_source' => 'Retrieve avatar from: ',
        'social_media' => 'Social Media',

        'github_user' => 'Github Username',
        'twitter_user' => 'Twitter Username',
        'insta_user' => 'Instagram Username',
        'discord_user' => 'Discord Handle',

        'update_prfl' => 'Update Profile'

    ]


];
