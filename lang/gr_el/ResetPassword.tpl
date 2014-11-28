{*
 *}
{include file='..\..\tpl\Email\emailheader.tpl'}
	
Ο προσωρινός σας κωδικός: {$TemporaryPassword}

<br/>

Ο παλιός κωδικός δεν λειτουργεί πλέον.

Παρακαλώ  <a href="{$ScriptUrl}">Μπείτε στο σύστημα κρατήσεων</a> για να ορίσετε έναν νέο κωδικό το συντομότερο.
	
{include file='..\..\tpl\Email\emailfooter.tpl'}