{*
 *}
{include file='..\..\tpl\Email\emailheader.tpl'}
	Λεπτομέριες κράτησης:
	<br/>
	<br/>
	
	Έναρξη: {formatdate date=$StartDate key=reservation_email}<br/>
	Λήξη: {formatdate date=$EndDate key=reservation_email}<br/>
	Σημείωση: {$Title}<br/>
	
	{if count($RepeatDates) gt 0}
		<br/>
		Επαναλαμβάνεται στις ακόλουθες ημερομηνίες:
		<br/>
	{/if}
	
	{foreach from=$RepeatDates item=date name=dates}
		{formatdate date=$date}<br/>
	{/foreach}

	{if $RequiresApproval}
		<br/>
		Αναμένετε για έγκριση.
	{/if}
	
	<br/>
	Attending? <a href="{$ScriptUrl}/{$AcceptUrl}">Yes</a> <a href="{$ScriptUrl}/{$DeclineUrl}">No</a>
	<br/>

	<a href="{$ScriptUrl}/{$ReservationUrl}">Δείτε την κράτηση</a> |
	<a href="{$ScriptUrl}/{$ICalUrl}">Προσθήκη στο Outlook</a> |
	<a href="{$ScriptUrl}">Μπείτε στο σύστημα κρατήσεων</a>
	
{include file='..\..\tpl\Email\emailfooter.tpl'}