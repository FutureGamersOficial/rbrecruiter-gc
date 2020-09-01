# Raspberry Teams - The Simple Staff Application Manager v 0.5.2
## The quick and pain-free staff application manager

Have you ever gotten tired of managing your Minecraft server/network's applications through Discord (or anything else) and having to scroll through hundreds of new messages just to find that one applicant's username?


Wish you had a better application managemet strategy? Well, then Raspberry Teams is for you! It was originally designed and developed for internal use for a gameserver network, but sharing is caring!


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
  - Discord role management (approved applicants)
  - Luckperms/PEX integration - For now, you'll have to promote users manually in-game
  - Flexibility - This app is built on a flexible concept! It will be able to be used for other purposes other than MC staff members.
  - Customisable front page (**priority**)
  - Auto provisioning - Sign up on a website and get your instance of Raspberry Teams up and running in no time
  - Suggestions accepted!


# Technical overview

Tech stack:
 - [Laravel 7](https://laravel.com/)
 - Eloquent ORM
 - AdminLTE / Bootstrap 4
 - jQuery / Plain Javascript
 - vueJS (in the future)

# Operating System Requirements

 Currently, this application is only supported on Linux environments (Ubuntu 20.04 or derivatives are recommended).

# Software Requirements
 - ``composer`` (min version: 1.8.4)
 - ``npm`` (tested w/ v 5.8.0)
 - ``php`` (required PHP 7 or newer - lower versions unsupported!)

 # PHP Extension Requirements

 - JSON
 - Curl (highly recommended)
 - Image Magick (imagick) for 2FA support

 # Installation

 Make sure all prerequisites are installed. Afterwards, clone this repository, make ``install.sh``executable and run it.

 # Configuration
Configuration is currently done via the installer. Alternatively, you may also edit the ``.env`` file directly.
This process will be moved to the browser later.

# Bug reports

Please report any bugs you find to the issues section here! It'd be immensely helpful. PRs are also accepted.
