<?php /* Smarty version Smarty-3.1.7, created on 2014-09-08 23:22:03
         compiled from "../lang/en_us/CallDeclined.tpl" */ ?>
<?php /*%%SmartyHeaderCode:723468148540e2c0b1b7b59-05585904%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '82add7bd617dd77887b9ec51259711a7ae5f7711' => 
    array (
      0 => '../lang/en_us/CallDeclined.tpl',
      1 => 1409936473,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '723468148540e2c0b1b7b59-05585904',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'FirstName' => 0,
    'caller' => 0,
    'callerEmailAddress' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_540e2c0b27603',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_540e2c0b27603')) {function content_540e2c0b27603($_smarty_tpl) {?>
<?php echo $_smarty_tpl->getSubTemplate ('..\..\tpl\Email\emailheader.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<?php echo $_smarty_tpl->tpl_vars['FirstName']->value;?>
,
η πρόσκληση για αγώνα με αντίπαλο τον/την <?php echo $_smarty_tpl->tpl_vars['caller']->value;?>
 (<a href="mailto:<?php echo $_smarty_tpl->tpl_vars['callerEmailAddress']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['callerEmailAddress']->value;?>
</a>), έχει ακυρωθεί! 
<?php echo $_smarty_tpl->getSubTemplate ('..\..\tpl\Email\emailfooter.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>