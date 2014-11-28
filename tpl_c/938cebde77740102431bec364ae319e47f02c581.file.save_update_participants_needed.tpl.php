<?php /* Smarty version Smarty-3.1.7, created on 2014-09-08 12:09:25
         compiled from "/home/acetenni/public_html/bookings/lib/Common/../../tpl/Ajax/reservation/save_update_participants_needed.tpl" */ ?>
<?php /*%%SmartyHeaderCode:180313586540d8e65508441-18292890%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '938cebde77740102431bec364ae319e47f02c581' => 
    array (
      0 => '/home/acetenni/public_html/bookings/lib/Common/../../tpl/Ajax/reservation/save_update_participants_needed.tpl',
      1 => 1409936908,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '180313586540d8e65508441-18292890',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_540d8e655a8a2',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_540d8e655a8a2')) {function content_540d8e655a8a2($_smarty_tpl) {?><div>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
	<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['html_image'][0][0]->PrintImage(array('src'=>"dialog-warning.png"),$_smarty_tpl);?>
<br/>

	<h2 style="text-align: center;"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'ReservationFailed'),$_smarty_tpl);?>
</h2>

	<div class="error">
		<ul>
			<li><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'AtLeastOneParticipant'),$_smarty_tpl);?>
</li>
		</ul>
	</div>

	<div style="margin: auto;text-align: center;">
		<button id="btnSaveFailed"
				class="button"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['html_image'][0][0]->PrintImage(array('src'=>"arrow_large_left.png"),$_smarty_tpl);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'ReservationErrors'),$_smarty_tpl);?>
</button>
	</div>
</div><?php }} ?>