<?php
na ginei me page kanonika k oxi etsi xyma
header('Content-type: application/json');
$action=$_POST['action'];
$response=array();
if(!is_string($action) || ($action!=="remove" && $action!=="block" && $action!=="unblock" && $action!=="injure" && $action!=="uninjure")){
    $response['code']=200;
}
echo json_encode($response);
exit;