{include file='globalheader.tpl' cssFiles='scripts/css/colorbox.css,css/admin.css,css/jquery.qtip.min.css'}

<h1>{translate key=ManageReservations}</h1>

<fieldset>
	<legend><h3>{translate key=Filter}</h3></legend>
	<table style="display:inline;">
		<tr>
			<td>{translate key=Between}</td>
			<td>{translate key=User}</td>
			<td>{translate key=Schedule}</td>
			<td>{translate key=Resource}</td>
			<td style="display:none;">{translate key=Status}</td>
      <td style="display:none;">{translate key=Payments}</td>
			<td>{translate key=ReferenceNumber}</td>
		</tr>
		<tr>
			<td>
				<input id="startDate" type="text" class="textbox" value="{formatdate date=$StartDate}"/>
				<input id="formattedStartDate" type="hidden" value="{formatdate date=$StartDate key=system}"/>
				-
				<input id="endDate" type="text" class="textbox" value="{formatdate date=$EndDate}"/>
				<input id="formattedEndDate" type="hidden" value="{formatdate date=$EndDate key=system}"/>
			</td>
			<td>
				<input id="userFilter" type="text" class="textbox" value="{$UserNameFilter}" />
				<input id="userId" type="hidden" value="{$UserIdFilter}" />
			</td>
			<td>
				<select id="scheduleId" class="textbox">
					<option value="">{translate key=AllSchedules}</option>
					{object_html_options options=$Schedules key='GetId' label="GetName" selected=$ScheduleId}
				</select>
			</td>
			<td>
				<select id="resourceId" class="textbox">
					<option value="">{translate key=AllResources}</option>
					{object_html_options options=$Resources key='GetId' label="GetName" selected=$ResourceId}
				</select>
			</td>
			<td style="display:none;">
				<select id="statusId" class="textbox">
					<option value="">{translate key=AllReservations}</option>
					<option value="{ReservationStatus::Pending}" {if $ReservationStatusId eq ReservationStatus::Pending}selected="selected"{/if}>{translate key=PendingReservations}</option>
				</select>
			</td>
      <td style="display:none;">
				<select id="payment" name="payment" class="textbox">
					<option value="" {if $payment eq -2}selected="selected"{/if}>{translate key=AllReservations}</option>
          <option value="1" {if $payment eq 1}selected="selected"{/if}>{translate key=UnpaidReservations}</option>
          <option value="0" {if $payment eq 0}selected="selected"{/if}>{translate key=PaidReservations}</option>
          <option value="-1" {if $payment eq -1}selected="selected"{/if}>{translate key=EmptyPaidReservations}</option>
				</select>
			</td>
			<td>
				<input id="referenceNumber" type="text" class="textbox" value="{$ReferenceNumber}" />
			</td>
			<td rowspan="2">
				<button id="filter" class="button">{html_image src="search.png"} {translate key=Filter}</button>
			</td>
		</tr>
	</table>
</fieldset>

<div>&nbsp;</div>

<p>
</p>
<table class="list" id="reservationTable">
	<tr>
		<th class="id">&nbsp;</th>
		<th style="max-width: 120px;">{translate key='User'}</th>
		<th style="max-width: 120px;">{translate key='Resource'}</th>
		<th style="max-width: 120px;">{translate key='Title'}</th>
		<th style="max-width: 120px;">{translate key='Description'}</th>
		<th>{translate key='BeginDate'}</th>
		<th>{translate key='EndDate'}</th>
		<th>{translate key='Duration'}</th>
		<th>{translate key='Created'}</th>
		<th>{translate key='LastModified'}</th>
		<th>{translate key='ReferenceNumber'}</th>
		{foreach from=$AttributeList->GetLabels() item=label}
		<th>{$label}</th>
		{/foreach}
		<th style="display:none;">{translate key='Approve'}</th>
    <th>{translate key='Delete'}</th>
	</tr>
	{foreach from=$reservations item=reservation}
	{cycle values='row0,row1' assign=rowCss}
	{if $reservation->RequiresApproval}
		{assign var=rowCss value='pending'}
	{/if}
	<tr class="{$rowCss} editable">
		<td class="id">{$reservation->ReservationId}</td>
		<td>{$reservation->double_last_name}</td>
		<td>{$reservation->ResourceName}</td>
		<td>{$reservation->Title}</td>
		<td>{$reservation->Description}</td>
		<td>{formatdate date=$reservation->StartDate timezone=$Timezone key=res_popup}</td>
		<td>{formatdate date=$reservation->EndDate timezone=$Timezone key=res_popup}</td>
		<td>{$reservation->GetDuration()->__toString()}</td>
		<td>{formatdate date=$reservation->CreatedDate timezone=$Timezone key=general_datetime}</td>
		<td>{formatdate date=$reservation->ModifiedDate timezone=$Timezone key=general_datetime}</td>
		<td class="referenceNumber">{$reservation->ReferenceNumber}</td>
		{foreach from=$AttributeList->GetValues($reservation->SeriesId) item=value}
		<td>{$value}</td>
		{/foreach}
		<td style="display:none;" align="center">
			{if $reservation->RequiresApproval}
				<a href="#" class="update approve">{html_image src='tick-button.png'}</a>
			{else}
				-
			{/if}
		</td>
    <td align="center"><a href="#" class="update delete">{html_image src='cross-button.png'}</a></td>
	</tr>
	{/foreach}
</table>

{pagination pageInfo=$PageInfo}

<div id="deleteInstanceDialog" class="dialog" style="display:none;" title="{translate key='Delete'}">
	<form id="deleteInstanceForm" method="post">
		<div class="delResResponse"></div>
		<div class="error" style="margin-bottom: 25px;">
			<h3>{translate key=DeleteWarning}</h3>
		</div>
		<button type="button" class="button save">{html_image src="cross-button.png"} {translate key='Delete'}</button>
		<button type="button" class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
		<input type="hidden" {formname key=SERIES_UPDATE_SCOPE} value="{SeriesUpdateScope::ThisInstance}" />
		<input type="hidden" {formname key=REFERENCE_NUMBER} value="" class="referenceNumber" />
	</form>
</div>


<div id="deleteSeriesDialog" class="dialog" style="display:none;" title="{translate key='Delete'}">
	<form id="deleteSeriesForm" method="post">
		<div class="error" style="margin-bottom: 25px;">
			<h3>{translate key=DeleteWarning}</h3>
		</div>
		<button type="button" id="btnUpdateThisInstance" class="button saveSeries">
			{html_image src="disk-black.png"}
			{translate key='ThisInstance'}
		</button>
		<button type="button" id="btnUpdateAllInstances" class="button saveSeries">
			{html_image src="disks-black.png"}
			{translate key='AllInstances'}
		</button>
		<button type="button" id="btnUpdateFutureInstances" class="button saveSeries">
			{html_image src="disk-arrow.png"}
			{translate key='FutureInstances'}
		</button>
		<button type="button" class="button cancel">
			{html_image src="slash.png"}
			{translate key='Cancel'}
		</button>
		<input type="hidden" id="hdnSeriesUpdateScope" {formname key=SERIES_UPDATE_SCOPE} />
		<input type="hidden" {formname key=REFERENCE_NUMBER} value="" class="referenceNumber" />
	</form>
</div>

{html_image src="admin-ajax-indicator.gif" class="indicator" style="display:none;"}

<script type="text/javascript" src="{$Path}scripts/js/jquery.qtip.min.js"></script>
<script type="text/javascript" src="{$Path}scripts/js/jquery.colorbox-min.js"></script>
<script type="text/javascript" src="{$Path}scripts/js/jquery.form-3.09.min.js"></script>

<script type="text/javascript" src="{$Path}scripts/admin/edit.js"></script>
<script type="text/javascript" src="{$Path}scripts/admin/reservations.js"></script>

<script type="text/javascript" src="{$Path}scripts/autocomplete.js"></script>
<script type="text/javascript" src="{$Path}scripts/reservationPopup.js"></script>
<script type="text/javascript" src="{$Path}scripts/approval.js"></script>
<script type="text/javascript">

$(document).ready(function() {

	var updateScope = {};
	updateScope['btnUpdateThisInstance'] = '{SeriesUpdateScope::ThisInstance}';
	updateScope['btnUpdateAllInstances'] = '{SeriesUpdateScope::FullSeries}';
	updateScope['btnUpdateFutureInstances'] = '{SeriesUpdateScope::FutureInstances}';

	var actions = {};
		
	var resOpts = {
		autocompleteUrl: "{$Path}ajax/autocomplete.php?type={AutoCompleteType::User}",
		reservationUrlTemplate: "{$Path}reservation.php?{QueryStringKeys::REFERENCE_NUMBER}=[refnum]",
		popupUrl: "{$Path}ajax/respopup.php",
		updateScope: updateScope,
		actions: actions,
		deleteUrl: '{$Path}ajax/reservation_delete.php?{QueryStringKeys::RESPONSE_TYPE}=json'
	};

	var approvalOpts = {
		url: '{$Path}ajax/reservation_approve.php'
	};
	
	var approval = new Approval(approvalOpts);
		
	var reservationManagement = new ReservationManagement(resOpts, approval);
	reservationManagement.init();

	{foreach from=$reservations item=reservation}

		reservationManagement.addReservation(
			{
				referenceNumber: '{$reservation->ReferenceNumber}',
				isRecurring: '{$reservation->IsRecurring}'
			}
		);
	{/foreach}
});
</script>

{control type="DatePickerSetupControl" ControlId="startDate" AltId="formattedStartDate"}
{control type="DatePickerSetupControl" ControlId="endDate" AltId="formattedEndDate"}

<div id="approveDiv" style="display:none;text-align:center; top:15%;position:relative;">
<h3>{translate key=Approving}...</h3>
{html_image src="reservation_submitting.gif"}
</div>
{include file='globalfooter.tpl'}