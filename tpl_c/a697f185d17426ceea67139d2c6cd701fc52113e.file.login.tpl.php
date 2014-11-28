<?php /* Smarty version Smarty-3.1.7, created on 2014-09-05 18:32:47
         compiled from "/home/acetenni/public_html/bookings/lib/Common/../../tpl/login.tpl" */ ?>
<?php /*%%SmartyHeaderCode:7298292565409f3bf87e871-52885506%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a697f185d17426ceea67139d2c6cd701fc52113e' => 
    array (
      0 => '/home/acetenni/public_html/bookings/lib/Common/../../tpl/login.tpl',
      1 => 1409936868,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7298292565409f3bf87e871-52885506',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'ShowLoginError' => 0,
    'ShowUsernamePrompt' => 0,
    'ShowPasswordPrompt' => 0,
    'ResumeUrl' => 0,
    'ShowRegisterLink' => 0,
    'ShowForgotPasswordPrompt' => 0,
    'ShowPersistLoginPrompt' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5409f3bf915a2',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5409f3bf915a2')) {function content_5409f3bf915a2($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ('globalheader.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<?php if ($_smarty_tpl->tpl_vars['ShowLoginError']->value){?>
<div id="loginError">
	<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'LoginError'),$_smarty_tpl);?>

</div>
<?php }?>

<div id="loginbox">
	<!--This "$smarty.server.SCRIPT_NAME" sets up the form to post back to the same page that it is on.-->
	<form class="login" method="post" action="<?php echo $_SERVER['SCRIPT_NAME'];?>
">
		<div>
			<?php if ($_smarty_tpl->tpl_vars['ShowUsernamePrompt']->value){?>
			<p>
				<label class="login"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'UsernameOrEmail'),$_smarty_tpl);?>
<br/>
				<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['textbox'][0][0]->Textbox(array('name'=>"EMAIL",'class'=>"input",'size'=>"20",'tabindex'=>"10"),$_smarty_tpl);?>
</label>
			</p>
			<?php }?>

			<?php if ($_smarty_tpl->tpl_vars['ShowPasswordPrompt']->value){?>
			<p>
				<label class="login"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Password'),$_smarty_tpl);?>
<br/>
				<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['textbox'][0][0]->Textbox(array('type'=>"password",'name'=>"PASSWORD",'class'=>"input",'value'=>'','size'=>"20",'tabindex'=>"20"),$_smarty_tpl);?>
</label>
			</p>
			<?php }?>

			
				
					
					
					
			
            <p class="loginsubmit">
                <button type="submit" name="<?php echo Actions::LOGIN;?>
" class="button" tabindex="100" value="submit"><img
                            src="img/door-open-in.png"/> <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'LogIn'),$_smarty_tpl);?>
 </button>
                <input type="hidden" name="<?php echo FormKeys::RESUME;?>
" value="<?php echo $_smarty_tpl->tpl_vars['ResumeUrl']->value;?>
"/>
            </p>
            <?php if ($_smarty_tpl->tpl_vars['ShowRegisterLink']->value){?>
                <p><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['html_link'][0][0]->PrintLink(array('href'=>"register.php",'key'=>"CreateAnAccount"),$_smarty_tpl);?>
</p>
            <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['ShowForgotPasswordPrompt']->value){?>
                <p><a href="forgot.php"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'ForgotMyPassword'),$_smarty_tpl);?>
</a></p>
            <?php }?>
			<?php if ($_smarty_tpl->tpl_vars['ShowPersistLoginPrompt']->value){?>
			<p class="stayloggedin">
				<label class="login"><input type="checkbox" name="<?php echo FormKeys::PERSIST_LOGIN;?>
" value="true" tabindex="30"/> <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'RememberMe'),$_smarty_tpl);?>
</label>
			</p>
			<?php }?>
		</div>
		<div style="clear:both;">&nbsp;</div>
	</form>
</div>

<div id="login-links">
    <p>
        <a href="view-schedule.php"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'ViewSchedule'),$_smarty_tpl);?>
</a> | <a href="view-ranking.php"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'ViewRanking'),$_smarty_tpl);?>
</a>
    </p>
</div>

<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['setfocus'][0][0]->SetFocus(array('key'=>'EMAIL'),$_smarty_tpl);?>


<script type="text/javascript">
	var url = 'index.php?<?php echo QueryStringKeys::LANGUAGE;?>
=';
	$(document).ready(function () {
		$('#languageDropDown').change(function()
		{
			window.location.href = url + $(this).val();
		});

		var langCode = readCookie('<?php echo CookieKeys::LANGUAGE;?>
');

		if (!langCode) {
		}
	});
</script>
<?php echo $_smarty_tpl->getSubTemplate ('globalfooter.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>