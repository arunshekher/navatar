<?php
require_once '../../class2.php';
if ( ! getperms('P') || ! e107::isInstalled('navatar')) {
	e107::redirect('admin');
	exit;
}

use Navatar\Plugin\Controllers\Font;
use Navatar\Plugin\Controllers\Navatar;
use Navatar\Plugin\Main;
use Navatar\Plugin\Models\User;
use Navatar\Plugin\Controllers\File;

e107::lan('navatar', 'admin', true);


class NavatarAdmin extends e_admin_dispatcher
{

	protected $modes = [

		'main' => [
			'controller' => 'navatar_ui',
			'path'       => null,
			'ui'         => 'navatar_form_ui',
			'uipath'     => null,
		],

	];


	protected $adminMenu = [

		'main/prefs'  => ['caption' => LAN_PREFS, 'perm' => 'P'],
		'main/div0'   => ['divider' => true],
		'main/tidyup' => ['caption' => 'Tidy-up Wizard', 'perm' => 'P'],

	];

	protected $adminMenuAliases = [
		'main/edit' => 'main/list',
	];

	protected $menuTitle = 'Navatar';
}


class navatar_ui extends e_admin_ui
{

	protected $pluginTitle = 'Navatar';
	protected $pluginName = 'navatar';
	//	protected $eventName		= 'navatar-'; // remove comment to enable event triggers in admin. 		

	protected $preftabs = ['General', 'Text', 'Color', 'Font', 'Schedule'];

	protected $prefs = [

		'master_active' => [
			'title' => 'Activate',
			'tab'   => 0,
			'type'  => 'boolean',
			'data'  => 'int',
			'help'  => 'Activate Navatar',
		],

		'user_trigger_event' => [
			'title' => 'User event that trigger navatar generation:',
			'tab'   => 0,
			'type'  => 'dropdown',
			'data'  => 'str',
			'help'  => 'Which user event trigger generation of Navatar.',
		],

		'php_graphics_lib' => [
			'title' => 'PHP Graphics Library:',
			'tab'   => 0,
			'type'  => 'dropdown',
			'data'  => 'str',
			'help'  => 'Which driver to use for Navatar generation.',
		],

		'navatar_size' => [
			'title' => 'Navatar Image Size:',
			'tab'   => 0,
			'type'  => 'text',
			'data'  => 'int',
			'help'  => 'Navatar Image Size. Default is 48x48 pixels.',
		],

		'navatar_quality' => [
			'title' => 'Image Quality:',
			'tab'   => 0,
			'type'  => 'text',
			'data'  => 'int',
			'help'  => 'Quality of generated Navatar image.',
		],

		'initials_source' => [
			'title' => 'Initials source:',
			'tab'   => 1,
			'type'  => 'dropdown',
			'data'  => 'str',
			'help'  => 'Which source to use for initials - Username used on site or Real Name.',
		],

		'character_length' => [
			'title' => 'Character Length:',
			'tab'   => 1,
			'type'  => 'dropdown',
			'data'  => 'int',
			'help'  => 'The number of characters to use in initials.',
		],

		'font_color' => [
			'title' => 'Foreground (Font) Color:',
			'tab'   => 2,
			'type'  => 'text',
			'data'  => 'str',
			'help'  => 'The color of foreground text font.',
		],

		'background_colors' => [
			'title' => 'Background Color(s):',
			'tab'   => 2,
			'type'  => 'textarea',
			'data'  => 'str',
			'help'  => 'Background colors in hex format each color in new line or separated with pipe (|) sign.',
		],

		'random_bg_color' => [
			'title' => 'Randomize background color:',
			'tab'   => 2,
			'type'  => 'boolean',
			'data'  => 'int',
			'help'  => 'Randomize background color',
		],

		'font_size' => [
			'title' => 'Font Size Factor:',
			'tab'   => 3,
			'type'  => 'text',
			'data'  => 'str',
			'help'  => 'The size of font. Default value is: 0.5. If the Image size is 50px and fontSize is 0.5, the font size will be 25px.',
		],

		'font_variant' => [
			'title' => 'Font Variants:',
			'tab'   => 3,
			'type'  => 'dropdown',
			'data'  => 'str',
			'help'  => 'Select font variant.',
		],

		'job_queue_active' => [
			'title' => 'Activate/Deactivate Cron Job Queue: (Not Implemented)',
			'tab'   => 4,
			'type'  => 'boolean',
			'data'  => 'int',
			'help'  => 'Not yet implemented.',
		],

	];


	protected $intialsSource = [
		'username' => LAN_NAVATAR_PREF_VAL_USERNAME,
		'realname' => LAN_NAVATAR_PREF_VAL_REALNAME,
	];

	protected $characterLength = [
		1 => 1,
		2 => 2,
	];

	protected $graphicsLibrary = [
		'gd'      => 'GD',
		'imagick' => 'Imagick',
	];

	protected $userTrigger = [
		'login'    => 'Login Event',
		'activate' => 'Activation Event',
		'both'     => 'Login OR Activation Event',
	];


	public function init()
	{
		$this->prefs['initials_source']['writeParms'] = $this->intialsSource;
		$this->prefs['user_trigger_event']['writeParms'] = $this->userTrigger;
		$this->prefs['character_length']['writeParms'] = $this->characterLength;
		$this->prefs['php_graphics_lib']['writeParms'] = $this->graphicsLibrary;
		$this->prefs['font_variant']['writeParms'] = Font::index();

	}


	public function tidyupPage()
	{
		$tp = e107::getParser();
		$frm = e107::getForm();
		$mes = e107::getMessage();


		$this->tidyupPageProcess();

		$userCount =
			'<span class="badge badge-warning">' . User::count() . '</span>';
		$confirmText = $tp->lanVars(LAN_NAVATAR_TIDY_CONFIRM_ROLLBACK,
			['count' => $userCount, 'user' => MPREFIX . 'user']);
		$mes->addInfo(LAN_NAVATAR_TIDY_INFO, 'navatar-mstack');
		$message = $mes->render('navatar-mstack');
		$mes->reset('navatar-mstack');

		$text = '
		<form method="post" action="' . e_SELF . '?' . e_QUERY . '">
		 <div class="form-group">
		' . $frm->checkbox('confirm-delete', 1, false,
				['label' => $confirmText, 'class' => 'form-check-label']) . '
		</div>
		' . $frm->admin_button('navatar-tidyup', 'Rollback Records', 'submit') . '
		</form>';

		return $message . $text;
	}


	public function tidyupPageProcess()
	{
		$mes = e107::getMessage();
		$tp = e107::getParser();

		if (strtolower($_SERVER['REQUEST_METHOD']) === 'post' && isset($_POST['navatar-tidyup'])) {

			if (isset($_POST['confirm-delete'])) {

				if (User::rollback()) {

					$mes->addSuccess(LAN_NAVATAR_TIDY_MES_SUC_RECORDS_REMOVED,
						'navatar-mstack');

					$removal = File::remove('*');

					if (count($removal['fail']) > 0) {
						$failMessage =
							$tp->lanVars(LAN_NAVATAR_TIDY_MES_WARN_FAIL_DELETE,
								['files' => implode(', ', $removal['fail'])]);

						return $mes->addWarning($failMessage, 'navatar-mstack');
					}

					return $mes->addStack(LAN_NAVATAR_TIDY_MES_SUC_FILES_REMOVED,
						'navatar-mstack', E_MESSAGE_SUCCESS);

				}

				return $mes->addError(LAN_NAVATAR_TIDY_MES_ERR_NO_RECORDS,
					'navatar-mstack');
			}

			return $mes->addWarning(LAN_NAVATAR_TIDY_MES_WARN_TICK,
				'navatar-mstack');
		}

		return false;
	}


	public function renderHelp()
	{
		$template = e107::getTemplate('navatar', 'project_menu');
		$text = e107::getParser()->parseTemplate($template, true, [
				'DEV_SUPPORT' => LAN_NAVATAR_INFO_MENU_SUPPORT_DEV_TEXT,
				'SIGN'        => LAN_NAVATAR_INFO_MENU_SUPPORT_DEV_TEXT_SIGN,
			]);

		return [
			'caption' => LAN_NAVATAR_INFO_MENU_TITLE,
			'text'    => $text,
		];

	}


	protected function listFiles()
	{
		$files = [];
		foreach (glob(e_AVATAR_UPLOAD . '*_navatar.png') as $filename) {
			$files[] = "$filename size: " . filesize($filename);
		}

		return $files;
	}

}


class navatar_form_ui extends e_admin_form_ui
{

}


new NavatarAdmin();

require_once e_ADMIN . 'auth.php';
e107::getAdminUI()->runPage();

require_once e_ADMIN . 'footer.php';
exit;

