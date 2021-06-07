<?php
$root = $_SERVER['DOCUMENT_ROOT'];
$root .= "/data/CloudMemo/html";
require_once($root . "/app/controllers/ItemController.php");

// var_dump($_GET);
$user_id = $_GET['user_id'];

$crItem = new ItemController();
$ret = $crItem->getUserTag($user_id);
$json = json_encode($ret);

echo $json;
return;


// echo '<br />';
// var_dump($ret);
// return json_encode($ret);

