<?php /* Smarty version Smarty-3.1.7, created on 2014-09-05 18:31:44
         compiled from "/home/acetenni/public_html/bookings/lib/Common/../../lang/gr_el/ReservationCreated.tpl" */ ?>
<?php /*%%SmartyHeaderCode:19246021115409f38075b1a6-23206802%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7e5eb02f9b46460149dd049cbc113da600cef102' => 
    array (
      0 => '/home/acetenni/public_html/bookings/lib/Common/../../lang/gr_el/ReservationCreated.tpl',
      1 => 1409936488,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19246021115409f38075b1a6-23206802',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'StartDate' => 0,
    'EndDate' => 0,
    'Title' => 0,
    'RepeatDates' => 0,
    'date' => 0,
    'RequiresApproval' => 0,
    'ScriptUrl' => 0,
    'ReservationUrl' => 0,
    'ICalUrl' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5409f3807b764',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5409f3807b764')) {function content_5409f3807b764($_smarty_tpl) {?>
<?php echo $_smarty_tpl->getSubTemplate ('..\..\tpl\Email\emailheader.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

	
	Λεπτομέριες κράτησης:
	<br/>
	<br/>
	
	Έναρξη: <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['formatdate'][0][0]->FormatDate(array('date'=>$_smarty_tpl->tpl_vars['StartDate']->value,'key'=>'reservation_email'),$_smarty_tpl);?>
<br/>
	Λήξη: <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['formatdate'][0][0]->FormatDate(array('date'=>$_smarty_tpl->tpl_vars['EndDate']->value,'key'=>'reservation_email'),$_smarty_tpl);?>
<br/>
	Σημείωση: <?php echo $_smarty_tpl->tpl_vars['Title']->value;?>
<br/>
	
	<?php if (count($_smarty_tpl->tpl_vars['RepeatDates']->value)>0){?>
		<br/>
		Επαναλαμβάνεται στις ακόλουθες ημερομηνίες:
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

	<?php if ($_smarty_tpl->tpl_vars['RequiresApproval']->value){?>
		<br/>
		Αναμένετε για έγκριση.
	<?php }?>
	
	<br/>
	<a href="<?php echo $_smarty_tpl->tpl_vars['ScriptUrl']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['ReservationUrl']->value;?>
">Δείτε την κράτηση</a> |
	<a href="<?php echo $_smarty_tpl->tpl_vars['ScriptUrl']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['ICalUrl']->value;?>
">Προσθήκη στο Outlook</a> |
	<a href="<?php echo $_smarty_tpl->tpl_vars['ScriptUrl']->value;?>
">Μπείτε στο σύστημα κρατήσεων</a>
	
<?php echo $_smarty_tpl->getSubTemplate ('..\..\tpl\Email\emailfooter.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>