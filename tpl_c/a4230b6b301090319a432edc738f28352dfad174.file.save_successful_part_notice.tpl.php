<?php /* Smarty version Smarty-3.1.7, created on 2014-10-01 14:17:32
         compiled from "/home/acetenni/public_html/bookings/lib/Common/../../tpl/Ajax/reservation/save_successful_part_notice.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1902463406542bfeec6be883-75044181%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a4230b6b301090319a432edc738f28352dfad174' => 
    array (
      0 => '/home/acetenni/public_html/bookings/lib/Common/../../tpl/Ajax/reservation/save_successful_part_notice.tpl',
      1 => 1409936908,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1902463406542bfeec6be883-75044181',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'warning_message' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_542bfeec76190',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_542bfeec76190')) {function content_542bfeec76190($_smarty_tpl) {?><div>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
	<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['html_image'][0][0]->PrintImage(array('src'=>"dialog-warning.png"),$_smarty_tpl);?>
<br/>
	<div style="color:#FF0000;"><?php echo $_smarty_tpl->tpl_vars['warning_message']->value;?>
</div>
    <input type="button" id="exceededQuotaAdminAccept" value="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'ΑcceptExceededQuota'),$_smarty_tpl);?>
" class="button" />
	<input type="button" id="exceededQuotaAdminCancel" value="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'CancelExceededQuota'),$_smarty_tpl);?>
" class="button" />
</div><?php }} ?>