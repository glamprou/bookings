
{function name=displayReservation}
<tr class="reservation" id="{$reservation->ReferenceNumber}">
	<td style="min-width: 250px;">{$reservation->Title|default:$DefaultTitle}</td>
	<td style="min-width:150px;">{fullname first=$reservation->FirstName last=$reservation->LastName} {if !$reservation->IsUserOwner($UserId)}{html_image src="users.png" altKey=Participant}{/if}</td>
	<td width="200px">{formatdate date=$reservation->StartDate->ToTimezone($Timezone) key=dashboard}</td>
	<td width="200px">{formatdate date=$reservation->EndDate->ToTimezone($Timezone) key=dashboard}</td>
	<td style="min-width: 150px; max-width: 250px;">{$reservation->ResourceName}</td>
</tr>
{/function}


<div class="dashboard" id="upcomingReservationsDashboard">
	<div class="dashboardHeader">
		<a href="javascript:void(0);" title="{translate key='ShowHide'}">{translate key="UpcomingReservations"}</a> ({$Total})
	</div>
	<div class="dashboardContents">
		{assign var=colspan value="5"}
		{if $Total > 0}
		<table>
			<tr class="timespan">
				<td colspan="{$colspan}">{translate key="Today"} ({$TodaysReservations|count})</td>
			</tr>
			{foreach from=$TodaysReservations item=reservation}
                {displayReservation reservation=$reservation}
			{/foreach}
			
			<tr class="timespan">
				<td colspan="{$colspan}">{translate key="Tomorrow"} ({$TomorrowsReservations|count})</td>
			</tr>
			{foreach from=$TomorrowsReservations item=reservation}
                {displayReservation reservation=$reservation}
			{/foreach}
			
			<tr class="timespan">
				<td colspan="{$colspan}">{translate key="LaterThisWeek"} ({$ThisWeeksReservations|count})</td>
			</tr>
			{foreach from=$ThisWeeksReservations item=reservation}
                {displayReservation reservation=$reservation}
			{/foreach}
			
			<tr class="timespan">
				<td colspan="{$colspan}">{translate key="NextWeek"} ({$NextWeeksReservations|count})</td>
			</tr>
			{foreach from=$NextWeeksReservations item=reservation}
                {displayReservation reservation=$reservation}
			{/foreach}
		</table>
		{else}
			<div class="noresults">{translate key="NoUpcomingReservations"}</div>
		{/if}
	</div>
</div>