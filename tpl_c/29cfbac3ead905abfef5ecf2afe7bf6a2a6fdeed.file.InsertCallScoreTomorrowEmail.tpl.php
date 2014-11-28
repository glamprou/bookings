<?php /* Smarty version Smarty-3.1.7, created on 2014-10-09 09:01:08
         compiled from "lang/en_us/InsertCallScoreTomorrowEmail.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1115448141543624a43a8fa8-96159239%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '29cfbac3ead905abfef5ecf2afe7bf6a2a6fdeed' => 
    array (
      0 => 'lang/en_us/InsertCallScoreTomorrowEmail.tpl',
      1 => 1409936481,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1115448141543624a43a8fa8-96159239',
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
  'unifunc' => 'content_543624a45510c',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_543624a45510c')) {function content_543624a45510c($_smarty_tpl) {?>
<?php echo $_smarty_tpl->getSubTemplate ('..\..\tpl\Email\emailheader.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php echo $_smarty_tpl->tpl_vars['FirstName']->value;?>
,
εκκρεμεί η εισαγωγή αποτελέσματος για τον αγώνα με αντίπαλο τον/την <?php echo $_smarty_tpl->tpl_vars['caller']->value;?>
 (<a href="mailto:<?php echo $_smarty_tpl->tpl_vars['callerEmailAddress']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['callerEmailAddress']->value;?>
</a>) η οποία λήγει <b>αύριο</b>! Σε περίπτωση πού δεν εισάγετε το αποτέλεσμα του αγώνα έγκαιρα θα σας επιβληθεί ποινή! Μπορείτε να συνδεθείτε στο σύστημα κατάταξης για να εισάγετε το αποτέλεσμα του αγώνα.<br /><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value;?>
">Ace Ranking System</a>
<?php echo $_smarty_tpl->getSubTemplate ('..\..\tpl\Email\emailfooter.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>