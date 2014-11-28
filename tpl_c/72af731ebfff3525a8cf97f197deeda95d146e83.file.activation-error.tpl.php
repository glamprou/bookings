<?php /* Smarty version Smarty-3.1.7, created on 2014-09-07 12:35:42
         compiled from "/home/acetenni/public_html/bookings/lib/Common/../../tpl/Activation/activation-error.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1742768099540c430eec3b59-96898183%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '72af731ebfff3525a8cf97f197deeda95d146e83' => 
    array (
      0 => '/home/acetenni/public_html/bookings/lib/Common/../../tpl/Activation/activation-error.tpl',
      1 => 1409937516,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1742768099540c430eec3b59-96898183',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_540c430f41d07',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_540c430f41d07')) {function content_540c430f41d07($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ('globalheader.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('cssFiles'=>'scripts/css/colorbox.css'), 0);?>

<div id='activation-body'>
	<h2 align="center"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'AccountActivationError'),$_smarty_tpl);?>
</h2>
</div>
<?php echo $_smarty_tpl->getSubTemplate ('globalfooter.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>