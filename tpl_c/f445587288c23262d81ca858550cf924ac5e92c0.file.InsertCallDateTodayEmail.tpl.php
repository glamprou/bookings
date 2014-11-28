<?php /* Smarty version Smarty-3.1.7, created on 2014-10-14 09:01:11
         compiled from "lang/en_us/InsertCallDateTodayEmail.tpl" */ ?>
<?php /*%%SmartyHeaderCode:128659450543cbc27e91ea4-06057275%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f445587288c23262d81ca858550cf924ac5e92c0' => 
    array (
      0 => 'lang/en_us/InsertCallDateTodayEmail.tpl',
      1 => 1409936479,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '128659450543cbc27e91ea4-06057275',
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
  'unifunc' => 'content_543cbc2857d19',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_543cbc2857d19')) {function content_543cbc2857d19($_smarty_tpl) {?>
<?php echo $_smarty_tpl->getSubTemplate ('..\..\tpl\Email\emailheader.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php echo $_smarty_tpl->tpl_vars['FirstName']->value;?>
,
εκκρεμεί η εισαγωγή ημερομηνίας για τον αγώνα με αντίπαλο τον/την <?php echo $_smarty_tpl->tpl_vars['caller']->value;?>
 (<a href="mailto:<?php echo $_smarty_tpl->tpl_vars['callerEmailAddress']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['callerEmailAddress']->value;?>
</a>) η οποία λήγει <b>σήμερα</b>! Σε περίπτωση πού δεν εισάγετε την ημερομηνία του αγώνα και το αποτέλεσμα έγκαιρα, τότε θα σας επιβληθεί ποινή! Μπορείτε να συνδεθείτε στο σύστημα κατάταξης για να εισάγετε ημερομηνία και αποτέλεσμα του αγώνα. <br/><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value;?>
">Ace Ranking System</a>	
<?php echo $_smarty_tpl->getSubTemplate ('..\..\tpl\Email\emailfooter.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>