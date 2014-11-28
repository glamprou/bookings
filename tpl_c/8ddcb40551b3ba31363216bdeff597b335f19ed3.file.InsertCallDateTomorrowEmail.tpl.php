<?php /* Smarty version Smarty-3.1.7, created on 2014-10-10 09:01:11
         compiled from "lang/en_us/InsertCallDateTomorrowEmail.tpl" */ ?>
<?php /*%%SmartyHeaderCode:19086544754377627ac4797-39956128%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8ddcb40551b3ba31363216bdeff597b335f19ed3' => 
    array (
      0 => 'lang/en_us/InsertCallDateTomorrowEmail.tpl',
      1 => 1409936479,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19086544754377627ac4797-39956128',
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
  'unifunc' => 'content_54377627dd09b',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54377627dd09b')) {function content_54377627dd09b($_smarty_tpl) {?>
<?php echo $_smarty_tpl->getSubTemplate ('..\..\tpl\Email\emailheader.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php echo $_smarty_tpl->tpl_vars['FirstName']->value;?>
,
εκκρεμεί η εισαγωγή ημερομηνίας για τον αγώνα με αντίπαλο τον/την <?php echo $_smarty_tpl->tpl_vars['caller']->value;?>
 (<a href="mailto:<?php echo $_smarty_tpl->tpl_vars['callerEmailAddress']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['callerEmailAddress']->value;?>
</a>) η οποία λήγει <b>αύριο</b>! Σε περίπτωση πού δεν εισάγετε την ημερομηνία και το αποτέλεσμα του αγώνα έγκαιρα θα σας επιβληθεί ποινή! Μπορείτε να συνδεθείτε στο σύστημα κατάταξης για να εισάγετε ημερομηνία και αποτέλεσμα του αγώνα. <br/><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value;?>
">Ace Ranking System</a>	
<?php echo $_smarty_tpl->getSubTemplate ('..\..\tpl\Email\emailfooter.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>