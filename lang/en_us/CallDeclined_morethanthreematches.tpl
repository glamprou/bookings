{*
 *}
{include file='..\..\tpl\Email\emailheader.tpl'}

{$FirstName},
η πρόσκληση για αγώνα με αντίπαλο τον/την {$caller} (<a href="mailto:{$callerEmailAddress}">{$callerEmailAddress}</a>), έχει ακυρωθεί!(Ο χρήστης έχει {$numofmatchesforfreedecl}  ή περισσότερους αγώνες σε εκκρεμότητα) 
{include file='..\..\tpl\Email\emailfooter.tpl'}