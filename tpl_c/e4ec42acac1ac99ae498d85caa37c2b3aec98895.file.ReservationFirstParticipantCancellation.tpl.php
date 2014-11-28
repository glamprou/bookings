<?php /* Smarty version Smarty-3.1.7, created on 2014-10-24 16:33:45
         compiled from "/home/acetenni/public_html/bookings/lib/Common/../../lang/gr_el/ReservationFirstParticipantCancellation.tpl" */ ?>
<?php /*%%SmartyHeaderCode:370858936544a7159e3d133-69940027%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e4ec42acac1ac99ae498d85caa37c2b3aec98895' => 
    array (
      0 => '/home/acetenni/public_html/bookings/lib/Common/../../lang/gr_el/ReservationFirstParticipantCancellation.tpl',
      1 => 1409936489,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '370858936544a7159e3d133-69940027',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'UserName' => 0,
    'StartDate' => 0,
    'EndDate' => 0,
    'ResourceName' => 0,
    'Title' => 0,
    'RepeatDates' => 0,
    'date' => 0,
    'ScriptUrl' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_544a7159ef933',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_544a7159ef933')) {function content_544a7159ef933($_smarty_tpl) {?>
<?php echo $_smarty_tpl->getSubTemplate ('..\..\tpl\Email\emailheader.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

	
	Λεπτομέριες κράτησης:
	<br/>
	<br/>
	Δημιουργία κράτησης από: <?php echo $_smarty_tpl->tpl_vars['UserName']->value;?>

	Έναρξη: <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['formatdate'][0][0]->FormatDate(array('date'=>$_smarty_tpl->tpl_vars['StartDate']->value,'key'=>'reservation_email'),$_smarty_tpl);?>
<br/>
	Λήξη: <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['formatdate'][0][0]->FormatDate(array('date'=>$_smarty_tpl->tpl_vars['EndDate']->value,'key'=>'reservation_email'),$_smarty_tpl);?>
<br/>
	Γήπεδο: <?php echo $_smarty_tpl->tpl_vars['ResourceName']->value;?>
<br/>
	Σημείωση: <?php echo $_smarty_tpl->tpl_vars['Title']->value;?>
<br/>
	
	<?php if (count($_smarty_tpl->tpl_vars['RepeatDates']->value)>0){?>
		<br/>
		Οι κρατήσεις στις παρακάτω ημερομηνίες ακυρώθηκαν:
		<br/>
	<?php }?>
	
	<?php  $_smarty_tpl->tpl_vars['date'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['date']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['RepeatDates']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['date']->key => $_smarty_tpl->tpl_vars['date']->value){
$_smarty_tpl->tpl_vars['date']->_loop = true;
?>
		<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['formatdate'][0][0]->FormatDate(array('date'=>$_smarty_tpl->tpl_vars['date']->value),$_smarty_tpl);?>
<br/>
	<?php } ?>

	<a href="<?php echo $_smarty_tpl->tpl_vars['ScriptUrl']->value;?>
">Μπείτε στο σύστημα κρατήσεων</a>
	
<?php echo $_smarty_tpl->getSubTemplate ('..\..\tpl\Email\emailfooter.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>