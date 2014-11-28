<?php /* Smarty version Smarty-3.1.7, created on 2014-09-05 18:16:33
         compiled from "/home/acetenni/public_html/bookings/lib/Common/../../tpl/Reservation/edit.tpl" */ ?>
<?php /*%%SmartyHeaderCode:10722872955409eff19b63e3-57543160%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '99ffa7e38069e7bb0c735de3847f62166618c889' => 
    array (
      0 => '/home/acetenni/public_html/bookings/lib/Common/../../tpl/Reservation/edit.tpl',
      1 => 1409936899,
      2 => 'file',
    ),
    '1cf02a036767c9025c00624261e0fa322134ecfb' => 
    array (
      0 => '/home/acetenni/public_html/bookings/lib/Common/../../tpl/Reservation/create.tpl',
      1 => 1409936899,
      2 => 'file',
    ),
    'dec7f7ac12a19a3a3834bca80bcd3b3c03a582d5' => 
    array (
      0 => '/home/acetenni/public_html/bookings/lib/Common/../../tpl/globalheader.tpl',
      1 => 1409936867,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10722872955409eff19b63e3-57543160',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'ReservationUserName' => 0,
    'UserId' => 0,
    'ownerPhone' => 0,
    'CanChangeUser' => 0,
    'ResourceName' => 0,
    'ResourceId' => 0,
    'ScheduleId' => 0,
    'StartDate' => 0,
    'StartPeriods' => 0,
    'period' => 0,
    'SelectedStart' => 0,
    'selected' => 0,
    'EndDate' => 0,
    'EndPeriods' => 0,
    'SelectedEnd' => 0,
    'IsAdmin' => 0,
    'IsCoach' => 0,
    'RepeatTerminationDate' => 0,
    'calls' => 0,
    'defCall' => 0,
    'v' => 0,
    'UploadsEnabled' => 0,
    'MaxUploadSize' => 0,
    'RemindersEnabled' => 0,
    'ShowUserDetails' => 0,
    'ShowParticipation' => 0,
    'Attributes' => 0,
    'attribute' => 0,
    'ReservationId' => 0,
    'ReferenceNumber' => 0,
    'ReservationAction' => 0,
    'ReturnUrl' => 0,
    'AvailableResources' => 0,
    'resource' => 0,
    'AdditionalResourceIds' => 0,
    'checked' => 0,
    'AvailableAccessories' => 0,
    'accessory' => 0,
    'RepeatType' => 0,
    'RepeatInterval' => 0,
    'RepeatMonthlyType' => 0,
    'RepeatWeekdays' => 0,
    'day' => 0,
    'ReminderTimeStart' => 0,
    'ReminderTimeEnd' => 0,
    'ReminderIntervalStart' => 0,
    'ReminderIntervalEnd' => 0,
    'Participants' => 0,
    'user' => 0,
    'Invitees' => 0,
    'Accessories' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5409eff207b42',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5409eff207b42')) {function content_5409eff207b42($_smarty_tpl) {?>
	<?php /*  Call merged included template "globalheader.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate('globalheader.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('TitleKey'=>'EditReservationHeading','TitleArgs'=>$_smarty_tpl->tpl_vars['ReferenceNumber']->value,'cssFiles'=>'css/reservation.css,css/jquery.qtip.min.css'), 0, '10722872955409eff19b63e3-57543160');
content_5409eff1b4140($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "globalheader.tpl" */?>


<div id="reservationbox">

<form id="reservationForm" method="post" enctype="multipart/form-data">
<div class="reservationHeader">
    <h3>
	<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>"EditReservationHeading",'args'=>$_smarty_tpl->tpl_vars['ReferenceNumber']->value),$_smarty_tpl);?>

</h3>
</div>
<div id="reservationDetails">
    <ul class="no-style">
        <li>
            <span id="userName"><?php echo $_smarty_tpl->tpl_vars['ReservationUserName']->value;?>
</span> <input id="userId"
                                                                     type="hidden" <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['formname'][0][0]->GetFormName(array('key'=>'USER_ID'),$_smarty_tpl);?>

                                                                     value="<?php echo $_smarty_tpl->tpl_vars['UserId']->value;?>
"/>
            <?php echo $_smarty_tpl->tpl_vars['ownerPhone']->value;?>

		<?php if ($_smarty_tpl->tpl_vars['CanChangeUser']->value){?>
            <a href="#" id="showChangeUsers">(<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Change'),$_smarty_tpl);?>
)</a>

            <div id="changeUserDialog" title="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'ChangeUser'),$_smarty_tpl);?>
" class="dialog"></div>
		<?php }?>
        </li>
        <li style="display:none;" id="changeUsers">
            <input type="text" id="changeUserAutocomplete" class="input" style="width:250px;"/>
            |
            <button id="promptForChangeUsers" type="button" class="button" style="display:inline">
                <img src="img/users.png"/>
			<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'AllUsers'),$_smarty_tpl);?>

            </button>
        </li>
    </ul>
    <ul class="no-style">
        <li>
            <div>
                <div style="float:left;">
                        <?php echo $_smarty_tpl->tpl_vars['ResourceName']->value;?>

                        <input class="resourceId" type="hidden" <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['formname'][0][0]->GetFormName(array('key'=>'RESOURCE_ID'),$_smarty_tpl);?>
 value="<?php echo $_smarty_tpl->tpl_vars['ResourceId']->value;?>
"/>
                        <input type="hidden" id="scheduleId" <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['formname'][0][0]->GetFormName(array('key'=>'SCHEDULE_ID'),$_smarty_tpl);?>
 value="<?php echo $_smarty_tpl->tpl_vars['ScheduleId']->value;?>
"/>
                </div>
            </div>
            <div style="clear:both;height:0;">&nbsp;</div>
        </li>
        <li>
            <label for="BeginDate" style="width:50px;display:inline-block;"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'BeginDate'),$_smarty_tpl);?>
</label>
            <input type="text" id="BeginDate" class="dateinput" value="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['formatdate'][0][0]->FormatDate(array('date'=>$_smarty_tpl->tpl_vars['StartDate']->value),$_smarty_tpl);?>
"/>
            <input type="hidden" id="formattedBeginDate" <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['formname'][0][0]->GetFormName(array('key'=>'BEGIN_DATE'),$_smarty_tpl);?>

                   value="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['formatdate'][0][0]->FormatDate(array('date'=>$_smarty_tpl->tpl_vars['StartDate']->value,'key'=>'system'),$_smarty_tpl);?>
"/>
            <select id="BeginPeriod" <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['formname'][0][0]->GetFormName(array('key'=>'BEGIN_PERIOD'),$_smarty_tpl);?>
 class="pulldown" style="width:150px">
			<?php  $_smarty_tpl->tpl_vars['period'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['period']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['StartPeriods']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['period']->key => $_smarty_tpl->tpl_vars['period']->value){
$_smarty_tpl->tpl_vars['period']->_loop = true;
?>
				<?php if ($_smarty_tpl->tpl_vars['period']->value->IsReservable()){?>
					<?php $_smarty_tpl->tpl_vars['selected'] = new Smarty_variable('', null, 0);?>
					<?php if ($_smarty_tpl->tpl_vars['period']->value==$_smarty_tpl->tpl_vars['SelectedStart']->value){?>
						<?php $_smarty_tpl->tpl_vars['selected'] = new Smarty_variable(' selected="selected"', null, 0);?>
					<?php }?>
                    <option value="<?php echo $_smarty_tpl->tpl_vars['period']->value->Begin();?>
"<?php echo $_smarty_tpl->tpl_vars['selected']->value;?>
><?php echo $_smarty_tpl->tpl_vars['period']->value->Label();?>
</option>
				<?php }?>
			<?php } ?>
            </select>
        </li>
        <li>
            <label for="EndDate" style="width:50px;display:inline-block;"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'EndDate'),$_smarty_tpl);?>
</label>
            <input type="text" id="EndDate" class="dateinput" value="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['formatdate'][0][0]->FormatDate(array('date'=>$_smarty_tpl->tpl_vars['EndDate']->value),$_smarty_tpl);?>
"/>
            <input type="hidden" id="formattedEndDate" <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['formname'][0][0]->GetFormName(array('key'=>'END_DATE'),$_smarty_tpl);?>

                   value="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['formatdate'][0][0]->FormatDate(array('date'=>$_smarty_tpl->tpl_vars['EndDate']->value,'key'=>'system'),$_smarty_tpl);?>
"/>
            <select id="EndPeriod" <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['formname'][0][0]->GetFormName(array('key'=>'END_PERIOD'),$_smarty_tpl);?>
 class="pulldown" style="width:150px">
			<?php  $_smarty_tpl->tpl_vars['period'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['period']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['EndPeriods']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['period']->key => $_smarty_tpl->tpl_vars['period']->value){
$_smarty_tpl->tpl_vars['period']->_loop = true;
?>
				<?php if ($_smarty_tpl->tpl_vars['period']->value->BeginDate()->IsMidnight()){?>
                    <option value="<?php echo $_smarty_tpl->tpl_vars['period']->value->Begin();?>
"<?php echo $_smarty_tpl->tpl_vars['selected']->value;?>
><?php echo $_smarty_tpl->tpl_vars['period']->value->Label();?>
</option>
				<?php }?>
				<?php if ($_smarty_tpl->tpl_vars['period']->value->IsReservable()){?>
					<?php $_smarty_tpl->tpl_vars['selected'] = new Smarty_variable('', null, 0);?>
					<?php if ($_smarty_tpl->tpl_vars['period']->value==$_smarty_tpl->tpl_vars['SelectedEnd']->value){?>
						<?php $_smarty_tpl->tpl_vars['selected'] = new Smarty_variable(' selected="selected"', null, 0);?>
					<?php }?>
                    <option value="<?php echo $_smarty_tpl->tpl_vars['period']->value->End();?>
"<?php echo $_smarty_tpl->tpl_vars['selected']->value;?>
><?php echo $_smarty_tpl->tpl_vars['period']->value->LabelEnd();?>
</option>
				<?php }?>
			<?php } ?>
            </select>
        </li>
        <li style="display:none;">
            <label><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'ReservationLength'),$_smarty_tpl);?>
</label>

            <div class="durationText">
                <span id="durationDays">0</span> <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'days'),$_smarty_tpl);?>
,
                <span id="durationHours">0</span> <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'hours'),$_smarty_tpl);?>

            </div>
        </li>
	

            <?php if ($_smarty_tpl->tpl_vars['IsAdmin']->value||$_smarty_tpl->tpl_vars['IsCoach']->value){?>
            <li>
            <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['control'][0][0]->DisplayControl(array('type'=>"RecurrenceControl",'RepeatTerminationDate'=>$_smarty_tpl->tpl_vars['RepeatTerminationDate']->value),$_smarty_tpl);?>

            </li>
            <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['calls']->value){?>
            <li>
				<div id="repeatDiv">
					<label><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>"chooseCallPrompt"),$_smarty_tpl);?>
</label>
					<select id="chooseACall" name="chooseACall" class="pulldown" style="width:250px" >
                        <option value="-1"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>"chooseNoCall"),$_smarty_tpl);?>
</option>
                    <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['calls']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                      <?php if ($_smarty_tpl->tpl_vars['defCall']->value==$_smarty_tpl->tpl_vars['v']->value->callid){?>
                        <option selected="selected" value="<?php echo $_smarty_tpl->tpl_vars['v']->value->callid;?>
" oppid="<?php echo $_smarty_tpl->tpl_vars['v']->value->opponent_id;?>
" oppname="<?php echo $_smarty_tpl->tpl_vars['v']->value->opponent_name;?>
">vs <?php echo $_smarty_tpl->tpl_vars['v']->value->opponent_name;?>
</option>
                      <?php }else{ ?>
                        <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value->callid;?>
" oppid="<?php echo $_smarty_tpl->tpl_vars['v']->value->opponent_id;?>
" oppname="<?php echo $_smarty_tpl->tpl_vars['v']->value->opponent_name;?>
">vs <?php echo $_smarty_tpl->tpl_vars['v']->value->opponent_name;?>
</option>
                      <?php }?>
                    <?php } ?>
					</select>
				</div>
			</li>
          	<?php }?>
        <li class="rsv-box-l">
            <label><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>"ReservationTitle"),$_smarty_tpl);?>
<br/>
			<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['textbox'][0][0]->Textbox(array('name'=>"RESERVATION_TITLE",'class'=>"input",'tabindex'=>"100",'value'=>"ReservationTitle"),$_smarty_tpl);?>

            </label>
        </li>
	<?php if ($_smarty_tpl->tpl_vars['UploadsEnabled']->value){?>
        <li>
            <label><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'AttachFile'),$_smarty_tpl);?>
<br/>
                <input type="file" <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['formname'][0][0]->GetFormName(array('key'=>'RESERVATION_FILE'),$_smarty_tpl);?>
 /> <span class="note">(<?php echo $_smarty_tpl->tpl_vars['MaxUploadSize']->value;?>

                    MB <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Maximum'),$_smarty_tpl);?>
)</span>
            </label>
        </li>
	<?php }?>
	<?php if ($_smarty_tpl->tpl_vars['RemindersEnabled']->value){?>
        <li>
            <label><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'SendReminder'),$_smarty_tpl);?>
</label> <br/>

            <div id="reminderOptionsStart">
                <input type="checkbox" class="reminderEnabled" <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['formname'][0][0]->GetFormName(array('key'=>'START_REMINDER_ENABLED'),$_smarty_tpl);?>
/>
                <input type="text" size="3" maxlength="3" value="15" class="reminderTime textbox" <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['formname'][0][0]->GetFormName(array('key'=>'START_REMINDER_TIME'),$_smarty_tpl);?>
/>
                <select class="reminderInterval textbox" <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['formname'][0][0]->GetFormName(array('key'=>'START_REMINDER_INTERVAL'),$_smarty_tpl);?>
>
                    <option value="<?php echo ReservationReminderInterval::Minutes;?>
"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'minutes'),$_smarty_tpl);?>
</option>
                    <option value="<?php echo ReservationReminderInterval::Hours;?>
"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'hours'),$_smarty_tpl);?>
</option>
                    <option value="<?php echo ReservationReminderInterval::Days;?>
"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'days'),$_smarty_tpl);?>
</option>
                </select>
                <span class="reminderLabel"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'ReminderBeforeStart'),$_smarty_tpl);?>
</span>
            </div>
            <div id="reminderOptionsEnd">
                <input type="checkbox" class="reminderEnabled" <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['formname'][0][0]->GetFormName(array('key'=>'END_REMINDER_ENABLED'),$_smarty_tpl);?>
/>
                <input type="text" size="3" maxlength="3" value="15" class="reminderTime textbox" <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['formname'][0][0]->GetFormName(array('key'=>'END_REMINDER_TIME'),$_smarty_tpl);?>
/>
                <select class="reminderInterval textbox" <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['formname'][0][0]->GetFormName(array('key'=>'END_REMINDER_INTERVAL'),$_smarty_tpl);?>
>
					<option value="<?php echo ReservationReminderInterval::Minutes;?>
"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'minutes'),$_smarty_tpl);?>
</option>
					<option value="<?php echo ReservationReminderInterval::Hours;?>
"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'hours'),$_smarty_tpl);?>
</option>
					<option value="<?php echo ReservationReminderInterval::Days;?>
"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'days'),$_smarty_tpl);?>
</option>
                </select>
                <span class="reminderLabel"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'ReminderBeforeEnd'),$_smarty_tpl);?>
</span>
            </div>
        </li>
	<?php }?>
    </ul>
</div>

<?php if ($_smarty_tpl->tpl_vars['ShowUserDetails']->value&&$_smarty_tpl->tpl_vars['ShowParticipation']->value){?>
<?php echo $_smarty_tpl->getSubTemplate ("Reservation/participation.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

	<?php }else{ ?>
<?php echo $_smarty_tpl->getSubTemplate ("Reservation/private-participation.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }?>

<div style="clear:both;">&nbsp;</div>
<?php if ($_smarty_tpl->tpl_vars['IsAdmin']->value&&count($_smarty_tpl->tpl_vars['Attributes']->value)>0){?>
<div class="customAttributes">
    <h3><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'AdditionalAttributes'),$_smarty_tpl);?>
</h3>
    <ul>
		<?php  $_smarty_tpl->tpl_vars['attribute'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['attribute']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['Attributes']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['attribute']->key => $_smarty_tpl->tpl_vars['attribute']->value){
$_smarty_tpl->tpl_vars['attribute']->_loop = true;
?>
            <li class="customAttribute">
				<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['control'][0][0]->DisplayControl(array('type'=>"AttributeControl",'attribute'=>$_smarty_tpl->tpl_vars['attribute']->value),$_smarty_tpl);?>

            </li>
		<?php } ?>
    </ul>
</div>
<div style="clear:both;">&nbsp;</div>
<?php }?>

<input type="hidden" <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['formname'][0][0]->GetFormName(array('key'=>'reservation_id'),$_smarty_tpl);?>
 value="<?php echo $_smarty_tpl->tpl_vars['ReservationId']->value;?>
"/>
<input type="hidden" <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['formname'][0][0]->GetFormName(array('key'=>'reference_number'),$_smarty_tpl);?>
 value="<?php echo $_smarty_tpl->tpl_vars['ReferenceNumber']->value;?>
"/>
<input type="hidden" <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['formname'][0][0]->GetFormName(array('key'=>'reservation_action'),$_smarty_tpl);?>
 value="<?php echo $_smarty_tpl->tpl_vars['ReservationAction']->value;?>
"/>
<input type="hidden" <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['formname'][0][0]->GetFormName(array('key'=>'SERIES_UPDATE_SCOPE'),$_smarty_tpl);?>
 id="hdnSeriesUpdateScope"
       value="<?php echo SeriesUpdateScope::FullSeries;?>
"/>

<div style="float:left;">
	
	<?php if ($_smarty_tpl->tpl_vars['IsRecurring']->value){?>
		<a href="#" class="delete prompt">
			<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['html_image'][0][0]->PrintImage(array('src'=>"cross-button.png"),$_smarty_tpl);?>

			<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Delete'),$_smarty_tpl);?>

		</a>
	<?php }else{ ?>
		<a href="#" class="delete save">
			<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['html_image'][0][0]->PrintImage(array('src'=>"cross-button.png"),$_smarty_tpl);?>

			<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Delete'),$_smarty_tpl);?>

		</a>
	<?php }?>

	<a style='margin-left:10px;' href="<?php echo $_smarty_tpl->tpl_vars['Path']->value;?>
export/<?php echo Pages::CALENDAR_EXPORT;?>
?<?php echo QueryStringKeys::REFERENCE_NUMBER;?>
=<?php echo $_smarty_tpl->tpl_vars['ReferenceNumber']->value;?>
">
		<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['html_image'][0][0]->PrintImage(array('src'=>"calendar-plus.png"),$_smarty_tpl);?>

		<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'AddToOutlook'),$_smarty_tpl);?>
</a>
	

</div>
<div style="float:right;">

	<?php if ($_smarty_tpl->tpl_vars['IsRecurring']->value){?>
		<button type="button" class="button update prompt">
			<img src="img/tick-circle.png" />
			<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Update'),$_smarty_tpl);?>

		</button>
		<div id="updateButtons" style="display:none;" title="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'ApplyUpdatesTo'),$_smarty_tpl);?>
">
			<div style="text-align: center;line-height:50px;">
				<button type="button" id="btnUpdateThisInstance" class="button save">
					<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['html_image'][0][0]->PrintImage(array('src'=>"disk-black.png"),$_smarty_tpl);?>

					<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'ThisInstance'),$_smarty_tpl);?>

				</button>
				<button type="button" id="btnUpdateAllInstances" class="button save">
					<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['html_image'][0][0]->PrintImage(array('src'=>"disks-black.png"),$_smarty_tpl);?>

					<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'AllInstances'),$_smarty_tpl);?>

				</button>
				<button type="button" id="btnUpdateFutureInstances" class="button save">
					<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['html_image'][0][0]->PrintImage(array('src'=>"disk-arrow.png"),$_smarty_tpl);?>

					<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'FutureInstances'),$_smarty_tpl);?>

				</button>
				<button type="button" class="button">
					<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['html_image'][0][0]->PrintImage(array('src'=>"slash.png"),$_smarty_tpl);?>

					<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Cancel'),$_smarty_tpl);?>

				</button>
			</div>
		</div>
	<?php }else{ ?>
		<button type="button" id="btnCreate" class="button save update">
			<img src="img/disk-black.png" />
			<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Update'),$_smarty_tpl);?>

		</button>
	<?php }?>
	<button type="button" id="btnPrint" class="button">
		<img src="img/printer.png" />
		<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Print'),$_smarty_tpl);?>

	</button>

    <button type="button" class="button" onclick="window.location='<?php echo $_smarty_tpl->tpl_vars['ReturnUrl']->value;?>
'">
	<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['html_image'][0][0]->PrintImage(array('src'=>"slash.png"),$_smarty_tpl);?>

		<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Cancel'),$_smarty_tpl);?>

    </button>
</div>

<?php if ($_smarty_tpl->tpl_vars['UploadsEnabled']->value){?>
	
<div style="clear:both">&nbsp;</div>

	<div id="attachmentDiv" class="res-attachments">
	<span class="heading"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Attachments'),$_smarty_tpl);?>
 (<?php echo count($_smarty_tpl->tpl_vars['Attachments']->value);?>
)</span>
	<?php if (count($_smarty_tpl->tpl_vars['Attachments']->value)>0){?>
		<a href="#" class="remove" id="btnRemoveAttachment">(<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>"Remove"),$_smarty_tpl);?>
)</a><br/>
		<?php  $_smarty_tpl->tpl_vars['attachment'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['attachment']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['Attachments']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['attachment']->key => $_smarty_tpl->tpl_vars['attachment']->value){
$_smarty_tpl->tpl_vars['attachment']->_loop = true;
?>
			<a href="attachments/<?php echo Pages::RESERVATION_FILE;?>
?<?php echo QueryStringKeys::ATTACHMENT_FILE_ID;?>
=<?php echo $_smarty_tpl->tpl_vars['attachment']->value->FileId();?>
&<?php echo QueryStringKeys::REFERENCE_NUMBER;?>
=<?php echo $_smarty_tpl->tpl_vars['ReferenceNumber']->value;?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['attachment']->value->FileName();?>
</a>&nbsp;<input style='display: none;' type="checkbox" name="<?php echo FormKeys::REMOVED_FILE_IDS;?>
[<?php echo $_smarty_tpl->tpl_vars['attachment']->value->FileId();?>
]" />&nbsp;
		<?php } ?>
	</div>
	<?php }?>

<?php }?>
</form>

<div id="dialogAddResources" class="dialog" title="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'AddResources'),$_smarty_tpl);?>
" style="display:none;">

<?php  $_smarty_tpl->tpl_vars['resource'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['resource']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['AvailableResources']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['resource']->key => $_smarty_tpl->tpl_vars['resource']->value){
$_smarty_tpl->tpl_vars['resource']->_loop = true;
?>
	<?php if ($_smarty_tpl->tpl_vars['resource']->value->CanAccess){?>
		<?php $_smarty_tpl->tpl_vars['checked'] = new Smarty_variable('', null, 0);?>
		<?php if (is_array($_smarty_tpl->tpl_vars['AdditionalResourceIds']->value)&&in_array($_smarty_tpl->tpl_vars['resource']->value->Id,$_smarty_tpl->tpl_vars['AdditionalResourceIds']->value)){?>
			<?php $_smarty_tpl->tpl_vars['checked'] = new Smarty_variable('checked="checked"', null, 0);?>
		<?php }?>
		<?php if ($_smarty_tpl->tpl_vars['resource']->value->Id==$_smarty_tpl->tpl_vars['ResourceId']->value){?>
			<?php $_smarty_tpl->tpl_vars['checked'] = new Smarty_variable('checked="checked"', null, 0);?>
		<?php }?>

        <p>
            <input type="checkbox" <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['formname'][0][0]->GetFormName(array('key'=>'ADDITIONAL_RESOURCES','multi'=>true),$_smarty_tpl);?>
 id="additionalResource<?php echo $_smarty_tpl->tpl_vars['resource']->value->Id;?>
"
                   value="<?php echo $_smarty_tpl->tpl_vars['resource']->value->Id;?>
" <?php echo $_smarty_tpl->tpl_vars['checked']->value;?>
 />
            <label for="additionalResource<?php echo $_smarty_tpl->tpl_vars['resource']->value->Id;?>
"><?php echo $_smarty_tpl->tpl_vars['resource']->value->Name;?>
</label>
        </p>
	<?php }?>
<?php } ?>
    <br/>
    <button id="btnConfirmAddResources" class="button"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Done'),$_smarty_tpl);?>
</button>
    <button id="btnClearAddResources" class="button"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Cancel'),$_smarty_tpl);?>
</button>
</div>

<div id="dialogAddAccessories" class="dialog" title="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'AddAccessories'),$_smarty_tpl);?>
" style="display:none;">
    <table width="100%">
        <tr>
            <td><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Accessory'),$_smarty_tpl);?>
</td>
            <td><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'QuantityRequested'),$_smarty_tpl);?>
</td>
            <td><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'QuantityAvailable'),$_smarty_tpl);?>
</td>
        </tr>
	<?php  $_smarty_tpl->tpl_vars['accessory'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['accessory']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['AvailableAccessories']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['accessory']->key => $_smarty_tpl->tpl_vars['accessory']->value){
$_smarty_tpl->tpl_vars['accessory']->_loop = true;
?>
        <tr>
            <td><?php echo $_smarty_tpl->tpl_vars['accessory']->value->Name;?>
</td>
            <td>
                <input type="hidden" class="name" value="<?php echo $_smarty_tpl->tpl_vars['accessory']->value->Name;?>
"/>
                <input type="hidden" class="id" value="<?php echo $_smarty_tpl->tpl_vars['accessory']->value->Id;?>
"/>
				<?php if ($_smarty_tpl->tpl_vars['accessory']->value->QuantityAvailable==1){?>
                    <input type="checkbox" name="accessory<?php echo $_smarty_tpl->tpl_vars['accessory']->value->Id;?>
" value="1" size="3"/>
					<?php }else{ ?>
                    <input type="text" name="accessory<?php echo $_smarty_tpl->tpl_vars['accessory']->value->Id;?>
" value="0" size="3"/>
				<?php }?>
            </td>
            <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['accessory']->value->QuantityAvailable)===null||$tmp==='' ? '&infin;' : $tmp);?>
</td>
        </tr>
	<?php } ?>
    </table>
    <br/>
    <button id="btnConfirmAddAccessories" class="button"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Done'),$_smarty_tpl);?>
</button>
    <button id="btnCancelAddAccessories" class="button"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'Cancel'),$_smarty_tpl);?>
</button>
</div>

<div id="dialogSave" style="display:none;">
    <div id="creatingNotification" style="position:relative; top:170px;">
	
	<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0][0]->SmartyTranslate(array('key'=>'UpdatingReservation'),$_smarty_tpl);?>
...<br/>

	<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['html_image'][0][0]->PrintImage(array('src'=>"reservation_submitting.gif",'alt'=>"Creating reservation"),$_smarty_tpl);?>

    </div>
    <div id="result" style="display:none;"></div>
</div>
<!-- reservationbox ends -->
</div>

<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['control'][0][0]->DisplayControl(array('type'=>"DatePickerSetupControl",'ControlId'=>"BeginDate",'AltId'=>"formattedBeginDate",'DefaultDate'=>$_smarty_tpl->tpl_vars['StartDate']->value),$_smarty_tpl);?>

<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['control'][0][0]->DisplayControl(array('type'=>"DatePickerSetupControl",'ControlId'=>"EndDate",'AltId'=>"formattedEndDate",'DefaultDate'=>$_smarty_tpl->tpl_vars['EndDate']->value),$_smarty_tpl);?>

<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['control'][0][0]->DisplayControl(array('type'=>"DatePickerSetupControl",'ControlId'=>"EndRepeat",'AltId'=>"formattedEndRepeat",'DefaultDate'=>$_smarty_tpl->tpl_vars['RepeatTerminationDate']->value),$_smarty_tpl);?>


<script type="text/javascript" src="scripts/js/jquery.textarea-expander.js"></script>
<script type="text/javascript" src="scripts/js/jquery.qtip.min.js"></script>
<script type="text/javascript" src="scripts/js/jquery.form-3.09.min.js"></script>
<script type="text/javascript" src="scripts/resourcePopup.js"></script>
<script type="text/javascript" src="scripts/date-helper.js"></script>
<script type="text/javascript" src="scripts/recurrence.js"></script>
<script type="text/javascript" src="scripts/reservation.js"></script>
<script type="text/javascript" src="scripts/autocomplete.js"></script>
<script type="text/javascript" src="scripts/force-numeric.js"></script>
<script type="text/javascript" src="scripts/reservation-reminder.js"></script>

<script type="text/javascript">

    $(document).ready(function ()
    {
        var scopeOptions = {
            instance:'<?php echo SeriesUpdateScope::ThisInstance;?>
',
            full:'<?php echo SeriesUpdateScope::FullSeries;?>
',
            future:'<?php echo SeriesUpdateScope::FutureInstances;?>
'
        };

        var reservationOpts = {
            additionalResourceElementId:'<?php echo FormKeys::ADDITIONAL_RESOURCES;?>
',
            accessoryListInputId:'<?php echo FormKeys::ACCESSORY_LIST;?>
[]',
            returnUrl:'<?php echo $_smarty_tpl->tpl_vars['ReturnUrl']->value;?>
',
            scopeOpts:scopeOptions,
            createUrl:'ajax/reservation_save.php',
            updateUrl:'ajax/reservation_update.php',
            deleteUrl:'ajax/reservation_delete.php',
            userAutocompleteUrl:"ajax/autocomplete.php?type=<?php echo AutoCompleteType::User;?>
&onlyActive=true&reservation=true",
            changeUserAutocompleteUrl:"ajax/autocomplete.php?type=<?php echo AutoCompleteType::MyUsers;?>
"
        };

        var recurOpts = {
            repeatType:'<?php echo $_smarty_tpl->tpl_vars['RepeatType']->value;?>
',
            repeatInterval:'<?php echo $_smarty_tpl->tpl_vars['RepeatInterval']->value;?>
',
            repeatMonthlyType:'<?php echo $_smarty_tpl->tpl_vars['RepeatMonthlyType']->value;?>
',
            repeatWeekdays:[<?php  $_smarty_tpl->tpl_vars['day'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['day']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['RepeatWeekdays']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['day']->key => $_smarty_tpl->tpl_vars['day']->value){
$_smarty_tpl->tpl_vars['day']->_loop = true;
?><?php echo $_smarty_tpl->tpl_vars['day']->value;?>
,<?php } ?>]
        };

        var reminderOpts = {
            reminderTimeStart:'<?php echo $_smarty_tpl->tpl_vars['ReminderTimeStart']->value;?>
',
            reminderTimeEnd:'<?php echo $_smarty_tpl->tpl_vars['ReminderTimeEnd']->value;?>
',
            reminderIntervalStart:'<?php echo $_smarty_tpl->tpl_vars['ReminderIntervalStart']->value;?>
',
            reminderIntervalEnd:'<?php echo $_smarty_tpl->tpl_vars['ReminderIntervalEnd']->value;?>
'
        };

        var recurrence = new Recurrence(recurOpts);
        recurrence.init();

        var reservation = new Reservation(reservationOpts);
        reservation.init('<?php echo $_smarty_tpl->tpl_vars['UserId']->value;?>
');

        var reminders = new Reminder(reminderOpts);
        reminders.init();

	<?php  $_smarty_tpl->tpl_vars['user'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['user']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['Participants']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['user']->key => $_smarty_tpl->tpl_vars['user']->value){
$_smarty_tpl->tpl_vars['user']->_loop = true;
?>
        reservation.addParticipant("<?php echo strtr($_smarty_tpl->tpl_vars['user']->value->FullName, array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
", "<?php echo strtr($_smarty_tpl->tpl_vars['user']->value->UserId, array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
");
	<?php } ?>

	<?php  $_smarty_tpl->tpl_vars['user'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['user']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['Invitees']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['user']->key => $_smarty_tpl->tpl_vars['user']->value){
$_smarty_tpl->tpl_vars['user']->_loop = true;
?>
        reservation.addInvitee("<?php echo strtr($_smarty_tpl->tpl_vars['user']->value->FullName, array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
", '<?php echo $_smarty_tpl->tpl_vars['user']->value->UserId;?>
');
	<?php } ?>

	<?php  $_smarty_tpl->tpl_vars['accessory'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['accessory']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['Accessories']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['accessory']->key => $_smarty_tpl->tpl_vars['accessory']->value){
$_smarty_tpl->tpl_vars['accessory']->_loop = true;
?>
        reservation.addAccessory('<?php echo $_smarty_tpl->tpl_vars['accessory']->value->AccessoryId;?>
', '<?php echo $_smarty_tpl->tpl_vars['accessory']->value->QuantityReserved;?>
', "<?php echo strtr($_smarty_tpl->tpl_vars['accessory']->value->Name, array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
");
	<?php } ?>

        var ajaxOptions = {
            target:'#result', // target element(s) to be updated with server response
            beforeSubmit:reservation.preSubmit, // pre-submit callback
            success:reservation.showResponse  // post-submit callback
        };

        $('#reservationForm').submit(function ()
        {
            $(this).ajaxSubmit(ajaxOptions);
            return false;
        });
        $('#description').TextAreaExpander();


    });
    <?php if ($_smarty_tpl->tpl_vars['defCall']->value){?>
    //opponent as only participant
    $(document).ready(function(){
        $('#chooseACall').change();
    });
    <?php }?>
</script>

<?php echo $_smarty_tpl->getSubTemplate ('globalfooter.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?><?php /* Smarty version Smarty-3.1.7, created on 2014-09-05 18:16:33
         compiled from "/home/acetenni/public_html/bookings/lib/Common/../../tpl/globalheader.tpl" */ ?>
<?php if ($_valid && !is_callable('content_5409eff1b4140')) {function content_5409eff1b4140($_smarty_tpl) {?><?php echo '<?xml';?> version="1.0" encoding="<?php echo $_smarty_tpl->tpl_vars['Charset']->value;?>
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