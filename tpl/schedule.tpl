{* All of the slot display formatting *}

{function name=displayGeneralReserved}
	{if $Slot->IsPending()}
		{assign var=class value='pending'}
	{/if}
    {if $Slot->num_of_players eq ''}
          <td {$spantype|default:'col'}span="{$Slot->PeriodSpan()}" class="{if $slot->isGame()}game {/if}reserved {$class} {$OwnershipClass} clickres slot"
          resid="{$Slot->Id()}"
          id="{$Slot->Id()}|{$Slot->Date()->Format('Ymd')}"><div style="position:relative;">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td style="border:0px solid #000000;" valign="middle">{$Slot->Label($SlotLabelFactory)|escapequotes}</td>
          </tr>
        </table>
  </td>
    {else}
          <td {$spantype|default:'col'}span="{$Slot->PeriodSpan()}" class="reserved {$class} {$OwnershipClass} clickres slot"
          resid="{$Slot->Id()}"
          id="{$Slot->Id()}|{$Slot->Date()->Format('Ymd')}"><div style="position:relative;"><div style="margin-right:15px; overflow:hidden;">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td style="border:0px solid #000000;" valign="middle">{$Slot->Label($SlotLabelFactory)|escapequotes}</td>
          </tr>
        </table>
  <div style="position:absolute; top:1px; right:1px;">{$Slot->num_of_players}</div></div></td>
    {/if}
{/function}

{function name=displayMyReserved}
	{call name=displayGeneralReserved Slot=$Slot Href=$Href SlotRef=$SlotRef OwnershipClass='mine'}
{/function}

{function name=displayMyParticipating}
	{call name=displayGeneralReserved Slot=$Slot Href=$Href SlotRef=$SlotRef OwnershipClass='participating'}
{/function}

{function name=displayReserved}
	{call name=displayGeneralReserved Slot=$Slot Href=$Href SlotRef=$SlotRef OwnershipClass=''}
{/function}

{function name=displayOpen}
	{call name=displayGeneralReserved Slot=$Slot Href=$Href SlotRef=$SlotRef OwnershipClass='open'}
{/function}

{function name=displayPaid}
    {call name=displayGeneralReserved Slot=$Slot Href=$Href SlotRef=$SlotRef OwnershipClass='paid'}
{/function}

{function name=displayPastTime}
	<td {$spantype|default:'col'}span="{$Slot->PeriodSpan()}" ref="{$SlotRef}"
		class="pasttime slot">{$Slot->Label($SlotLabelFactory)|escapequotes}</td>
{/function}

{function name=displayReservable}
	<td {$spantype|default:'col'}span="{$Slot->PeriodSpan()}" ref="{$SlotRef}" class="reservable clickres slot {$schedule2_color}" colnum="{$colnum}">
		&nbsp;
		<input type="hidden" class="href" value="{$Href}"/>
		<input type="hidden" class="start" value="{$Slot->BeginDate()->Format('Y-m-d H:i:s')|escape:url}"/>
		<input type="hidden" class="end" value="{$Slot->EndDate()->Format('Y-m-d H:i:s')|escape:url}"/>
        {if $isCallRes}
            <input type="hidden" class="callid" value="{$callid}"/>
        {/if}
	</td>
{/function}

{function name=displayRestricted}
	<td {$spantype|default:'col'}span="{$Slot->PeriodSpan()}" class="restricted slot">&nbsp;</td>
{/function}

{function name=displayUnreservable}
	<td {$spantype|default:'col'}span="{$Slot->PeriodSpan()}"
		class="unreservable slot">{$Slot->Label($SlotLabelFactory)|escape}</td>
{/function}

{function name=displaySlot}
	{call name=$DisplaySlotFactory->GetFunction($Slot, $AccessAllowed, $resource) Slot=$Slot Href=$Href SlotRef=$SlotRef colnum=$colnum}
{/function}

{* End slot display formatting *}

{block name="header"}
	{include file='globalheader.tpl' cssFiles='css/schedule.css,css/jquery.qtip.min.css'}
{/block}

{block name="actions"}
	<div style="display:none;">
		{*translate key=Actions*}
		<a href="#" id="make_default"
		   style="display:none;">{html_image src="star_boxed_full.png" altKey="MakeDefaultSchedule"}</a>
		<a href="#" id="rotate_schedule">{html_image src="arrow-turn.png" altKey="FlipSchedule"}</a>
	</div>
{/block}

<div id="defaultSetMessage" class="success hidden">
	{translate key=DefaultScheduleSet}
</div>

{block name="schedule_control"}
	<div>
		<div class="schedule_title">
			<span>Πρόγραμμα γηπέδων</span>
			{if $Schedules|@count gt 0 and false}
				<ul class="schedule_drop">
					<li id="show_schedule">{html_image src="down_sm_blue.png" alt="Αλλαγή Γηπέδων"}</li>
					<ul style="display:none;" id="schedule_list">
							<li><a href="#"
								   onclick="ChangeSchedule({3}); return false;">Γήπεδα 16:15</a>
							</li>
							<li><a href="#"
								   onclick="ChangeSchedule({4}); return false;">Γήπεδα 16:30</a>
							</li>
                            <li><a href="#"
								   onclick="ChangeSchedule({5}); return false;">Γήπεδα 16:45</a>
							</li>
                    </ul>
				</ul>  
            {/if}
			<a href="#" id="calendar_toggle">{html_image src="calendar.png" altKey="ShowHideNavigation"}</a>
		</div>

		{capture name="date_navigation"}
			<div class="schedule_dates">
				{assign var=FirstDate value=$DisplayDates->GetBegin()}
				{assign var=LastDate value=$DisplayDates->GetEnd()}
				<a href="#" onclick="ChangeDate({formatdate date=$PreviousDate format="Y, m, d"}); return false;"><img
							src="img/arrow_large_left.png" alt="Back"/></a>
				{formatdate date=$FirstDate} - {formatdate date=$LastDate}
				<a href="#" onclick="ChangeDate({formatdate date=$NextDate format="Y, m, d"}); return false;"><img
							src="img/arrow_large_right.png" alt="Forward"/></a>

				{*{if $ShowFullWeekLink}*}
					{*<a href="{add_querystring key=SHOW_FULL_WEEK value=1}"*}
					   {*id="showFullWeek">({translate key=ShowFullWeek})</a>*}
        {*{else}*}
					{*<a href="{add_querystring key=SHOW_FULL_WEEK value=0}" id="showFullWeek">({'Εμφάνισε 3 ημέρες'})</a>*}
        {**}
				{*{/if}*}
			</div>
		{/capture}

		{$smarty.capture.date_navigation}
	</div>
	<div type="text" id="datepicker" style="display:none;"></div>
{/block}
<div style="text-align: center; margin: auto;">
    <div class="legend reservable">{translate key=Reservable}</div>
    <div class="legend pasttime">{translate key=Past}</div>
    <div class="legend reserved">{translate key=Reserved}</div>
    <div class="legend reserved mine">{translate key=MyReservation}</div>
    <div class="legend reserved game">{translate key=Calls}</div>
    <div class="legend restricted">{translate key=Restricted}</div>
</div>
{*{if $show_weather eq 1}
<div id="weatherdiv" style="position:absolute; top:70px; right:20px; font-size:11px;">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  	<tr><td colspan="3" align="right"><div style="color:#FF0000; font-size:11px; font-weight:bold;">{$playable}</div></td></tr>
    <tr><td colspan="3" height="10"></td></tr>
    {$weather}
    </table></div>
{/if}*}
<div style="height:10px">&nbsp;</div>
{block name="reservations"}

{assign var=TodaysDate value=Date::Now()}
<div id="reservations">
    <table cellpadding="0" cellspacing="0" width="100%">
    {assign var=firstScheduleDay value=true}
    {assign var=numOfDays value=count($BoundDates)}
    {assign var=dayCounter value=1}
    {foreach from=$BoundDates item=date}
        {assign var="showDate" value=true}
        <tr>
            <td class="{if $firstScheduleDay}first_schedule_day{assign var=firstScheduleDay value=false}{else}schedule_day{/if}">
                {foreach from=$Schedules item=schedule}
                    {assign var="colnum" value=1}
                        <table class="reservations" cellpadding="0" width="100%">
                            {*Heraklion code*}
                            {assign var="Resources" value=$schedule->getScheduleResources($viewSchedule)}
                            {assign var="ScheduleLayout" value=$schedule->getScheduleLayout()}
                            {assign var="Periods" value=$ScheduleLayout->GetPeriods($date, true)}
                            {if $Resources|@count gt 0}
                                {if $TodaysDate->DateEquals($date) eq true}
                                    <tr class="today periodHolder">
                                        {else}
                                        <tr class="periodHolder">
                                {/if}
                                {if $showDate}
                                    {assign var="showDate" value=false}
                                    <td class="resdate">{formatdate date=$date key="schedule_daily"}</td>
                                {else}
                                    <td class="resdate_empty">&nbsp;</td>
                                {/if}
                                {foreach from=$Periods item=period}
                                    <td class="reslabel" colspan="{$period->Span()}" colnum="{$colnum++}">{$period->Label($date)}</td>
                                {/foreach}
                                </tr>
                                {foreach from=$Resources item=resource name=resource_loop}
                                    {assign var="colnum" value=1}
                                    {assign var=resourceId value=$resource->Id}
                                    {assign var=slots value=$ScheduleLayout->GetLayout($date, $resourceId)}
                                    {assign var=href value="{Pages::RESERVATION}?rid={$resource->Id}&sid={$schedule->GetId()}&rd={formatdate date=$date key=url}"}
                                    <tr class="{if $TodaysDate->DateEquals($date) eq true}today {/if}slots">
                                        <td class="resourcename">
                                            {$resource->Name}
                                        </td>
                                        {foreach from=$slots item=slot}
                                            {assign var=slotRef value="{$slot->BeginDate()->Format('YmdHis')}{$resourceId}"}
                                            {displaySlot Slot=$slot Href="$href" AccessAllowed=$resource->CanAccess SlotRef=$slotRef resource=$resource colnum=$colnum++}
                                        {/foreach}
                                    </tr>
                                {/foreach}
                            {/if}
                        </table>
                    {/foreach}
                {if $dayCounter++ lt $numOfDays}
                    {*<table cellpadding="0" width="100%">*}
                        {*<tr>*}
                            {*<td class="daysSeparator"></td>*}
                        {*</tr>*}
                    {*</table>*}
                {/if}
            </td>
        </tr>
    {/foreach}
    </table>
</div>
<input type="hidden" value="{$ScheduleId}" id="scheduleId"/>
{/block}

{block name="scripts"}
	<script type="text/javascript" src="{$Path}scripts/js/jquery.qtip.min.js"></script>
	<script type="text/javascript" src="{$Path}scripts/schedule.js"></script>
	<script type="text/javascript" src="{$Path}scripts/resourcePopup.js"></script>
	<script type="text/javascript">

		$(document).ready(function ()
		{
			var scheduleOpts = {
				reservationUrlTemplate: "{$Path}{Pages::RESERVATION}?{QueryStringKeys::REFERENCE_NUMBER}=[referenceNumber]",
				summaryPopupUrl: "{$Path}ajax/respopup.php",
				setDefaultScheduleUrl: "{$Path}{Pages::PROFILE}?action=changeDefaultSchedule&{QueryStringKeys::SCHEDULE_ID}=[scheduleId]",
				cookieName: "{$CookieName}",
				cookieValue: "{$CookieValue}"
			};

			var schedule = new Schedule(scheduleOpts);
			schedule.init();
		});
	</script>
{/block}

{control type="DatePickerSetupControl"
ControlId='datepicker'
DefaultDate=$FirstDate
NumberOfMonths='3'
ShowButtonPanel='true'
OnSelect='dpDateChanged'
FirstDay=$FirstWeekday}

{if $IsThereImportantAnnouncement}
<div id="announcements_dialog" title="Basic dialog">
  <div style="font-size:14px;">{$announcement_text}</div>
</div>
<script type="text/javascript">
	document.cookie="read_ann={$announcement_cookie_val}";
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
{/if}

{include file='globalfooter.tpl'}