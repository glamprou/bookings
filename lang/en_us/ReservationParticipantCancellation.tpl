{*
 *}
{include file='..\..\tpl\Email\emailheader.tpl'}
	
	Λεπτομέριες κράτησης:
	<br/>
	<br/>
	Έναρξη: {formatdate date=$StartDate key=reservation_email}<br/>
	Λήξη: {formatdate date=$EndDate key=reservation_email}<br/>
	Γήπεδο: {$ResourceName}<br/>
	Σημείωση: {$Title}<br/>
	
	{if count($RepeatDates) gt 0}
		<br/>
		Οι κρατήσεις στις παρακάτω ημερομηνίες ακυρώθηκαν:
		<br/>
	{/if}
	
	{foreach from=$RepeatDates item=date name=dates}
		{formatdate date=$date}<br/>
	{/foreach}

	<a href="{$ScriptUrl}">Μπείτε στο σύστημα κρατήσεων</a>
	
{include file='..\..\tpl\Email\emailfooter.tpl'}