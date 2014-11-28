<?php /* Smarty version Smarty-3.1.7, created on 2014-09-15 12:16:02
         compiled from "../lang/en_us/CallAccepted.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2642666825416ae52e1de42-99584040%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'efcbac8c3da0129b541affe99d69c9c9df9be762' => 
    array (
      0 => '../lang/en_us/CallAccepted.tpl',
      1 => 1409936472,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2642666825416ae52e1de42-99584040',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'FirstName' => 0,
    'caller' => 0,
    'callerEmailAddress' => 0,
    'link' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5416ae52f053a',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5416ae52f053a')) {function content_5416ae52f053a($_smarty_tpl) {?>
<?php echo $_smarty_tpl->getSubTemplate ('..\..\tpl\Email\emailheader.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<?php echo $_smarty_tpl->tpl_vars['FirstName']->value;?>
,
η πρόσκληση για αγώνα με αντίπαλο τον/την <?php echo $_smarty_tpl->tpl_vars['caller']->value;?>
 (<a href="mailto:<?php echo $_smarty_tpl->tpl_vars['callerEmailAddress']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['callerEmailAddress']->value;?>
</a>), έχει επικυρωθεί! Μπορείτε να συνδεθείτε στο σύστημα κατάταξης για να επιλέξετε την ημερομηνία διεξαγωγής του αγώνα.<br /><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value;?>
">Ace Ranking System</a>
	
<?php echo $_smarty_tpl->getSubTemplate ('..\..\tpl\Email\emailfooter.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>