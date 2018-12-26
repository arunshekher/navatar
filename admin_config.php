<?php
require_once '../../class2.php';
if ( ! getperms('P') || ! e107::isInstalled('navatar')) {
	e107::redirect('admin');
	exit;
}

use Navatar\Plugin\Main;
use Navatar\Plugin\Models\User;

e107::lan('navatar','admin', true);


class NavatarAdmin extends e_admin_dispatcher
{

	protected $modes = [
	
		'main'	=> [
			'controller' 	=> 'navatar_ui',
			'path' 			=> null,
			'ui' 			=> 'navatar_form_ui',
			'uipath' 		=> null
		]

	];
	
	
	protected $adminMenu = [
			
		'main/prefs' => ['caption'=> LAN_PREFS, 'perm' => 'P'],
		'main/div0'      => ['divider'=> true],
		'main/tidyup'		=> ['caption'=> 'Tidy-up Wizard', 'perm' => 'P']

	];

	protected $adminMenuAliases = [
		'main/edit'	=> 'main/list'				
	];
	
	protected $menuTitle = 'Navatar';
}




				
class navatar_ui extends e_admin_ui
{
			
		protected $pluginTitle		= 'Navatar';
		protected $pluginName		= 'navatar';
	//	protected $eventName		= 'navatar-'; // remove comment to enable event triggers in admin. 		

		


		protected $preftabs        = ['General', 'Text', 'Color', 'Font' ];

		protected $prefs = [

			'activate' => [
				'title'=> 'Activate',
				'tab'=> 0,
				'type'=>'boolean',
				'data' => 'int',
				'help'=>'Activate NaVatar'
			],

			'user_trigger_event' => [
				'title'=> 'User event that trigger navatar generation:',
				'tab'=> 0,
				'type'=>'dropdown',
				'data' => 'int',
				'help'=> 'Which user event trigger generation of NaVatar.'
			],

			'job_queue_active' => [
				'title'=> 'Cron Job Queue Active:',
				'tab'=> 0,
				'type'=>'boolean',
				'data' => 'int',
				'help'=> 'Activate/Deactivate Cron Job Queue.'
			],

			'php_graphics_lib' => [
				'title'=> 'PHP Graphics Library:',
				'tab'=> 0,
				'type'=>'dropdown',
				'data' => 'str',
				'help'=> 'Which driver to use for NaVatar generation.'
			],

			'initials_source' => [
				'title'=> 'Initials source:',
				'tab'=> 1,
				'type'=>'dropdown',
				'data' => 'str',
				'help'=> 'Which source to use for initials - Username used on site or Real Name.'
			],

			'character_length' => [
				'title'=> 'Character Length:',
				'tab'=> 1,
				'type'=>'dropdown',
				'data' => 'int',
				'help'=>'The number of characters to use in initials.'
			],


			'font_color' => [
				'title'=> 'Font Color:',
				'tab'=> 2,
				'type'=>'text',
				'data' => 'str',
				'help'=>'The color of foreground text font.'
			],

			'background_colors' => [
				'title' => 'Background Color/s:',
				'tab'   => 2,
				'type'  => 'textarea',
				'data'  => 'str',
				'help'  => 'Background colors in hex format each color in new line or separated with pipe (|) sign.',
			],

			'random_bg_color' => [
				'title'=> 'Randomize background color:',
				'tab'=> 2,
				'type'=>'boolean',
				'data' => 'int',
				'help'=>'Randomize background color'
			],

			'font_size' => [
				'title'=> 'Font Size Factor:',
				'tab'=> 3,
				'type'=>'text',
				'data' => 'str',
				'help'=>'The size of font. Default value is: 0.5. If the Image size is 50px and fontSize is 0.5, the font size will be 25px.'
			],

			'font_variants' => [
				'title'=> 'Font Variants:',
				'tab'=> 3,
				'type'=>'dropdown',
				'data' => 'str',
				'help'=>'Font variant to use 4 local variants and others offered by GD library, Default is: OpenSans-Regular(local)'
			],



		];



	protected $intialsSource = [
		'username' => LAN_NAVATAR_PREF_VAL_USERNAME,
		'realname' => LAN_NAVATAR_PREF_VAL_REALNAME,
	];

	protected $characterLength = [
		1 => 1,
		2 => 2
	];

	protected $graphicsLibrary = [
		'gd' => 'GD',
		'imagick' => 'Imagick'
	];

	protected $userTrigger = [
		1 => 'Login Event',
		2 => 'Activation Event',
		3 => 'Login OR Activation Event'
	];

	
	public function init()
	{
		$this->prefs['initials_source']['writeParms'] = $this->intialsSource;
		$this->prefs['user_trigger_event']['writeParms'] = $this->userTrigger;
		$this->prefs['character_length']['writeParms'] = $this->characterLength;
		$this->prefs['php_graphics_lib']['writeParms'] = $this->graphicsLibrary;

	}




	public function tidyupPage()
	{
		$tp = e107::getParser();
		$frm = e107::getForm();
		$mes = e107::getMessage();

		// test
		//$this->listFiles();

		$this->tidyupPageProcess();

		$confirmText = $tp->lanVars(LAN_NAVATAR_TIDY_CONFIRM_ROLLBACK, ['count' => User::count()]);
		$mes->addInfo(LAN_NAVATAR_TIDY_INFO);
		$message = $mes->render();

		$text = '
		<form method="post" action="' . e_SELF . '?' . e_QUERY . '">
		' . $frm->checkbox('confirm-delete', 1, false, $confirmText) . '
		' . $frm->admin_button('navatar-tidyup', 'Rollback Records', 'submit') . '
		</form>';

		return $message . $text;
	}


	public function tidyupPageProcess()
	{
		$mes = e107::getMessage();

		if (strtolower($_SERVER['REQUEST_METHOD']) === 'post' && isset($_POST['navatar-tidyup'])) {

			if (isset($_POST['confirm-delete'])) {

				if (User::rollback()) {
					return $mes->addSuccess('Record(s) rolled back successfully');
				}
				return $mes->addError('Nothing to rollback.');
			}
			return $mes->addWarning('Please tick confirm checkbox. Nothing rolled back.');
		}
		return false;
	}


	protected function listFiles()
	{
		$files = [];
		foreach (glob(e_AVATAR_UPLOAD . '*_navatar.png') as $filename) {
			//echo "$filename size " . filesize($filename) . "\n";
			$files[] = "$filename size: " . filesize($filename);
		}
		Main::log($files, 'navatar-upload-dir');
		//return $files;
	}


	public function renderHelp()
	{
		$template   = e107::getTemplate('navatar', 'project_menu');
		$text = e107::getParser()->parseTemplate(
			$template,
			true,
			[
				'DEV_SUPPORT' => LAN_NAVATAR_INFO_MENU_SUPPORT_DEV_TEXT,
				'SIGN' => LAN_NAVATAR_INFO_MENU_SUPPORT_DEV_TEXT_SIGN
			]
		);

		return [
			'caption' =>  LAN_NAVATAR_INFO_MENU_TITLE,
			'text' => $text
		];

	}

}



				


class navatar_form_ui extends e_admin_form_ui
{

}		
		
		
new NavatarAdmin();

require_once e_ADMIN. 'auth.php';
e107::getAdminUI()->runPage();

require_once e_ADMIN. 'footer.php';
exit;

