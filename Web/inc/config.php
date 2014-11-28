<?php 
//current user id

$userSession = ServiceLocator::GetServer()->GetUserSession();
//$userSession->UserId;$userSession->IsAdmin;
$userid=$userSession->UserId;
//$userid=25;
// Database information
$db=ServiceLocator::GetDatabase();
$db->Connection->Connect();

//sto telos kathe selidas pou kanei include afto to arxeio, tha prepei na iparxei i entoli:    $db->Connection->Disconnect();
?>