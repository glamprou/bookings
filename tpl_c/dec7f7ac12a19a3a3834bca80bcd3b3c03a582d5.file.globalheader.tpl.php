<?php /* Smarty version Smarty-3.1.7, created on 2014-09-05 18:15:46
         compiled from "/home/acetenni/public_html/bookings/lib/Common/../../tpl/globalheader.tpl" */ ?>
<?php /*%%SmartyHeaderCode:4190425495409efc21a42f8-08759082%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'dec7f7ac12a19a3a3834bca80bcd3b3c03a582d5' => 
    array (
      0 => '/home/acetenni/public_html/bookings/lib/Common/../../tpl/globalheader.tpl',
      1 => 1409936867,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4190425495409efc21a42f8-08759082',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'Charset' => 0,
    'HtmlLang' => 0,
    'HtmlTextDirection' => 0,
    'TitleKey' => 0,
    'TitleArgs' => 0,
    'Title' => 0,
    'ShouldLogout' => 0,
    'SessionTimeoutSeconds' => 0,
    'Path' => 0,
    'rankingCss' => 0,
    'UseLocalJquery' => 0,
    'cssFiles' => 0,
    'CssFileList' => 0,
    'cssFile' => 0,
    'CssUrl' => 0,
    'CssExtensionFile' => 0,
    'printCssFiles' => 0,
    'PrintCssFileList' => 0,
    'HomeUrl' => 0,
    'LoggedIn' => 0,
    'UserName' => 0,
    'CanViewAdmin' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5409efc22d66f',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5409efc22d66f')) {function content_5409efc22d66f($_smarty_tpl) {?><?php echo '<?xml';?> version="1.0" encoding="<?php echo $_smarty_tpl->tpl_vars['Charset']->value;?>
"<?php echo '?>';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
		"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html
		xmlns="http://www.w3.org/1999/xhtml" lang="<?php echo $_smarty_tpl->tpl_vars['HtmlLang']->value;?>
" xml:lang="<?php echo $_smarty_tpl->tpl_vars['HtmlLang']->value;?>
" dir="<?php echo $_smarty_tpl->tpl_vars['HtmlTextDirection']->value;?>
">
<head>
	<title><?php if ($_smarty_tpl->tpl_vars['TitleKey']->value!=''){?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>$_smarty_tpl->tpl_vars['TitleKey']->value,'args'=>$_smarty_tpl->tpl_vars['TitleArgs']->value),$_smarty_tpl);?>
<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['Title']->value;?>
<?php }?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_smarty_tpl->tpl_vars['Charset']->value;?>
"/>
	<meta name="robots" content="noindex" />
<?php if ($_smarty_tpl->tpl_vars['ShouldLogout']->value){?>
	<meta http-equiv="REFRESH" content="<?php echo $_smarty_tpl->tpl_vars['SessionTimeoutSeconds']->value;?>
;URL=<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
logout.php?<?php echo QueryStringKeys::REDIRECT;?>
=<?php echo urlencode($_SERVER['REQUEST_URI']);?>
">
<?php }?>
	<link rel="shortcut icon" href="<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
favicon.ico"/>
	<link rel="icon" href="<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
favicon.ico"/>
    <?php if ($_smarty_tpl->tpl_vars['rankingCss']->value){?>
        <link href="<?php echo $_smarty_tpl->tpl_vars['rankingCss']->value;?>
" rel="stylesheet" type="text/css" />
    <?php }?>
	<?php if ($_smarty_tpl->tpl_vars['UseLocalJquery']->value){?>
		<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
scripts/js/jquery-1.8.2.min.js"></script>
		<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
scripts/js/jquery-ui-1.9.0.custom.min.js"></script>
	<?php }else{ ?>
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.0/jquery-ui.min.js"></script>
	<?php }?>
	<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
scripts/phpscheduleit.js"></script>
	<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
scripts/menubar.js"></script>
	<style type="text/css">
		@import url(<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
css/nav.css);
		@import url(<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
css/style.css);
		<?php if ($_smarty_tpl->tpl_vars['UseLocalJquery']->value){?>
			@import url(<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
scripts/css/smoothness/jquery-ui-1.9.0.custom.min.css);
		<?php }else{ ?>
			@import url(//ajax.googleapis.com/ajax/libs/jqueryui/1.9.0/themes/smoothness/jquery-ui.css);
		<?php }?>
		<?php if ($_smarty_tpl->tpl_vars['cssFiles']->value!=''){?>
			<?php $_smarty_tpl->tpl_vars['CssFileList'] = new Smarty_variable(explode(',',$_smarty_tpl->tpl_vars['cssFiles']->value), null, 0);?>
			<?php  $_smarty_tpl->tpl_vars['cssFile'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['cssFile']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['CssFileList']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['cssFile']->key => $_smarty_tpl->tpl_vars['cssFile']->value){
$_smarty_tpl->tpl_vars['cssFile']->_loop = true;
?>
			@import url(<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
<?php echo $_smarty_tpl->tpl_vars['cssFile']->value;?>
);
			<?php } ?>
		<?php }?>
		@import url('<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
css/<?php echo $_smarty_tpl->tpl_vars['CssUrl']->value;?>
');
		<?php if ($_smarty_tpl->tpl_vars['CssExtensionFile']->value!=''){?>
			@import url('<?php echo $_smarty_tpl->tpl_vars['CssExtensionFile']->value;?>
');
		<?php }?>
	</style>

	<?php if ($_smarty_tpl->tpl_vars['printCssFiles']->value!=''){?>
		<?php $_smarty_tpl->tpl_vars['PrintCssFileList'] = new Smarty_variable(explode(',',$_smarty_tpl->tpl_vars['printCssFiles']->value), null, 0);?>
		<?php  $_smarty_tpl->tpl_vars['cssFile'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['cssFile']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['PrintCssFileList']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['cssFile']->key => $_smarty_tpl->tpl_vars['cssFile']->value){
$_smarty_tpl->tpl_vars['cssFile']->_loop = true;
?>
		<link rel='stylesheet' type='text/css' href='<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
<?php echo $_smarty_tpl->tpl_vars['cssFile']->value;?>
' media='print' />
		<?php } ?>
	<?php }?>

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
            <div id="logo"><a href="<?php echo $_smarty_tpl->tpl_vars['HomeUrl']->value;?>
"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['html_image'][0][0]->PrintImage(array('src'=>($_smarty_tpl->tpl_vars['LogoUrl']->value)),$_smarty_tpl);?>
</a></div>
			<div id="header-top">
				<div id="signout">
				<?php if ($_smarty_tpl->tpl_vars['LoggedIn']->value){?>
					<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>"SignedInAs"),$_smarty_tpl);?>
 <?php echo $_smarty_tpl->tpl_vars['UserName']->value;?>
<br/><a href="<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
logout.php"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>"SignOut"),$_smarty_tpl);?>
</a>
					<?php }else{ ?>
					<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>"NotSignedIn"),$_smarty_tpl);?>
<br/><a href="<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
index.php"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>"LogIn"),$_smarty_tpl);?>
</a>
				<?php }?>
				</div>
			</div>
			<ul id="nav" class="menubar">
			<?php if ($_smarty_tpl->tpl_vars['LoggedIn']->value){?>
				<li class="menubaritem first"><a href="<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
<?php echo Pages::DASHBOARD;?>
"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>"Dashboard"),$_smarty_tpl);?>
</a></li>
                <li class="menubaritem"><a href="<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
<?php echo Pages::PROFILE;?>
"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>"MyAccount"),$_smarty_tpl);?>
</a>
                    <ul>
                        <li class="menuitem"><a href="<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
<?php echo Pages::PROFILE;?>
"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>"Profile"),$_smarty_tpl);?>
</a></li>
                        <li class="menuitem"><a href="<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
<?php echo Pages::PASSWORD;?>
"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>"ChangePassword"),$_smarty_tpl);?>
</a></li>
                        
                    </ul>
                </li>
				<li class="menubaritem"><a href="<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
<?php echo Pages::SCHEDULE;?>
"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>"Schedule"),$_smarty_tpl);?>
</a></li>
                <li class="menubaritem"><a href="javascript: void(0);"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>"PointSystem"),$_smarty_tpl);?>
</a>
                	<ul>
						<li class="menuitem"><a href="<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
<?php echo Pages::RANKING;?>
"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>"Ranking"),$_smarty_tpl);?>
</a></li>
						<li class="menuitem"><a href="<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
<?php echo Pages::CALLS;?>
"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>"Calls"),$_smarty_tpl);?>
</a></li>
                        <li class="menuitem"><a href="<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
<?php echo Pages::TOURNAMENTS;?>
"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>"Tours"),$_smarty_tpl);?>
</a></li>
					</ul>
                </li>
			<?php if ($_smarty_tpl->tpl_vars['CanViewAdmin']->value){?>
				<li class="menubaritem"><a href="#"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'ApplicationManagement'),$_smarty_tpl);?>
</a>
					<ul>
                        <li class="menuitem"><a href="<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
admin/manage_reservations.php"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>"ManageReservations"),$_smarty_tpl);?>
</a></li>
                        <li class="menuitem"><a href="<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
admin/manage_resources.php"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>"ManageResources"),$_smarty_tpl);?>
</a></li>
						<li class="menuitem"><a href="<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
admin/manage_users.php"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>"ManageUsers"),$_smarty_tpl);?>
</a></li>

						<li class="menuitem"><a href="<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
admin/manage_groups.php"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>"ManageGroups"),$_smarty_tpl);?>
</a></li>
                        <li class="menuitem"><a href="<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
admin/manage_quotas.php"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>"ManageQuotas"),$_smarty_tpl);?>
</a></li>
						<li class="menuitem"><a href="<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
admin/manage_announcements.php"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>"ManageAnnouncements"),$_smarty_tpl);?>
</a></li>
                        <li class="menuitem"><a href="<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
admin/manage_attributes.php"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>"Customization"),$_smarty_tpl);?>
</a>
						
                        <li class="menuitem"><a href="#"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>"RankingCustomization"),$_smarty_tpl);?>
</a>
                            <ul>
                                <li class="menuitem"><a href="<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
<?php echo Pages::RANKING_ADMINISTRATION;?>
"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>"RankingAdmin"),$_smarty_tpl);?>
</a></li>
                                <li class="menuitem"><a href="<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
<?php echo Pages::RANKING_VARIABLES;?>
"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>"RankingVars"),$_smarty_tpl);?>
</a></li>
                            </ul>
                        </li>
                        <li class="menuitem"><a href="<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
reports/generate-report.php"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>"Search"),$_smarty_tpl);?>
</a></li>
					</ul>
				</li>
			<?php }?>
			<?php }?>
			</ul>
			<!-- end #nav -->
		</div>
		<!-- end #header -->
		<div id="content"><?php }} ?>