<?php /* Smarty version Smarty-3.1.7, created on 2014-09-06 16:22:59
         compiled from "/home/acetenni/public_html/bookings/lib/Common/../../lang/gr_el/ResetPassword.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1549382592540b26d3825772-02772300%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '732920e79322bb803f81aed6b80ce327f5d463b4' => 
    array (
      0 => '/home/acetenni/public_html/bookings/lib/Common/../../lang/gr_el/ResetPassword.tpl',
      1 => 1409936490,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1549382592540b26d3825772-02772300',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'TemporaryPassword' => 0,
    'ScriptUrl' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_540b26d38cfbc',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_540b26d38cfbc')) {function content_540b26d38cfbc($_smarty_tpl) {?>
<?php echo $_smarty_tpl->getSubTemplate ('..\..\tpl\Email\emailheader.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

	
Ο προσωρινός σας κωδικός: <?php echo $_smarty_tpl->tpl_vars['TemporaryPassword']->value;?>


<br/>

Ο παλιός κωδικός δεν λειτουργεί πλέον.

Παρακαλώ  <a href="<?php echo $_smarty_tpl->tpl_vars['ScriptUrl']->value;?>
">Μπείτε στο σύστημα κρατήσεων</a> για να ορίσετε έναν νέο κωδικό το συντομότερο.
	
<?php echo $_smarty_tpl->getSubTemplate ('..\..\tpl\Email\emailfooter.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>