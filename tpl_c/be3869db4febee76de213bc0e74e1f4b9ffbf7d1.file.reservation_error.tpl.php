<?php /* Smarty version Smarty-3.1.7, created on 2014-09-06 11:36:19
         compiled from "/home/acetenni/public_html/bookings/lib/Common/../../tpl/Ajax/reservation/reservation_error.tpl" */ ?>
<?php /*%%SmartyHeaderCode:126786691540ae3a3f29332-75934625%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'be3869db4febee76de213bc0e74e1f4b9ffbf7d1' => 
    array (
      0 => '/home/acetenni/public_html/bookings/lib/Common/../../tpl/Ajax/reservation/reservation_error.tpl',
      1 => 1409936907,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '126786691540ae3a3f29332-75934625',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_540ae3a40333f',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_540ae3a40333f')) {function content_540ae3a40333f($_smarty_tpl) {?><div>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
	<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['html_image'][0][0]->PrintImage(array('src'=>"dialog-warning.png"),$_smarty_tpl);?>
<br/>

	<h2 style="text-align: center;"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'ReservationCriticalError'),$_smarty_tpl);?>
</h2>

	<div style="margin: auto;text-align: center;">
		<button id="btnSaveFailed"
				class="button"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['html_image'][0][0]->PrintImage(array('src'=>"arrow_large_left.png"),$_smarty_tpl);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'ReservationErrors'),$_smarty_tpl);?>
</button>
	</div>
</div><?php }} ?>