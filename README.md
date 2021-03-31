# THIS IS A DEVELOPMENT BUILD. USE OF THIS BRANCH IS NOT SUPPORTED.

## RB Recruiter - The Simple Staff Application Manager v 0.6.2 [![Crowdin](https://badges.crowdin.net/raspberry-staff-manager/localized.svg)](https://crowdin.com/project/raspberry-staff-manager)

## The quick and pain-free staff application manager

Have you ever gotten tired of managing your community's applications through Discord (or anything else) and having to scroll through hundreds of new messages just to find that one applicant's username?


Wish you had a better application managemet strategy? Well, then RB Recruiter is for you!


# Features (not exhaustive)
 - Beautiful (customizable in future releases) landing page for your application management center; It displays all available staff ranks
 - Contact form on landing page for those un-registerd users
 - User registration/authentication system; Users will be sent to the authentication flow to complete their application, if not logged in
 - Candidate tracking system - Applicants will be tracked from start to finish.
 - Peer approval system - Have all your staff members vote on applications and decide whether they should be accepted (this is overridable)
 - Interview scheduling (simple) - Schedule interviews with your candidates and automatically notify them!
   - Interview notes: Every staff member is able to add and edit interview notes (how the interview went, etc)
 - Application comments: Finally no more having to go to a private Discord channel just to comment on a single application. Comments are organised neatly for every application! This should help in the decision process of voting for an application.
 - User profiles - Fill out your profile for others to better find you
 - User directory - Public profile directory for everyone
 - Staff rank management - Add/remove ranks on demand, that users will be able to apply to
 - Simple form builder - Create your application forms easily!
 - Termination - Has a staff member met their untimely demise? Terminate them. This will strip their permissions and roles.
 - Controllable permissions - Every user has permissions! Control who has access to what (You can skip the application process and add staff members directly here).
 - Ban system - Having trouble with pesky spammers? Ban them! This will publicly shame their profile and keep them from signing up or logging in.
 - Notifications: Notifies slack and email primarily

 And many more features!

# Roadmap

Many other features are currently planned for this app, such as:
  - Customisable front page
  - REST API (underway)
  - Support more game servers and communities
  - Editable homepage
  - CKEditor 5 for all text fields
  - More form field types
  - Check out this [pull request](https://code.spacejewel-hosting.com/spacejewelhosting/staffmanager/pulls/1) for more planned features.
  - ~~Web installer~~

Next release: v0.7.0, which brings a number of fixes and a REST API to the table.

# Technical overview

Tech stack:
 - [Laravel 8](https://laravel.com/)
 - [Eloquent ORM](https://laravel.com/docs/5.0/eloquent)
 - [AdminLTE](https://adminlte.io/) / [Bootstrap 4](https://getbootstrap.com/docs/4.0/getting-started/introduction/)
 - [jQuery](https://jquery.com/)
 - [Bootstrap 4](https://getbootstrap.com/)
 - [Icons by FontAwesome](https://fontawesome.com/)
 
 # Stability
 
 Currently, the ``master`` branch is unusable. It's currently broken and bug-ridden, and it's also protected to prevent more broken commits. The development branch is currently the stable enough branch to be used, however, please note that it's still actively updated, albeit with less frequency. Rest assured that no broken commits will be uploaded to develop without testing first.
 
 After 1.0.0, master will be used as the main branch, receiving new, tested features from develop as pull requests. The master branch will only be usable and fixed after it's merged with develop.
 
 *Note: This application is NOT production ready! It won't be until the first stable release comes out, which might take a bit longer, due to me having other responsabilities outside this project.

# Operating System Requirements

 Currently, this application is only supported on Linux (any distro). No support will be provided for Windows installs. Sorry!


# Currently broken features
 - User deletion is not working at the moment.
 - Notifications are semi-broken; Sometimes they work, sometimes they don't. Scheduled to be fixed on next release.

 # PHP Extension Requirements

 - ImageMagick (imagick) for 2FA support

 Most of these extensions are already enabled by default so you don't need to worry.

 # Installation

The automatic installer may not work, but it's still worth to give it a try. If after the installation you find errors, clear the config cache. This is something the installer doesn't do correctly yet.

If errors presist, please install the app the traditional Laravel way. Execute the install script to start.

 # Configuration
Configuration is currently done via the installer. Alternatively, you may also edit the ``.env`` file directly.
~~This process will be moved to the browser later.~~

# Bug reports

Please report any bugs you find to the issues section. Since this project is being tracked on JIRA Software, the issue tracker will be moved to JIRA Service Desk. Atlassian has a great suite of products for software developers and RB Recruiter could benefit from this workflow, especially when more developers are added down the line.
