<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/page.php';

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate comment object
$page = new page($db);

$data = json_decode(file_get_contents("php://input"));
$page->serviceID = $data->serviceID;
$result = $page->read_page();

//Get row count
$num = $result->rowCount();

//Check if any comment
if($num > 0){
    //Comment array
    $page_arr = array();
    $page_arr['pages'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $page_item = array(
            'pageID'=>$pageID,
            'serviceID' => $serviceID,
            'metaTag' => $metaTag
        );

        //Push to "data"
        array_push($page_arr['pages'], $page_item);
    }
    //Turn to JSON and output
    echo json_encode($page_arr);
    /* how to get all page ID
    for($i=0;$i<$num;$i++){
    echo json_encode($page_arr['pages'][$i]['pageID']);
    }*/

}else{
//No pages
echo json_encode(
    array('message' => 'No pages Found')
);
}


?>