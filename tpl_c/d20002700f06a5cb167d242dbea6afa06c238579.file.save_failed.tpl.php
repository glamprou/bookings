<?php /* Smarty version Smarty-3.1.7, created on 2014-09-05 18:31:08
         compiled from "/home/acetenni/public_html/bookings/lib/Common/../../tpl/Ajax/reservation/save_failed.tpl" */ ?>
<?php /*%%SmartyHeaderCode:18794872065409f35cd6c324-24303542%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd20002700f06a5cb167d242dbea6afa06c238579' => 
    array (
      0 => '/home/acetenni/public_html/bookings/lib/Common/../../tpl/Ajax/reservation/save_failed.tpl',
      1 => 1409936907,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18794872065409f35cd6c324-24303542',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'Warnings' => 0,
    'each' => 0,
    'Errors' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5409f35cdbf51',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5409f35cdbf51')) {function content_5409f35cdbf51($_smarty_tpl) {?><div>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
	<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['html_image'][0][0]->PrintImage(array('src'=>"dialog-warning.png"),$_smarty_tpl);?>
<br/>

	<h2 style="text-align: center;"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'ReservationFailed'),$_smarty_tpl);?>
</h2>
    <?php if ($_smarty_tpl->tpl_vars['Warnings']->value){?>
    <div class="warning">
        <ul>
            <?php  $_smarty_tpl->tpl_vars['each'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['each']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['Warnings']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['each']->key => $_smarty_tpl->tpl_vars['each']->value){
$_smarty_tpl->tpl_vars['each']->_loop = true;
?>
                <li><?php echo nl2br($_smarty_tpl->tpl_vars['each']->value);?>
</li>
            <?php } ?>
        </ul>
    </div>
    <?php }?>
    <?php if ($_smarty_tpl->tpl_vars['Errors']->value){?>
	<div class="error">
		<ul>
		<?php  $_smarty_tpl->tpl_vars['each'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['each']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['Errors']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['each']->key => $_smarty_tpl->tpl_vars['each']->value){
$_smarty_tpl->tpl_vars['each']->_loop = true;
?>
			<li><?php echo nl2br($_smarty_tpl->tpl_vars['each']->value);?>
</li>
		<?php } ?>
		</ul>
	</div>
    <?php }?>
	<div style="margin: auto;text-align: center;">
		<button id="btnSaveFailed"
				class="button"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['html_image'][0][0]->PrintImage(array('src'=>"arrow_large_left.png"),$_smarty_tpl);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'ReservationErrors'),$_smarty_tpl);?>
</button>
	</div>
</div><?php }} ?>