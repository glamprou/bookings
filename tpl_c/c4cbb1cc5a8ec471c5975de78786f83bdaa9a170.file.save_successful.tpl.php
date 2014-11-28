<?php /* Smarty version Smarty-3.1.7, created on 2014-09-05 18:31:44
         compiled from "/home/acetenni/public_html/bookings/lib/Common/../../tpl/Ajax/reservation/save_successful.tpl" */ ?>
<?php /*%%SmartyHeaderCode:15723122655409f3807e3500-10919531%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c4cbb1cc5a8ec471c5975de78786f83bdaa9a170' => 
    array (
      0 => '/home/acetenni/public_html/bookings/lib/Common/../../tpl/Ajax/reservation/save_successful.tpl',
      1 => 1409936908,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15723122655409f3807e3500-10919531',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'ReferenceNumber' => 0,
    'Warnings' => 0,
    'each' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5409f3807fdc6',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5409f3807fdc6')) {function content_5409f3807fdc6($_smarty_tpl) {?><div>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
	<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['html_image'][0][0]->PrintImage(array('src'=>"dialog-success.png"),$_smarty_tpl);?>
<br/>
	<div><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'ReservationCreated'),$_smarty_tpl);?>
</div>
	<div><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'YourReferenceNumber','args'=>$_smarty_tpl->tpl_vars['ReferenceNumber']->value),$_smarty_tpl);?>
</div>
	<ul>
	<?php  $_smarty_tpl->tpl_vars['each'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['each']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['Warnings']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['each']->key => $_smarty_tpl->tpl_vars['each']->value){
$_smarty_tpl->tpl_vars['each']->_loop = true;
?>
		<li><?php echo $_smarty_tpl->tpl_vars['each']->value;?>
</li>
	<?php } ?>
	</ul>
	<input type="button" id="btnSaveSuccessful" value="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Close'),$_smarty_tpl);?>
" class="button" />
</div><?php }} ?>