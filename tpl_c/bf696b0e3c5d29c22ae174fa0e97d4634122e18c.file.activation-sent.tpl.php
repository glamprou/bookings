<?php /* Smarty version Smarty-3.1.7, created on 2014-09-05 20:22:17
         compiled from "/home/acetenni/public_html/bookings/lib/Common/../../tpl/Activation/activation-sent.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1597970573540a0d695f3970-63269633%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bf696b0e3c5d29c22ae174fa0e97d4634122e18c' => 
    array (
      0 => '/home/acetenni/public_html/bookings/lib/Common/../../tpl/Activation/activation-sent.tpl',
      1 => 1409936873,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1597970573540a0d695f3970-63269633',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_540a0d69624dd',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_540a0d69624dd')) {function content_540a0d69624dd($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ('globalheader.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('cssFiles'=>'scripts/css/colorbox.css'), 0);?>

<div id='activation-body'>
	<h2 align="center"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'ActivationEmailSent'),$_smarty_tpl);?>
</h2>
</div>
<?php echo $_smarty_tpl->getSubTemplate ('globalfooter.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>