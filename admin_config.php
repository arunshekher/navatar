<?php
require_once '../../class2.php';
if (!getperms('P'))
{
	e107::redirect('admin');
	exit;
}

class NavatarAdmin extends e_admin_dispatcher
{
	protected $modes = [
		'main' => [
			'controller' => 'NavatarAdminController',
			'path' => null,
			'ui' => 'NavatarAdminFormUi',
			'uipath' => null
		]
	];

	protected $adminMenu = [
		'main/prefs' => ['caption'=> 'Settings', 'perm' => '0']
	];

	protected $menuTitle = 'Navatar';

}

class NavatarAdminController extends e_admin_ui
{
	protected $pluginTitle = 'Navatar';
	protected $pluginName = 'navatar';

	protected $prefs = [
		'navatar_active' => [
			'title' => 'Activate Navatar',
			'tab' => 0,
			'type' => 'boolean',
			'data' => 'int',
			'help' => 'Activate/deactivate navatar plugin'
		]

	];

}

class NavatarAdminFormUi extends e_admin_form_ui
{

}

new NavatarAdmin();

require_once e_ADMIN. 'auth.php';

e107::getAdminUI()->runPage();

 require_once e_ADMIN. 'footer.php';
