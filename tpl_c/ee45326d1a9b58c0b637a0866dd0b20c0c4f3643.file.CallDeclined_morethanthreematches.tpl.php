<?php /* Smarty version Smarty-3.1.7, created on 2014-11-24 09:20:56
         compiled from "../lang/en_us/CallDeclined_morethanthreematches.tpl" */ ?>
<?php /*%%SmartyHeaderCode:4603833195472f87832cbf5-35183768%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ee45326d1a9b58c0b637a0866dd0b20c0c4f3643' => 
    array (
      0 => '../lang/en_us/CallDeclined_morethanthreematches.tpl',
      1 => 1409936473,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4603833195472f87832cbf5-35183768',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'FirstName' => 0,
    'caller' => 0,
    'callerEmailAddress' => 0,
    'numofmatchesforfreedecl' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5472f8783961b',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5472f8783961b')) {function content_5472f8783961b($_smarty_tpl) {?>
<?php echo $_smarty_tpl->getSubTemplate ('..\..\tpl\Email\emailheader.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<?php echo $_smarty_tpl->tpl_vars['FirstName']->value;?>
,
η πρόσκληση για αγώνα με αντίπαλο τον/την <?php echo $_smarty_tpl->tpl_vars['caller']->value;?>
 (<a href="mailto:<?php echo $_smarty_tpl->tpl_vars['callerEmailAddress']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['callerEmailAddress']->value;?>
</a>), έχει ακυρωθεί!(Ο χρήστης έχει <?php echo $_smarty_tpl->tpl_vars['numofmatchesforfreedecl']->value;?>
  ή περισσότερους αγώνες σε εκκρεμότητα) 
<?php echo $_smarty_tpl->getSubTemplate ('..\..\tpl\Email\emailfooter.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>