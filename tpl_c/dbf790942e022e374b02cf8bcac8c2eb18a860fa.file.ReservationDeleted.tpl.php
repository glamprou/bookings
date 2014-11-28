<?php /* Smarty version Smarty-3.1.7, created on 2014-09-05 18:32:12
         compiled from "/home/acetenni/public_html/bookings/lib/Common/../../lang/gr_el/ReservationDeleted.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3420446735409f39c593055-45587012%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'dbf790942e022e374b02cf8bcac8c2eb18a860fa' => 
    array (
      0 => '/home/acetenni/public_html/bookings/lib/Common/../../lang/gr_el/ReservationDeleted.tpl',
      1 => 1409936489,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3420446735409f39c593055-45587012',
  'function' => 
  array (
  ),
  'variables' => 
  array (
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
  'unifunc' => 'content_5409f39c6094f',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5409f39c6094f')) {function content_5409f39c6094f($_smarty_tpl) {?>
<?php echo $_smarty_tpl->getSubTemplate ('..\..\tpl\Email\emailheader.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

	
	Λεπτομέριες κράτησης:
	<br/>
	<br/>
	
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