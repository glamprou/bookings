<?php /* Smarty version Smarty-3.1.7, created on 2014-09-05 18:15:50
         compiled from "/home/acetenni/public_html/bookings/lib/Common/../../tpl/schedule.tpl" */ ?>
<?php /*%%SmartyHeaderCode:6939005685409efc6914d81-16632226%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b1039fefa35901a7839b1519ef4e5540638cfbca' => 
    array (
      0 => '/home/acetenni/public_html/bookings/lib/Common/../../tpl/schedule.tpl',
      1 => 1409936872,
      2 => 'file',
    ),
    'dec7f7ac12a19a3a3834bca80bcd3b3c03a582d5' => 
    array (
      0 => '/home/acetenni/public_html/bookings/lib/Common/../../tpl/globalheader.tpl',
      1 => 1409936867,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6939005685409efc6914d81-16632226',
  'function' => 
  array (
    'displayGeneralReserved' => 
    array (
      'parameter' => 
      array (
      ),
      'compiled' => '',
    ),
    'displayMyReserved' => 
    array (
      'parameter' => 
      array (
      ),
      'compiled' => '',
    ),
    'displayMyParticipating' => 
    array (
      'parameter' => 
      array (
      ),
      'compiled' => '',
    ),
    'displayReserved' => 
    array (
      'parameter' => 
      array (
      ),
      'compiled' => '',
    ),
    'displayOpen' => 
    array (
      'parameter' => 
      array (
      ),
      'compiled' => '',
    ),
    'displayPaid' => 
    array (
      'parameter' => 
      array (
      ),
      'compiled' => '',
    ),
    'displayPastTime' => 
    array (
      'parameter' => 
      array (
      ),
      'compiled' => '',
    ),
    'displayReservable' => 
    array (
      'parameter' => 
      array (
      ),
      'compiled' => '',
    ),
    'displayRestricted' => 
    array (
      'parameter' => 
      array (
      ),
      'compiled' => '',
    ),
    'displayUnreservable' => 
    array (
      'parameter' => 
      array (
      ),
      'compiled' => '',
    ),
    'displaySlot' => 
    array (
      'parameter' => 
      array (
      ),
      'compiled' => '',
    ),
  ),
  'variables' => 
  array (
    'Slot' => 0,
    'spantype' => 0,
    'slot' => 0,
    'class' => 0,
    'OwnershipClass' => 0,
    'SlotLabelFactory' => 0,
    'Href' => 0,
    'SlotRef' => 0,
    'schedule2_color' => 0,
    'colnum' => 0,
    'isCallRes' => 0,
    'callid' => 0,
    'AccessAllowed' => 0,
    'resource' => 0,
    'DisplaySlotFactory' => 0,
    'Schedules' => 0,
    'DisplayDates' => 0,
    'PreviousDate' => 0,
    'FirstDate' => 0,
    'LastDate' => 0,
    'NextDate' => 0,
    'BoundDates' => 0,
    'firstScheduleDay' => 0,
    'viewSchedule' => 0,
    'schedule' => 0,
    'date' => 0,
    'ScheduleLayout' => 0,
    'Resources' => 0,
    'TodaysDate' => 0,
    'showDate' => 0,
    'Periods' => 0,
    'period' => 0,
    'resourceId' => 0,
    'slots' => 0,
    'slotRef' => 0,
    'dayCounter' => 0,
    'numOfDays' => 0,
    'ScheduleId' => 0,
    'Path' => 0,
    'CookieName' => 0,
    'CookieValue' => 0,
    'FirstWeekday' => 0,
    'IsThereImportantAnnouncement' => 0,
    'announcement_text' => 0,
    'announcement_cookie_val' => 0,
  ),
  'has_nocache_code' => 0,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5409efc6d694f',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5409efc6d694f')) {function content_5409efc6d694f($_smarty_tpl) {?>

<?php if (!function_exists('smarty_template_function_displayGeneralReserved')) {
    function smarty_template_function_displayGeneralReserved($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->smarty->template_functions['displayGeneralReserved']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?>
	<?php if ($_smarty_tpl->tpl_vars['Slot']->value->IsPending()){?>
		<?php $_smarty_tpl->tpl_vars['class'] = new Smarty_variable('pending', null, 0);?>
	<?php }?>
    <?php if ($_smarty_tpl->tpl_vars['Slot']->value->num_of_players==''){?>
          <td <?php echo (($tmp = @$_smarty_tpl->tpl_vars['spantype']->value)===null||$tmp==='' ? 'col' : $tmp);?>
span="<?php echo $_smarty_tpl->tpl_vars['Slot']->value->PeriodSpan();?>
" class="<?php if ($_smarty_tpl->tpl_vars['slot']->value->isGame()){?>game <?php }?>reserved <?php echo $_smarty_tpl->tpl_vars['class']->value;?>
 <?php echo $_smarty_tpl->tpl_vars['OwnershipClass']->value;?>
 clickres slot"
          resid="<?php echo $_smarty_tpl->tpl_vars['Slot']->value->Id();?>
"
          id="<?php echo $_smarty_tpl->tpl_vars['Slot']->value->Id();?>
|<?php echo $_smarty_tpl->tpl_vars['Slot']->value->Date()->Format('Ymd');?>
"><div style="position:relative;">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td style="border:0px solid #000000;" valign="middle"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['escapequotes'][0][0]->EscapeQuotes($_smarty_tpl->tpl_vars['Slot']->value->Label($_smarty_tpl->tpl_vars['SlotLabelFactory']->value));?>
</td>
          </tr>
        </table>
  </td>
    <?php }else{ ?>
          <td <?php echo (($tmp = @$_smarty_tpl->tpl_vars['spantype']->value)===null||$tmp==='' ? 'col' : $tmp);?>
span="<?php echo $_smarty_tpl->tpl_vars['Slot']->value->PeriodSpan();?>
" class="reserved <?php echo $_smarty_tpl->tpl_vars['class']->value;?>
 <?php echo $_smarty_tpl->tpl_vars['OwnershipClass']->value;?>
 clickres slot"
          resid="<?php echo $_smarty_tpl->tpl_vars['Slot']->value->Id();?>
"
          id="<?php echo $_smarty_tpl->tpl_vars['Slot']->value->Id();?>
|<?php echo $_smarty_tpl->tpl_vars['Slot']->value->Date()->Format('Ymd');?>
"><div style="position:relative;"><div style="margin-right:15px; overflow:hidden;">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td style="border:0px solid #000000;" valign="middle"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['escapequotes'][0][0]->EscapeQuotes($_smarty_tpl->tpl_vars['Slot']->value->Label($_smarty_tpl->tpl_vars['SlotLabelFactory']->value));?>
</td>
          </tr>
        </table>
  <div style="position:absolute; top:1px; right:1px;"><?php echo $_smarty_tpl->tpl_vars['Slot']->value->num_of_players;?>
</div></div></td>
    <?php }?>
<?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>


<?php if (!function_exists('smarty_template_function_displayMyReserved')) {
    function smarty_template_function_displayMyReserved($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->smarty->template_functions['displayMyReserved']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?>
	<?php smarty_template_function_displayGeneralReserved($_smarty_tpl,array('Slot'=>$_smarty_tpl->tpl_vars['Slot']->value,'Href'=>$_smarty_tpl->tpl_vars['Href']->value,'SlotRef'=>$_smarty_tpl->tpl_vars['SlotRef']->value,'OwnershipClass'=>'mine'));?>

<?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>


<?php if (!function_exists('smarty_template_function_displayMyParticipating')) {
    function smarty_template_function_displayMyParticipating($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->smarty->template_functions['displayMyParticipating']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?>
	<?php smarty_template_function_displayGeneralReserved($_smarty_tpl,array('Slot'=>$_smarty_tpl->tpl_vars['Slot']->value,'Href'=>$_smarty_tpl->tpl_vars['Href']->value,'SlotRef'=>$_smarty_tpl->tpl_vars['SlotRef']->value,'OwnershipClass'=>'participating'));?>

<?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>


<?php if (!function_exists('smarty_template_function_displayReserved')) {
    function smarty_template_function_displayReserved($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->smarty->template_functions['displayReserved']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?>
	<?php smarty_template_function_displayGeneralReserved($_smarty_tpl,array('Slot'=>$_smarty_tpl->tpl_vars['Slot']->value,'Href'=>$_smarty_tpl->tpl_vars['Href']->value,'SlotRef'=>$_smarty_tpl->tpl_vars['SlotRef']->value,'OwnershipClass'=>''));?>

<?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>


<?php if (!function_exists('smarty_template_function_displayOpen')) {
    function smarty_template_function_displayOpen($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->smarty->template_functions['displayOpen']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?>
	<?php smarty_template_function_displayGeneralReserved($_smarty_tpl,array('Slot'=>$_smarty_tpl->tpl_vars['Slot']->value,'Href'=>$_smarty_tpl->tpl_vars['Href']->value,'SlotRef'=>$_smarty_tpl->tpl_vars['SlotRef']->value,'OwnershipClass'=>'open'));?>

<?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>


<?php if (!function_exists('smarty_template_function_displayPaid')) {
    function smarty_template_function_displayPaid($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->smarty->template_functions['displayPaid']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?>
    <?php smarty_template_function_displayGeneralReserved($_smarty_tpl,array('Slot'=>$_smarty_tpl->tpl_vars['Slot']->value,'Href'=>$_smarty_tpl->tpl_vars['Href']->value,'SlotRef'=>$_smarty_tpl->tpl_vars['SlotRef']->value,'OwnershipClass'=>'paid'));?>

<?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>


<?php if (!function_exists('smarty_template_function_displayPastTime')) {
    function smarty_template_function_displayPastTime($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->smarty->template_functions['displayPastTime']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?>
	<td <?php echo (($tmp = @$_smarty_tpl->tpl_vars['spantype']->value)===null||$tmp==='' ? 'col' : $tmp);?>
span="<?php echo $_smarty_tpl->tpl_vars['Slot']->value->PeriodSpan();?>
" ref="<?php echo $_smarty_tpl->tpl_vars['SlotRef']->value;?>
"
		class="pasttime slot"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['escapequotes'][0][0]->EscapeQuotes($_smarty_tpl->tpl_vars['Slot']->value->Label($_smarty_tpl->tpl_vars['SlotLabelFactory']->value));?>
</td>
<?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>


<?php if (!function_exists('smarty_template_function_displayReservable')) {
    function smarty_template_function_displayReservable($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->smarty->template_functions['displayReservable']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?>
	<td <?php echo (($tmp = @$_smarty_tpl->tpl_vars['spantype']->value)===null||$tmp==='' ? 'col' : $tmp);?>
span="<?php echo $_smarty_tpl->tpl_vars['Slot']->value->PeriodSpan();?>
" ref="<?php echo $_smarty_tpl->tpl_vars['SlotRef']->value;?>
" class="reservable clickres slot <?php echo $_smarty_tpl->tpl_vars['schedule2_color']->value;?>
" colnum="<?php echo $_smarty_tpl->tpl_vars['colnum']->value;?>
">
		&nbsp;
		<input type="hidden" class="href" value="<?php echo $_smarty_tpl->tpl_vars['Href']->value;?>
"/>
		<input type="hidden" class="start" value="<?php echo rawurlencode($_smarty_tpl->tpl_vars['Slot']->value->BeginDate()->Format('Y-m-d H:i:s'));?>
"/>
		<input type="hidden" class="end" value="<?php echo rawurlencode($_smarty_tpl->tpl_vars['Slot']->value->EndDate()->Format('Y-m-d H:i:s'));?>
"/>
        <?php if ($_smarty_tpl->tpl_vars['isCallRes']->value){?>
            <input type="hidden" class="callid" value="<?php echo $_smarty_tpl->tpl_vars['callid']->value;?>
"/>
        <?php }?>
	</td>
<?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>


<?php if (!function_exists('smarty_template_function_displayRestricted')) {
    function smarty_template_function_displayRestricted($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->smarty->template_functions['displayRestricted']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?>
	<td <?php echo (($tmp = @$_smarty_tpl->tpl_vars['spantype']->value)===null||$tmp==='' ? 'col' : $tmp);?>
span="<?php echo $_smarty_tpl->tpl_vars['Slot']->value->PeriodSpan();?>
" class="restricted slot">&nbsp;</td>
<?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>


<?php if (!function_exists('smarty_template_function_displayUnreservable')) {
    function smarty_template_function_displayUnreservable($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->smarty->template_functions['displayUnreservable']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?>
	<td <?php echo (($tmp = @$_smarty_tpl->tpl_vars['spantype']->value)===null||$tmp==='' ? 'col' : $tmp);?>
span="<?php echo $_smarty_tpl->tpl_vars['Slot']->value->PeriodSpan();?>
"
		class="unreservable slot"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['Slot']->value->Label($_smarty_tpl->tpl_vars['SlotLabelFactory']->value), ENT_QUOTES, 'UTF-8', true);?>
</td>
<?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>


<?php if (!function_exists('smarty_template_function_displaySlot')) {
    function smarty_template_function_displaySlot($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->smarty->template_functions['displaySlot']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?>
	<?php $tmp = "smarty_template_function_".$_smarty_tpl->tpl_vars['DisplaySlotFactory']->value->GetFunction($_smarty_tpl->tpl_vars['Slot']->value,$_smarty_tpl->tpl_vars['AccessAllowed']->value,$_smarty_tpl->tpl_vars['resource']->value); $tmp($_smarty_tpl,array('Slot'=>$_smarty_tpl->tpl_vars['Slot']->value,'Href'=>$_smarty_tpl->tpl_vars['Href']->value,'SlotRef'=>$_smarty_tpl->tpl_vars['SlotRef']->value,'colnum'=>$_smarty_tpl->tpl_vars['colnum']->value));?>

<?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>





	<?php /*  Call merged included template "globalheader.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate('globalheader.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('cssFiles'=>'css/schedule.css,css/jquery.qtip.min.css'), 0, '6939005685409efc6914d81-16632226');
content_5409efc6a82d7($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "globalheader.tpl" */?>



	<div style="display:none;">
		
		<a href="#" id="make_default"
		   style="display:none;"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['html_image'][0][0]->PrintImage(array('src'=>"star_boxed_full.png",'altKey'=>"MakeDefaultSchedule"),$_smarty_tpl);?>
</a>
		<a href="#" id="rotate_schedule"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['html_image'][0][0]->PrintImage(array('src'=>"arrow-turn.png",'altKey'=>"FlipSchedule"),$_smarty_tpl);?>
</a>
	</div>


<div id="defaultSetMessage" class="success hidden">
	<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'DefaultScheduleSet'),$_smarty_tpl);?>

</div>


	<div>
		<div class="schedule_title">
			<span>Πρόγραμμα γηπέδων</span>
			<?php if (count($_smarty_tpl->tpl_vars['Schedules']->value)>0&&false){?>
				<ul class="schedule_drop">
					<li id="show_schedule"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['html_image'][0][0]->PrintImage(array('src'=>"down_sm_blue.png",'alt'=>"Αλλαγή Γηπέδων"),$_smarty_tpl);?>
</li>
					<ul style="display:none;" id="schedule_list">
							<li><a href="#"
								   onclick="ChangeSchedule(<?php echo 3;?>
); return false;">Γήπεδα 16:15</a>
							</li>
							<li><a href="#"
								   onclick="ChangeSchedule(<?php echo 4;?>
); return false;">Γήπεδα 16:30</a>
							</li>
                            <li><a href="#"
								   onclick="ChangeSchedule(<?php echo 5;?>
); return false;">Γήπεδα 16:45</a>
							</li>
                    </ul>
				</ul>  
            <?php }?>
			<a href="#" id="calendar_toggle"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['html_image'][0][0]->PrintImage(array('src'=>"calendar.png",'altKey'=>"ShowHideNavigation"),$_smarty_tpl);?>
</a>
		</div>

		<?php $_smarty_tpl->_capture_stack[0][] = array("date_navigation", null, null); ob_start(); ?>
			<div class="schedule_dates">
				<?php $_smarty_tpl->tpl_vars['FirstDate'] = new Smarty_variable($_smarty_tpl->tpl_vars['DisplayDates']->value->GetBegin(), null, 0);?>
				<?php $_smarty_tpl->tpl_vars['LastDate'] = new Smarty_variable($_smarty_tpl->tpl_vars['DisplayDates']->value->GetEnd(), null, 0);?>
				<a href="#" onclick="ChangeDate(<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['formatdate'][0][0]->FormatDate(array('date'=>$_smarty_tpl->tpl_vars['PreviousDate']->value,'format'=>"Y, m, d"),$_smarty_tpl);?>
); return false;"><img
							src="img/arrow_large_left.png" alt="Back"/></a>
				<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['formatdate'][0][0]->FormatDate(array('date'=>$_smarty_tpl->tpl_vars['FirstDate']->value),$_smarty_tpl);?>
 - <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['formatdate'][0][0]->FormatDate(array('date'=>$_smarty_tpl->tpl_vars['LastDate']->value),$_smarty_tpl);?>

				<a href="#" onclick="ChangeDate(<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['formatdate'][0][0]->FormatDate(array('date'=>$_smarty_tpl->tpl_vars['NextDate']->value,'format'=>"Y, m, d"),$_smarty_tpl);?>
); return false;"><img
							src="img/arrow_large_right.png" alt="Forward"/></a>

				
					
					   
        
					
        
				
			</div>
		<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>

		<?php echo Smarty::$_smarty_vars['capture']['date_navigation'];?>

	</div>
	<div type="text" id="datepicker" style="display:none;"></div>

<div style="text-align: center; margin: auto;">
    <div class="legend reservable"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Reservable'),$_smarty_tpl);?>
</div>
    <div class="legend pasttime"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Past'),$_smarty_tpl);?>
</div>
    <div class="legend reserved"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Reserved'),$_smarty_tpl);?>
</div>
    <div class="legend reserved mine"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'MyReservation'),$_smarty_tpl);?>
</div>
    <div class="legend reserved game"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Calls'),$_smarty_tpl);?>
</div>
    <div class="legend restricted"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Restricted'),$_smarty_tpl);?>
</div>
</div>

<div style="height:10px">&nbsp;</div>


<?php $_smarty_tpl->tpl_vars['TodaysDate'] = new Smarty_variable(Date::Now(), null, 0);?>
<div id="reservations">
    <table cellpadding="0" cellspacing="0" width="100%">
    <?php $_smarty_tpl->tpl_vars['firstScheduleDay'] = new Smarty_variable(true, null, 0);?>
    <?php $_smarty_tpl->tpl_vars['numOfDays'] = new Smarty_variable(count($_smarty_tpl->tpl_vars['BoundDates']->value), null, 0);?>
    <?php $_smarty_tpl->tpl_vars['dayCounter'] = new Smarty_variable(1, null, 0);?>
    <?php  $_smarty_tpl->tpl_vars['date'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['date']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['BoundDates']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['date']->key => $_smarty_tpl->tpl_vars['date']->value){
$_smarty_tpl->tpl_vars['date']->_loop = true;
?>
        <?php $_smarty_tpl->tpl_vars["showDate"] = new Smarty_variable(true, null, 0);?>
        <tr>
            <td class="<?php if ($_smarty_tpl->tpl_vars['firstScheduleDay']->value){?>first_schedule_day<?php $_smarty_tpl->tpl_vars['firstScheduleDay'] = new Smarty_variable(false, null, 0);?><?php }else{ ?>schedule_day<?php }?>">
                <?php  $_smarty_tpl->tpl_vars['schedule'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['schedule']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['Schedules']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['schedule']->key => $_smarty_tpl->tpl_vars['schedule']->value){
$_smarty_tpl->tpl_vars['schedule']->_loop = true;
?>
                    <?php $_smarty_tpl->tpl_vars["colnum"] = new Smarty_variable(1, null, 0);?>
                        <table class="reservations" cellpadding="0" width="100%">
                            
                            <?php $_smarty_tpl->tpl_vars["Resources"] = new Smarty_variable($_smarty_tpl->tpl_vars['schedule']->value->getScheduleResources($_smarty_tpl->tpl_vars['viewSchedule']->value), null, 0);?>
                            <?php $_smarty_tpl->tpl_vars["ScheduleLayout"] = new Smarty_variable($_smarty_tpl->tpl_vars['schedule']->value->getScheduleLayout(), null, 0);?>
                            <?php $_smarty_tpl->tpl_vars["Periods"] = new Smarty_variable($_smarty_tpl->tpl_vars['ScheduleLayout']->value->GetPeriods($_smarty_tpl->tpl_vars['date']->value,true), null, 0);?>
                            <?php if (count($_smarty_tpl->tpl_vars['Resources']->value)>0){?>
                                <?php if ($_smarty_tpl->tpl_vars['TodaysDate']->value->DateEquals($_smarty_tpl->tpl_vars['date']->value)==true){?>
                                    <tr class="today periodHolder">
                                        <?php }else{ ?>
                                        <tr class="periodHolder">
                                <?php }?>
                                <?php if ($_smarty_tpl->tpl_vars['showDate']->value){?>
                                    <?php $_smarty_tpl->tpl_vars["showDate"] = new Smarty_variable(false, null, 0);?>
                                    <td class="resdate"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['formatdate'][0][0]->FormatDate(array('date'=>$_smarty_tpl->tpl_vars['date']->value,'key'=>"schedule_daily"),$_smarty_tpl);?>
</td>
                                <?php }else{ ?>
                                    <td class="resdate_empty">&nbsp;</td>
                                <?php }?>
                                <?php  $_smarty_tpl->tpl_vars['period'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['period']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['Periods']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['period']->key => $_smarty_tpl->tpl_vars['period']->value){
$_smarty_tpl->tpl_vars['period']->_loop = true;
?>
                                    <td class="reslabel" colspan="<?php echo $_smarty_tpl->tpl_vars['period']->value->Span();?>
" colnum="<?php echo $_smarty_tpl->tpl_vars['colnum']->value++;?>
"><?php echo $_smarty_tpl->tpl_vars['period']->value->Label($_smarty_tpl->tpl_vars['date']->value);?>
</td>
                                <?php } ?>
                                </tr>
                                <?php  $_smarty_tpl->tpl_vars['resource'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['resource']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['Resources']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['resource']->key => $_smarty_tpl->tpl_vars['resource']->value){
$_smarty_tpl->tpl_vars['resource']->_loop = true;
?>
                                    <?php $_smarty_tpl->tpl_vars["colnum"] = new Smarty_variable(1, null, 0);?>
                                    <?php $_smarty_tpl->tpl_vars['resourceId'] = new Smarty_variable($_smarty_tpl->tpl_vars['resource']->value->Id, null, 0);?>
                                    <?php $_smarty_tpl->tpl_vars['slots'] = new Smarty_variable($_smarty_tpl->tpl_vars['ScheduleLayout']->value->GetLayout($_smarty_tpl->tpl_vars['date']->value,$_smarty_tpl->tpl_vars['resourceId']->value), null, 0);?>
                                    <?php ob_start();?><?php echo Pages::RESERVATION;?>
<?php $_tmp1=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['formatdate'][0][0]->FormatDate(array('date'=>$_smarty_tpl->tpl_vars['date']->value,'key'=>'url'),$_smarty_tpl);?>
<?php $_tmp2=ob_get_clean();?><?php $_smarty_tpl->tpl_vars['href'] = new Smarty_variable($_tmp1."?rid=".($_smarty_tpl->tpl_vars['resource']->value->Id)."&sid=".($_smarty_tpl->tpl_vars['schedule']->value->GetId())."&rd=".$_tmp2, null, 0);?>
                                    <tr class="<?php if ($_smarty_tpl->tpl_vars['TodaysDate']->value->DateEquals($_smarty_tpl->tpl_vars['date']->value)==true){?>today <?php }?>slots">
                                        <td class="resourcename">
                                            <?php echo $_smarty_tpl->tpl_vars['resource']->value->Name;?>

                                        </td>
                                        <?php  $_smarty_tpl->tpl_vars['slot'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['slot']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['slots']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['slot']->key => $_smarty_tpl->tpl_vars['slot']->value){
$_smarty_tpl->tpl_vars['slot']->_loop = true;
?>
                                            <?php $_smarty_tpl->tpl_vars['slotRef'] = new Smarty_variable(($_smarty_tpl->tpl_vars['slot']->value->BeginDate()->Format('YmdHis')).($_smarty_tpl->tpl_vars['resourceId']->value), null, 0);?>
                                            <?php smarty_template_function_displaySlot($_smarty_tpl,array('Slot'=>$_smarty_tpl->tpl_vars['slot']->value,'Href'=>($_smarty_tpl->tpl_vars['href']->value),'AccessAllowed'=>$_smarty_tpl->tpl_vars['resource']->value->CanAccess,'SlotRef'=>$_smarty_tpl->tpl_vars['slotRef']->value,'resource'=>$_smarty_tpl->tpl_vars['resource']->value,'colnum'=>$_smarty_tpl->tpl_vars['colnum']->value++));?>

                                        <?php } ?>
                                    </tr>
                                <?php } ?>
                            <?php }?>
                        </table>
                    <?php } ?>
                <?php if ($_smarty_tpl->tpl_vars['dayCounter']->value++<$_smarty_tpl->tpl_vars['numOfDays']->value){?>
                    
                        
                            
                        
                    
                <?php }?>
            </td>
        </tr>
    <?php } ?>
    </table>
</div>
<input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['ScheduleId']->value;?>
" id="scheduleId"/>



	<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
scripts/js/jquery.qtip.min.js"></script>
	<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
scripts/schedule.js"></script>
	<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
scripts/resourcePopup.js"></script>
	<script type="text/javascript">

		$(document).ready(function ()
		{
			var scheduleOpts = {
				reservationUrlTemplate: "<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
<?php echo Pages::RESERVATION;?>
?<?php echo QueryStringKeys::REFERENCE_NUMBER;?>
=[referenceNumber]",
				summaryPopupUrl: "<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
ajax/respopup.php",
				setDefaultScheduleUrl: "<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
<?php echo Pages::PROFILE;?>
?action=changeDefaultSchedule&<?php echo QueryStringKeys::SCHEDULE_ID;?>
=[scheduleId]",
				cookieName: "<?php echo $_smarty_tpl->tpl_vars['CookieName']->value;?>
",
				cookieValue: "<?php echo $_smarty_tpl->tpl_vars['CookieValue']->value;?>
"
			};

			var schedule = new Schedule(scheduleOpts);
			schedule.init();
		});
	</script>


<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['control'][0][0]->DisplayControl(array('type'=>"DatePickerSetupControl",'ControlId'=>'datepicker','DefaultDate'=>$_smarty_tpl->tpl_vars['FirstDate']->value,'NumberOfMonths'=>'3','ShowButtonPanel'=>'true','OnSelect'=>'dpDateChanged','FirstDay'=>$_smarty_tpl->tpl_vars['FirstWeekday']->value),$_smarty_tpl);?>


<?php if ($_smarty_tpl->tpl_vars['IsThereImportantAnnouncement']->value){?>
<div id="announcements_dialog" title="Basic dialog">
  <div style="font-size:14px;"><?php echo $_smarty_tpl->tpl_vars['announcement_text']->value;?>
</div>
</div>
<script type="text/javascript">
	document.cookie="read_ann=<?php echo $_smarty_tpl->tpl_vars['announcement_cookie_val']->value;?>
";
	$('#announcements_dialog').dialog({
		autoOpen: false, modal: true, draggable: false, resizable: false, closeOnEscape: false,
		minHeight: 400, minWidth: 700, width: 700,
		open: function(event, ui) {
			$(this).parents(".ui-dialog:first").find(".ui-dialog-titlebar").hide();
			$(this).append('<div style="text-align:center;"><input type="button" class="button" onclick="$(\'#announcements_dialog\').dialog(\'close\');" value="Κλείσιμο" /></div>');
		}
	});
	$('#announcements_dialog').dialog("open");
	
</script>
<?php }?>

<?php echo $_smarty_tpl->getSubTemplate ('globalfooter.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?><?php /* Smarty version Smarty-3.1.7, created on 2014-09-05 18:15:50
         compiled from "/home/acetenni/public_html/bookings/lib/Common/../../tpl/globalheader.tpl" */ ?>
<?php if ($_valid && !is_callable('content_5409efc6a82d7')) {function content_5409efc6a82d7($_smarty_tpl) {?><?php echo '<?xml';?> version="1.0" encoding="<?php echo $_smarty_tpl->tpl_vars['Charset']->value;?>
"<?php echo '?>';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
		"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html
		xmlns="http://www.w3.org/1999/xhtml" lang="<?php echo $_smarty_tpl->tpl_vars['HtmlLang']->value;?>
" xml:lang="<?php echo $_smarty_tpl->tpl_vars['HtmlLang']->value;?>
" dir="<?php echo $_smarty_tpl->tpl_vars['HtmlTextDirection']->value;?>
">
<head>
	<title><?php if ($_smarty_tpl->tpl_vars['TitleKey']->value!=''){?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>$_smarty_tpl->tpl_vars['TitleKey']->value,'args'=>$_smarty_tpl->tpl_vars['TitleArgs']->value),$_smarty_tpl);?>
<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['Title']->value;?>
<?php }?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_smarty_tpl->tpl_vars['Charset']->value;?>
"/>
	<meta name="robots" content="noindex" />
<?php if ($_smarty_tpl->tpl_vars['ShouldLogout']->value){?>
	<meta http-equiv="REFRESH" content="<?php echo $_smarty_tpl->tpl_vars['SessionTimeoutSeconds']->value;?>
;URL=<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
logout.php?<?php echo QueryStringKeys::REDIRECT;?>
=<?php echo urlencode($_SERVER['REQUEST_URI']);?>
">
<?php }?>
	<link rel="shortcut icon" href="<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
favicon.ico"/>
	<link rel="icon" href="<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
favicon.ico"/>
    <?php if ($_smarty_tpl->tpl_vars['rankingCss']->value){?>
        <link href="<?php echo $_smarty_tpl->tpl_vars['rankingCss']->value;?>
" rel="stylesheet" type="text/css" />
    <?php }?>
	<?php if ($_smarty_tpl->tpl_vars['UseLocalJquery']->value){?>
		<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
scripts/js/jquery-1.8.2.min.js"></script>
		<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
scripts/js/jquery-ui-1.9.0.custom.min.js"></script>
	<?php }else{ ?>
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.0/jquery-ui.min.js"></script>
	<?php }?>
	<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
scripts/phpscheduleit.js"></script>
	<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
scripts/menubar.js"></script>
	<style type="text/css">
		@import url(<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
css/nav.css);
		@import url(<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
css/style.css);
		<?php if ($_smarty_tpl->tpl_vars['UseLocalJquery']->value){?>
			@import url(<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
scripts/css/smoothness/jquery-ui-1.9.0.custom.min.css);
		<?php }else{ ?>
			@import url(//ajax.googleapis.com/ajax/libs/jqueryui/1.9.0/themes/smoothness/jquery-ui.css);
		<?php }?>
		<?php if ($_smarty_tpl->tpl_vars['cssFiles']->value!=''){?>
			<?php $_smarty_tpl->tpl_vars['CssFileList'] = new Smarty_variable(explode(',',$_smarty_tpl->tpl_vars['cssFiles']->value), null, 0);?>
			<?php  $_smarty_tpl->tpl_vars['cssFile'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['cssFile']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['CssFileList']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['cssFile']->key => $_smarty_tpl->tpl_vars['cssFile']->value){
$_smarty_tpl->tpl_vars['cssFile']->_loop = true;
?>
			@import url(<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
<?php echo $_smarty_tpl->tpl_vars['cssFile']->value;?>
);
			<?php } ?>
		<?php }?>
		@import url('<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
css/<?php echo $_smarty_tpl->tpl_vars['CssUrl']->value;?>
');
		<?php if ($_smarty_tpl->tpl_vars['CssExtensionFile']->value!=''){?>
			@import url('<?php echo $_smarty_tpl->tpl_vars['CssExtensionFile']->value;?>
');
		<?php }?>
	</style>

	<?php if ($_smarty_tpl->tpl_vars['printCssFiles']->value!=''){?>
		<?php $_smarty_tpl->tpl_vars['PrintCssFileList'] = new Smarty_variable(explode(',',$_smarty_tpl->tpl_vars['printCssFiles']->value), null, 0);?>
		<?php  $_smarty_tpl->tpl_vars['cssFile'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['cssFile']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['PrintCssFileList']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['cssFile']->key => $_smarty_tpl->tpl_vars['cssFile']->value){
$_smarty_tpl->tpl_vars['cssFile']->_loop = true;
?>
		<link rel='stylesheet' type='text/css' href='<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
<?php echo $_smarty_tpl->tpl_vars['cssFile']->value;?>
' media='print' />
		<?php } ?>
	<?php }?>

	<script type="text/javascript">
		$(document).ready(function () {
		initMenu();
		});
	</script>
</head>
<body>
<div id="wrapper">
	<div id="doc">
		<div id="header">
            <div id="logo"><a href="<?php echo $_smarty_tpl->tpl_vars['HomeUrl']->value;?>
"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['html_image'][0][0]->PrintImage(array('src'=>($_smarty_tpl->tpl_vars['LogoUrl']->value)),$_smarty_tpl);?>
</a></div>
			<div id="header-top">
				<div id="signout">
				<?php if ($_smarty_tpl->tpl_vars['LoggedIn']->value){?>
					<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>"SignedInAs"),$_smarty_tpl);?>
 <?php echo $_smarty_tpl->tpl_vars['UserName']->value;?>
<br/><a href="<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
logout.php"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>"SignOut"),$_smarty_tpl);?>
</a>
					<?php }else{ ?>
					<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>"NotSignedIn"),$_smarty_tpl);?>
<br/><a href="<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
index.php"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>"LogIn"),$_smarty_tpl);?>
</a>
				<?php }?>
				</div>
			</div>
			<ul id="nav" class="menubar">
			<?php if ($_smarty_tpl->tpl_vars['LoggedIn']->value){?>
				<li class="menubaritem first"><a href="<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
<?php echo Pages::DASHBOARD;?>
"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>"Dashboard"),$_smarty_tpl);?>
</a></li>
                <li class="menubaritem"><a href="<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
<?php echo Pages::PROFILE;?>
"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>"MyAccount"),$_smarty_tpl);?>
</a>
                    <ul>
                        <li class="menuitem"><a href="<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
<?php echo Pages::PROFILE;?>
"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>"Profile"),$_smarty_tpl);?>
</a></li>
                        <li class="menuitem"><a href="<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
<?php echo Pages::PASSWORD;?>
"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>"ChangePassword"),$_smarty_tpl);?>
</a></li>
                        
                    </ul>
                </li>
				<li class="menubaritem"><a href="<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
<?php echo Pages::SCHEDULE;?>
"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>"Schedule"),$_smarty_tpl);?>
</a></li>
                <li class="menubaritem"><a href="javascript: void(0);"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>"PointSystem"),$_smarty_tpl);?>
</a>
                	<ul>
						<li class="menuitem"><a href="<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
<?php echo Pages::RANKING;?>
"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>"Ranking"),$_smarty_tpl);?>
</a></li>
						<li class="menuitem"><a href="<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
<?php echo Pages::CALLS;?>
"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>"Calls"),$_smarty_tpl);?>
</a></li>
                        <li class="menuitem"><a href="<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
<?php echo Pages::TOURNAMENTS;?>
"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>"Tours"),$_smarty_tpl);?>
</a></li>
					</ul>
                </li>
			<?php if ($_smarty_tpl->tpl_vars['CanViewAdmin']->value){?>
				<li class="menubaritem"><a href="#"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'ApplicationManagement'),$_smarty_tpl);?>
</a>
					<ul>
                        <li class="menuitem"><a href="<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
admin/manage_reservations.php"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>"ManageReservations"),$_smarty_tpl);?>
</a></li>
                        <li class="menuitem"><a href="<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
admin/manage_resources.php"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>"ManageResources"),$_smarty_tpl);?>
</a></li>
						<li class="menuitem"><a href="<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
admin/manage_users.php"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>"ManageUsers"),$_smarty_tpl);?>
</a></li>

						<li class="menuitem"><a href="<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
admin/manage_groups.php"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>"ManageGroups"),$_smarty_tpl);?>
</a></li>
                        <li class="menuitem"><a href="<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
admin/manage_quotas.php"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>"ManageQuotas"),$_smarty_tpl);?>
</a></li>
						<li class="menuitem"><a href="<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
admin/manage_announcements.php"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>"ManageAnnouncements"),$_smarty_tpl);?>
</a></li>
                        <li class="menuitem"><a href="<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
admin/manage_attributes.php"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>"Customization"),$_smarty_tpl);?>
</a>
						
                        <li class="menuitem"><a href="#"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>"RankingCustomization"),$_smarty_tpl);?>
</a>
                            <ul>
                                <li class="menuitem"><a href="<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
<?php echo Pages::RANKING_ADMINISTRATION;?>
"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>"RankingAdmin"),$_smarty_tpl);?>
</a></li>
                                <li class="menuitem"><a href="<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
<?php echo Pages::RANKING_VARIABLES;?>
"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>"RankingVars"),$_smarty_tpl);?>
</a></li>
                            </ul>
                        </li>
                        <li class="menuitem"><a href="<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
reports/generate-report.php"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>"Search"),$_smarty_tpl);?>
</a></li>
					</ul>
				</li>
			<?php }?>
			<?php }?>
			</ul>
			<!-- end #nav -->
		</div>
		<!-- end #header -->
		<div id="content"><?php }} ?>