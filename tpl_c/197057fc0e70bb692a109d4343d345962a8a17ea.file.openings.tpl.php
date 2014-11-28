<?php /* Smarty version Smarty-3.1.7, created on 2014-10-19 01:14:29
         compiled from "/home/acetenni/public_html/bookings/lib/Common/../../tpl/openings.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1716672582544302652c6b84-31667620%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '197057fc0e70bb692a109d4343d345962a8a17ea' => 
    array (
      0 => '/home/acetenni/public_html/bookings/lib/Common/../../tpl/openings.tpl',
      1 => 1409936868,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1716672582544302652c6b84-31667620',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_544302653e67a',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_544302653e67a')) {function content_544302653e67a($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ('globalheader.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<form>
<ul>
	<li>For resource: <select id="resourceId" class="textbox"><option>Resource 1</option></select></li>
	<li class=""><select class="textbox"><option>Specific Date</option><option>Date Range</option></select></li>
	<li><input type="text" id="reservationDate" class="textbox" /></li>
	<li><input type="text" id="startDate" class="textbox"/> and <input type="text" id="endDate" class="textbox" /></li>
	<li><select class="textbox"><option>Length</option><option>Period</option></select></li>
	<li><input type="text" value="0" /> hours <input type="text" value="0" /> minutes</li>
	<li>Start: <select id="beginPeriod"></select> End: <select id="endPeriod"></select></li>
</ul>
</form>
<?php echo $_smarty_tpl->getSubTemplate ('globalfooter.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>