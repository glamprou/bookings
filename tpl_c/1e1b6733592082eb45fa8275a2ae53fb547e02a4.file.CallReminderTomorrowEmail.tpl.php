<?php /* Smarty version Smarty-3.1.7, created on 2014-09-08 11:17:43
         compiled from "lang/en_us/CallReminderTomorrowEmail.tpl" */ ?>
<?php /*%%SmartyHeaderCode:353504356540d66274c2d25-99691269%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1e1b6733592082eb45fa8275a2ae53fb547e02a4' => 
    array (
      0 => 'lang/en_us/CallReminderTomorrowEmail.tpl',
      1 => 1409936475,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '353504356540d66274c2d25-99691269',
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
  'unifunc' => 'content_540d662768f3a',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_540d662768f3a')) {function content_540d662768f3a($_smarty_tpl) {?>
<?php echo $_smarty_tpl->getSubTemplate ('..\..\tpl\Email\emailheader.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<?php echo $_smarty_tpl->tpl_vars['FirstName']->value;?>
,
εκκρεμεί απάντηση σας στην πρόσκληση για αγώνα με αντίπαλο τον/την <?php echo $_smarty_tpl->tpl_vars['caller']->value;?>
 (<a href="mailto:<?php echo $_smarty_tpl->tpl_vars['callerEmailAddress']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['callerEmailAddress']->value;?>
</a>) η οποία λήγει <b>αύριο</b>! Σε περίπτωση πού δεν απαντήσετε έγκαιρα θα σας επιβληθεί ποινή! Μπορείτε να συνδεθείτε στο σύστημα κατάταξης για να απαντήσετε στην πρόσκληση.<br /><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value;?>
">Ace Ranking System</a>
	
<?php echo $_smarty_tpl->getSubTemplate ('..\..\tpl\Email\emailfooter.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>