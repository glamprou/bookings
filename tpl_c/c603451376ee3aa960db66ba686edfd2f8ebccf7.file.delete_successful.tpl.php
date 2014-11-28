<?php /* Smarty version Smarty-3.1.7, created on 2014-09-05 18:32:12
         compiled from "/home/acetenni/public_html/bookings/lib/Common/../../tpl/Ajax/reservation/delete_successful.tpl" */ ?>
<?php /*%%SmartyHeaderCode:6687415785409f39c990640-00605845%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c603451376ee3aa960db66ba686edfd2f8ebccf7' => 
    array (
      0 => '/home/acetenni/public_html/bookings/lib/Common/../../tpl/Ajax/reservation/delete_successful.tpl',
      1 => 1409936906,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6687415785409f39c990640-00605845',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'Warnings' => 0,
    'each' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5409f39c9b2a5',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5409f39c9b2a5')) {function content_5409f39c9b2a5($_smarty_tpl) {?><div>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
	<div><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'ReservationRemoved'),$_smarty_tpl);?>
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