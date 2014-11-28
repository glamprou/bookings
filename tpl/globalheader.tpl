<?xml version="1.0" encoding="{$Charset}"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
		"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html
		xmlns="http://www.w3.org/1999/xhtml" lang="{$HtmlLang}" xml:lang="{$HtmlLang}" dir="{$HtmlTextDirection}">
<head>
	<title>{if $TitleKey neq ''}{translate key=$TitleKey args=$TitleArgs}{else}{$Title}{/if}</title>
	<meta http-equiv="Content-Type" content="text/html; charset={$Charset}"/>
	<meta name="robots" content="noindex" />
{if $ShouldLogout}
	<meta http-equiv="REFRESH" content="{$SessionTimeoutSeconds};URL={$Path}logout.php?{QueryStringKeys::REDIRECT}={$smarty.server.REQUEST_URI|urlencode}">
{/if}
	<link rel="shortcut icon" href="{$Path}favicon.ico"/>
	<link rel="icon" href="{$Path}favicon.ico"/>
    {if $rankingCss}
        <link href="{$rankingCss}" rel="stylesheet" type="text/css" />
    {/if}
	{if $UseLocalJquery}
		<script type="text/javascript" src="{$Path}scripts/js/jquery-1.8.2.min.js"></script>
		<script type="text/javascript" src="{$Path}scripts/js/jquery-ui-1.9.0.custom.min.js"></script>
	{else}
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.0/jquery-ui.min.js"></script>
	{/if}
	<script type="text/javascript" src="{$Path}scripts/phpscheduleit.js"></script>
	<script type="text/javascript" src="{$Path}scripts/menubar.js"></script>
	<style type="text/css">
		@import url({$Path}css/nav.css);
		@import url({$Path}css/style.css);
		{if $UseLocalJquery}
			@import url({$Path}scripts/css/smoothness/jquery-ui-1.9.0.custom.min.css);
		{else}
			@import url(//ajax.googleapis.com/ajax/libs/jqueryui/1.9.0/themes/smoothness/jquery-ui.css);
		{/if}
		{if $cssFiles neq ''}
			{assign var='CssFileList' value=','|explode:$cssFiles}
			{foreach from=$CssFileList item=cssFile}
			@import url({$Path}{$cssFile});
			{/foreach}
		{/if}
		@import url('{$Path}css/{$CssUrl}');
		{if $CssExtensionFile neq ''}
			@import url('{$CssExtensionFile}');
		{/if}
	</style>

	{if $printCssFiles neq ''}
		{assign var='PrintCssFileList' value=','|explode:$printCssFiles}
		{foreach from=$PrintCssFileList item=cssFile}
		<link rel='stylesheet' type='text/css' href='{$Path}{$cssFile}' media='print' />
		{/foreach}
	{/if}

	<script type="text/javascript">
		$(document).ready(function () {
		initMenu();
		});
	</script>
</head>
<body>
<div id="wrapper">
	<div id="doc">
		<div id="header">
            <div id="logo"><a href="{$HomeUrl}">{html_image src="$LogoUrl"}</a></div>
			<div id="header-top">
				<div id="signout">
				{if $LoggedIn}
					{translate key="SignedInAs"} {$UserName}<br/><a href="{$Path}logout.php">{translate key="SignOut"}</a>
					{else}
					{translate key="NotSignedIn"}<br/><a href="{$Path}index.php">{translate key="LogIn"}</a>
				{/if}
				</div>
			</div>
			<ul id="nav" class="menubar">
			{if $LoggedIn}
				<li class="menubaritem first"><a href="{$Path}{Pages::DASHBOARD}">{translate key="Dashboard"}</a></li>
                <li class="menubaritem"><a href="{$Path}{Pages::PROFILE}">{translate key="MyAccount"}</a>
                    <ul>
                        <li class="menuitem"><a href="{$Path}{Pages::PROFILE}">{translate key="Profile"}</a></li>
                        <li class="menuitem"><a href="{$Path}{Pages::PASSWORD}">{translate key="ChangePassword"}</a></li>
                        {*<li class="menuitem"><a href="{$Path}reports/{Pages::REPORTS_COMMON}">{translate key="Reports"}</a></li>*}
                    </ul>
                </li>
				<li class="menubaritem"><a href="{$Path}{Pages::SCHEDULE}">{translate key="Schedule"}</a></li>
                <li class="menubaritem"><a href="javascript: void(0);">{translate key="PointSystem"}</a>
                	<ul>
						<li class="menuitem"><a href="{$Path}{Pages::RANKING}">{translate key="Ranking"}</a></li>
						<li class="menuitem"><a href="{$Path}{Pages::CALLS}">{translate key="Calls"}</a></li>
                        <li class="menuitem"><a href="{$Path}{Pages::TOURNAMENTS}">{translate key="Tours"}</a></li>
					</ul>
                </li>
			{if $CanViewAdmin}
				<li class="menubaritem"><a href="#">{translate key=ApplicationManagement}</a>
					<ul>
                        <li class="menuitem"><a href="{$Path}admin/manage_reservations.php">{translate key="ManageReservations"}</a></li>
                        <li class="menuitem"><a href="{$Path}admin/manage_resources.php">{translate key="ManageResources"}</a></li>
						<li class="menuitem"><a href="{$Path}admin/manage_users.php">{translate key="ManageUsers"}</a></li>

						<li class="menuitem"><a href="{$Path}admin/manage_groups.php">{translate key="ManageGroups"}</a></li>
                        <li class="menuitem"><a href="{$Path}admin/manage_quotas.php">{translate key="ManageQuotas"}</a></li>
						<li class="menuitem"><a href="{$Path}admin/manage_announcements.php">{translate key="ManageAnnouncements"}</a></li>
                        <li class="menuitem"><a href="{$Path}admin/manage_attributes.php">{translate key="Customization"}</a>
						{*<li class="menuitem"><a href="#">{translate key="Reports"}</a>
                            <ul>
                                <li class="menuitem"><a href="{$Path}reports/{Pages::REPORTS_GENERATE}">{translate key="GenerateReport"}</a></li>
                                <li class="menuitem"><a href="{$Path}reports/{Pages::REPORTS_SAVED}">{translate key="MySavedReports"}</a></li>
                                <li class="menuitem"><a href="{$Path}reports/{Pages::REPORTS_COMMON}">{translate key="CommonReports"}</a></li>
                            </ul>
                        </li>*}
                        <li class="menuitem"><a href="#">{translate key="RankingCustomization"}</a>
                            <ul>
                                <li class="menuitem"><a href="{$Path}{Pages::RANKING_ADMINISTRATION}">{translate key="RankingAdmin"}</a></li>
                                <li class="menuitem"><a href="{$Path}{Pages::RANKING_VARIABLES}">{translate key="RankingVars"}</a></li>
                            </ul>
                        </li>
                        <li class="menuitem"><a href="{$Path}reports/generate-report.php">{translate key="Search"}</a></li>
					</ul>
				</li>
			{/if}
			{/if}
			</ul>
			<!-- end #nav -->
		</div>
		<!-- end #header -->
		<div id="content">