<?php
include_once '../../config/Database.php';
include_once '../../models/user.php';

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate user
$user = new User($db);
$data = json_decode(file_get_contents("php://input"));
$user->username=$data->username;
$user->password=$data->password;
 $array=$user->authenticateUser();
if($array["user"])
{
    echo json_encode(["message"=>" user authenticated"]);
    
}
if($array["notFound"])
echo json_encode(["message"=>" the user is not  authenticated"]);
if($array["admin"])
echo json_encode(["message"=>"admin authenticated"]);

?>