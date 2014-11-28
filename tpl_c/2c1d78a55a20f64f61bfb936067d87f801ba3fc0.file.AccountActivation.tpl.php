<?php /* Smarty version Smarty-3.1.7, created on 2014-09-05 20:22:16
         compiled from "/home/acetenni/public_html/bookings/lib/Common/../../lang/gr_el/AccountActivation.tpl" */ ?>
<?php /*%%SmartyHeaderCode:8112315540a0d6820b820-77770661%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2c1d78a55a20f64f61bfb936067d87f801ba3fc0' => 
    array (
      0 => '/home/acetenni/public_html/bookings/lib/Common/../../lang/gr_el/AccountActivation.tpl',
      1 => 1409936486,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8112315540a0d6820b820-77770661',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'FirstName' => 0,
    'ActivationUrl' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_540a0d6824036',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_540a0d6824036')) {function content_540a0d6824036($_smarty_tpl) {?>
<?php echo $_smarty_tpl->getSubTemplate ('..\..\tpl\Email\emailheader.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<?php echo $_smarty_tpl->tpl_vars['FirstName']->value;?>
,
Ευχαριστούμε για την εγγραφή σας. Παρακαλώ πατήστε για να <a href="<?php echo $_smarty_tpl->tpl_vars['ActivationUrl']->value;?>
">ενεργοποιήσετε τον λογαριασμό</a>.
	
<?php echo $_smarty_tpl->getSubTemplate ('..\..\tpl\Email\emailfooter.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>