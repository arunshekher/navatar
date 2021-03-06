[![License: AGPL v3](https://img.shields.io/badge/License-AGPL%20v3-blue.svg)](https://www.gnu.org/licenses/agpl-3.0)
[![Join the chat at https://gitter.im/navatar-e107/community](https://badges.gitter.im/navatar-e107/community.svg)](https://gitter.im/navatar-e107/community?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)
# Navatar
Name + Avatar = 'Navatar', connotes 'New Avatar!'  
An e107 CMS plugin that incarnates user avatar from your initials.

![navatar](https://user-images.githubusercontent.com/315195/50542002-542cce80-0bcb-11e9-902e-8a3177fe1aa4.gif)

# Description
Navatar is a wrapped/encapsulated implementation of the awesome php library by Lasse Rafn named [php-initial-avatar-generator](https://github.com/LasseRafn/php-initial-avatar-generator "php-initial-avatar-generator"). Navatar uses initials from usernames or real names of site users to automatically generate avatar images if they haven't uploaded their own.

# Requirements
* PHP 5.6, 7.0, 7.1 or 7.2
* Fileinfo Extension (required by intervention/image)
* GD Library (>=2.0) or Imagick PHP extension (>=6.5.7)

# Installing Dependencies
When downloading this plugin directly via the e107 plugin manager in the admin area or from the [e107.org](https://e107.org/) official website the package lacks dependencies required for the plugin to work, this is due to upload size limitation at e107.org. You'll have to fetch these dependencies using [composer](https://getcomposer.org/) or download the whole package from [plugin repository here in Github](https://github.com/arunshekher/navatar "Navatar Repository").  

To install the dependencies using composer run the following command in the plugin directory:  

`composer install`  

If your web-server does not allow running commands in a secure shell session; or for any other reasons, you may download the plugin from its repository here and upload it manually using FTP or other means.

# Contributions
Community contributions to Navatar plugin are welcome. Since the project is still in its infancy there are specific priorities for development right now. Please take a look at project [roadmap](https://github.com/arunshekher/navatar/projects/1 "Navatar Roadmap") before contributing via issues and pull requests.

### Ways to contribute
* File issues against the bugs you encounter.
* Submit pull requests to - fix errors, squash bugs, refactor for performance, include language packs
* Submit feature requests - for added functionality, admin options etc.
* Express gratitude - scientific studies continually prove that it can make you happier!! :wink: The motivation it's gonna endow me with is just a side-effect. :laughing: :heart_eyes:
* Heat up the development arms-race for e107 by writing some plugins yourselves: - biological evolutionary arms-race has produced some of the most resilient organisms in real world. May be it applies equally in the virtual world!


# Release History
+ Jan 08, 2019 [v1.1.0-rc.1](https://github.com/arunshekher/navatar/releases/tag/v1.1.0-rc.1) - release candidate 1
+ Dec 30, 2018 [v1.0.4-beta.3](https://github.com/arunshekher/navatar/releases/tag/v1.0.4-beta.3) - beta release
