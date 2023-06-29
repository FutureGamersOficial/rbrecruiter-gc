# Archival notice

This repository is now archived! RBRecruiter has moved from one version control system to the next, from Gitea to BitBucket and now GitHub, but RBRecruiter now has a more or less permanent home in a privately-owned GitLab EE instance. RBRecruiter also changed its name to something else.

**Does this mean the project is dead?**

No, not at all! This project is still being actively updated in the other repo. In fact, version 1 is already out as well. When I'm ready to share it, I'll update the link here and officially archive the repo (adding that yellow banner). This is because I'm still decoupling the repo from my community; It's been heavily modified and hard-coded to be used in one of my Discord communities, and so I'm now removing all those references and moving it to its own organization in GitLab. This should have been a fork from the start and not a major modification to the software itself, considering it would probably be used by a lot of other people.

Once this is done, the link will be posted here. Also, if you want to take a look at the demo [one is available here](https://demo.athenahr.io), which is pulling from the latest changes.


# RB Recruiter v 0.8.0 [![Crowdin](https://badges.crowdin.net/raspberry-staff-manager/localized.svg)](https://crowdin.com/project/raspberry-staff-manager) [![Better Uptime Badge](https://betteruptime.com/status-badges/v1/monitor/9n53.svg)](https://betteruptime.com/?utm_source=status_badge)
## The quick and pain-free form management solution for communities

Have you ever gotten tired of managing your Minecraft server/network's applications through Discord (or anything else) and having to scroll through hundreds of new messages just to find that one applicant's username?


Wish you had a better application management strategy? Well, then RBRecruiter is for you! It was originally designed and developed for internal use for a gameserver network, but sharing is caring!


# Features (not exhaustive)
 - Beautiful (customizable in future releases) landing page for your application management centre; It displays all available staff ranks
 - Contact form on the landing page for those un-registered users
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
 - Notifications: Notifies Slack and email primarily (Slack notifications are currently broken)

 And many more features!

# Roadmap

Many other features are currently planned for this app, such as:
  - Discord role management (approved applicants)
  - Flexibility - This app is built on a flexible concept.
  - Customisable front page
  - Auto-provisioning - Sign up on a website and get your instance of RBRecruiter up and running in no time (SaaS)
  - 
  - Suggestions accepted!


# Technical overview

Tech stack:
 - [Laravel 9](https://laravel.com/)
 - [Eloquent ORM](https://laravel.com/docs/5.0/eloquent)
 - [AdminLTE](https://adminlte.io/) / 
 - [Bootstrap 4](https://getbootstrap.com/docs/4.0/getting-started/introduction/)
 - [jQuery](https://jquery.com/)
 - [Icons by FontAwesome](https://fontawesome.com/)
 
 # Stability
 
 Every released version is currently pre-release. The ``main`` branch is currently stable and ready to use, however, we don't recommend updating your app until a new release comes out.
 
 At the moment, each new feature goes into its separate branch so that ``main`` remains stable. When the features being worked on are ready and tested, they are merged onto ``main``, and a new release can be started. The main branch is write-protected.
 
 *Note: This application is NOT production ready! It won't be until the first stable release comes out, which might take a bit longer.

# Operating System Requirements

 Currently, this application is only supported on Linux environments (Ubuntu 20.04 or derivatives are recommended).

# Software Requirements
 - ``composer`` (tested w/ v2.1.14)
 - ``npm`` (tested w/ v 8.1.2)
 - ``node`` (min version v16.13.2)
 - ``php`` (required PHP 8.1 or newer - lower versions unsupported!)

 # PHP Extension Requirements

 - JSON
 - xDebug (will be removed in the future as a require-dev-only dependency)
 - Curl
 - Xml 
 - MySQL adapter (mysqli extension)

 # Installation

 ~~Make sure all prerequisites are installed. Afterwards, clone this repository, make ``install.sh``executable and run it.~~
 
 New instructions WIP.

 # Configuration
Configuration is currently done via the installer. Alternatively, you may also edit the ``.env`` file directly.
This process will be moved to the browser later.

# Bug reports

Please report any bugs you find to the issues section here! It'd be immensely helpful. PRs are also accepted.
