{*
 *}
{include file='..\..\tpl\Email\emailheader.tpl'}

{$FirstName},
η πρόσκληση για αγώνα με αντίπαλο τον/την {$caller} (<a href="mailto:{$callerEmailAddress}">{$callerEmailAddress}</a>), έχει επικυρωθεί! Μπορείτε να συνδεθείτε στο σύστημα κατάταξης για να επιλέξετε την ημερομηνία διεξαγωγής του αγώνα.<br /><a href="{$link}">Ace Ranking System</a>
	
{include file='..\..\tpl\Email\emailfooter.tpl'}