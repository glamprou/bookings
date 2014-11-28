{*
 *}
{include file='..\..\tpl\Email\emailheader.tpl'}
	
	Λεπτομέριες κράτησης: 
	<br/>
	<br/>
	
	Χρήστης: {$UserName}
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
	<a href="{$ScriptUrl}{$ReservationUrl}">Δείτε την κράτηση</a> | <a href="{$ScriptUrl}">Μπείτε στο σύστημα κρατήσεων</a>

{include file='..\..\tpl\Email\emailfooter.tpl'}