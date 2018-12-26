<?php
if (!defined('e107_INIT')) { exit; }

if (deftrue('BOOTSTRAP') && deftrue('FONTAWESOME')) {
	define('NAVATAR_GITHUB_ICON',
		e107::getParser()->toGlyph('fa-github-alt', ['size' => '2x']));
	define('NAVATAR_HEART_ICON', e107::getParser()->toGlyph('fa-heart'));
	define('NAVATAR_SMILE_ICON', e107::getParser()->toGlyph('fa-smile-o', ['size' => '2x']));
} else {
	define('NAVATAR_GITHUB_ICON', '&nbsp;');
	define('NAVATAR_HEART_ICON', '&nbsp;');
	define('NAVATAR_SMILE_ICON', ':)');
}

$PROJECT_MENU_TEMPLATE = '
<div style="text-align: center">
<img src="https://www.e107.space/projects/navatar/svg" alt="NaVatar" width="128" height="128">
</div>
<ul class="list-unstyled">
	<li>
		<h5>' . NAVATAR_GITHUB_ICON . '&nbsp;' . LAN_NAVATAR_INFO_MENU_SUBTITLE . '</h5>
	</li>
	<li>
		<kbd style="word-wrap: break-word;font-size: x-small">
			<a href="https://github.com/arunshekher/navatar" target="_blank">https://github.com/arunshekher/navatar</a>
		</kbd>
	</li>
	<li>&nbsp;</li>
	<li class="text-center">
		<a class="github-button" href="https://github.com/arunshekher/mentions/subscription" data-icon="octicon-eye" aria-label="Watch arunshekher/mentions on GitHub">Watch</a>
		<a class="github-button" href="https://github.com/arunshekher/mentions" data-icon="octicon-star" aria-label="Star arunshekher/mentions on GitHub">Star</a>
	</li>
	<li>
		<h5>' . LAN_NAVATAR_INFO_MENU_SUBTITLE_ISSUES . '</h5>
	</li>
	<li>
	<p>
		<small>' . LAN_NAVATAR_INFO_MENU_ISSUES_TEXT . '</small>
	</p>
	</li>
	<li class="text-center">
		<a class="github-button" href="https://github.com/arunshekher/navatar/issues" data-icon="octicon-issue-opened" data-size="large" data-show-count="true" aria-label="Issue arunshekher/navatar on GitHub">Issue</a>
	</li>
	<li style="border-bottom: solid 1px dimgrey" class="divider">&nbsp;</li>
	<li>
		<h5>' . NAVATAR_HEART_ICON . '&nbsp;' . LAN_NAVATAR_INFO_MENU_SUBTITLE_DEV . '</h5>
	</li>
	<li>
		<p>
			<small>{DEV_SUPPORT}</small>
		</p>
	</li>
	<li class="text-center">
		<script type="text/javascript" src="https://ko-fi.com/widgets/widget_2.js"></script>
		<script type="text/javascript">kofiwidget2.init("Buy Me a Coffee", "#46b798", "E1E4B43T");kofiwidget2.draw();</script>  
	</li>
	<li></li>
	<li class="text-center" style="height: 50px">&nbsp;
		<script src="https://www.e107.space/bcwidget/coin.js"></script>
	<script>
	CoinWidget.go({
		wallet_address: "1FgXdXePYLGSsyDztWvZw99Ki3i2eVWbDe", 
		currency: "bitcoin", 
		counter: "hide", 
		alignment: "bc", 
		qrcode: true, 
		auto_show: false, 
		lbl_button: "Donate Bitcoins", 
		lbl_address: "Donate bitcoin to this address:"
	});
	</script>
	</li>
	<li></li>
	
	<li class="text-center">
		<p style="padding-top:10px;">
			<small>{SIGN}</small>
		</p>
		<p>' . NAVATAR_SMILE_ICON .'</p>
	</li>
</ul>
<script async defer src="https://buttons.github.io/buttons.js"></script>';