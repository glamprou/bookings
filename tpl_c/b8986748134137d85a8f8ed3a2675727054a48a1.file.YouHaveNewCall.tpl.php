<?php /* Smarty version Smarty-3.1.7, created on 2014-09-05 19:40:20
         compiled from "../lang/en_us/YouHaveNewCall.tpl" */ ?>
<?php /*%%SmartyHeaderCode:254072954540a0394b87e73-45803279%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b8986748134137d85a8f8ed3a2675727054a48a1' => 
    array (
      0 => '../lang/en_us/YouHaveNewCall.tpl',
      1 => 1409936485,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '254072954540a0394b87e73-45803279',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'FirstName' => 0,
    'caller' => 0,
    'callerEmailAddress' => 0,
    'acceptCallUrl' => 0,
    'declineCallUrl' => 0,
    'link' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_540a0394bf732',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_540a0394bf732')) {function content_540a0394bf732($_smarty_tpl) {?>
<?php echo $_smarty_tpl->getSubTemplate ('..\..\tpl\Email\emailheader.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<?php echo $_smarty_tpl->tpl_vars['FirstName']->value;?>
,
έχετε δεχθεί πρόσκληση για αγώνα από τον/την <?php echo $_smarty_tpl->tpl_vars['caller']->value;?>
 (<a href="mailto:<?php echo $_smarty_tpl->tpl_vars['callerEmailAddress']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['callerEmailAddress']->value;?>
</a>). <br />
<a href="<?php echo $_smarty_tpl->tpl_vars['acceptCallUrl']->value;?>
">Αποδοχή</a> - <a href="<?php echo $_smarty_tpl->tpl_vars['declineCallUrl']->value;?>
">Απόρριψη</a><br /><br />
Διαφορετικά, μπορείτε να συνδεθείτε στο σύστημα κατάταξης για να αποδεχθείτε ή να απορρίψετε την πρόσκληση.<br /><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value;?>
">Ace Ranking System</a>
	
<?php echo $_smarty_tpl->getSubTemplate ('..\..\tpl\Email\emailfooter.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>