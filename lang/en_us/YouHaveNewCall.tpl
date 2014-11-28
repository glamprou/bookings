{*
 *}
{include file='..\..\tpl\Email\emailheader.tpl'}

{$FirstName},
έχετε δεχθεί πρόσκληση για αγώνα από τον/την {$caller} (<a href="mailto:{$callerEmailAddress}">{$callerEmailAddress}</a>). <br />
<a href="{$acceptCallUrl}">Αποδοχή</a> - <a href="{$declineCallUrl}">Απόρριψη</a><br /><br />
Διαφορετικά, μπορείτε να συνδεθείτε στο σύστημα κατάταξης για να αποδεχθείτε ή να απορρίψετε την πρόσκληση.<br /><a href="{$link}">Ace Ranking System</a>
	
{include file='..\..\tpl\Email\emailfooter.tpl'}