{*
 *}
{include file='..\..\tpl\Email\emailheader.tpl'}
{$FirstName}, ο παίκτης/παίκτρια {$caller} (<a href="mailto:{$callerEmailAddress}">{$callerEmailAddress}</a>) έχει επιλέξει ο μεταξύ σας αγώνας να διεξαχθεί στις {$date} και ώρα {$time}.
<br/><a href="{$link}">Ace Ranking System</a>
{include file='..\..\tpl\Email\emailfooter.tpl'}