[![License: AGPL v3](https://img.shields.io/badge/License-AGPL%20v3-blue.svg)](https://www.gnu.org/licenses/agpl-3.0)
[![Join the chat at https://gitter.im/navatar-e107/Lobby](https://badges.gitter.im/navatar-e107/Lobby.svg)](https://gitter.im/navatar-e107/Lobby?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)
# Navatar
Name + Avatar = 'Navatar', connotes 'New Avatar!'
An e107 CMS plugin that incarnates (generates) user avatar from your initials.

![navatar](https://user-images.githubusercontent.com/315195/50542002-542cce80-0bcb-11e9-902e-8a3177fe1aa4.gif)

# Description
Navatar is a wrapped/encapsulated implementation of the awesome php library by Lasse Rafn named [php-initial-avatar-generator](https://github.com/LasseRafn/php-initial-avatar-generator "php-initial-avatar-generator"). Navatar uses initials from usernames or real names of site users to automatically generate avatar images if they haven't uploaded their own.

# Requirements
* PHP 5.6, 7.0, 7.1 or 7.2
* Fileinfo Extension (required by intervention/image)
* GD Library (>=2.0) or Imagick PHP extension (>=6.5.7)

# Installing Dependencies
If you are downloading this plugin directly via the e107 plugin manager in the admin area or from the e107.org official website's plugin download area (as and when the plugin gets approved) you do not have all the dependencies required for the plugin to work in the package you get, this is due to the plugin upload size limitations there. You'll have to acquire these dependencies manually using a php dependency manager called composer.

To install the dependencies defined for this plugin in its composer.json, you need to run the following command in the plugin directory after installing composer:

`composer install`

If your webserver does not allow running commands in a secure shell session, you may acquire these dependencies locally by installing composer in your local machine pulling the dependencies and then FTP-ing it to your hosting space or you may download the plugin package with all dependencies from this github repository.

Please read this guideline to install composer for your OS if you don't have it already - https://getcomposer.org/doc/00-intro.md

# Contributions
Community contributions to Navatar plugin are welcome. Since the project is still in its infancy there are specific priorities for development right now. Please take a look at project [roadmap](https://github.com/arunshekher/navatar/projects/1 "Navatar Roadmap") before contributing via issues and pull requests.

### Ways to contribute
* File issues against the bugs you encounter.
* Submit pull requests to - fix errors, squash bugs, refactor for performance, include language packs
* Submit feature requests - for added functionality, admin options etc.
* Express gratitude - scientific studies continually prove that it can make you happier!! :wink: The motivation it's gonna give me is just a side-effect. :laughing: :heart_eyes:
* Heat up the development arms-race for e107 by writing some plugins yourselves: - biological evolutionary arms-race has produced some of the most resilient organisms in real world. May be it applies equally in the virtual world!


# Release History
+ Dec 30, 2018 [v1.0.4-beta.3](https://github.com/arunshekher/navatar/releases/tag/v1.0.4-beta.3) - beta release
