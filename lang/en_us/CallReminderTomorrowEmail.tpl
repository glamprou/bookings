{*
 *}
{include file='..\..\tpl\Email\emailheader.tpl'}

{$FirstName},
εκκρεμεί απάντηση σας στην πρόσκληση για αγώνα με αντίπαλο τον/την {$caller} (<a href="mailto:{$callerEmailAddress}">{$callerEmailAddress}</a>) η οποία λήγει <b>αύριο</b>! Σε περίπτωση πού δεν απαντήσετε έγκαιρα θα σας επιβληθεί ποινή! Μπορείτε να συνδεθείτε στο σύστημα κατάταξης για να απαντήσετε στην πρόσκληση.<br /><a href="{$link}">Ace Ranking System</a>
	
{include file='..\..\tpl\Email\emailfooter.tpl'}