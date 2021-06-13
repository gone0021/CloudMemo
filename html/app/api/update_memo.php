<?php
$root = $_SERVER['DOCUMENT_ROOT'];
$root .= "/data/CloudMemo/html";
require_once($root . "/app/controllers/ItemController.php");

// 値を渡す側で処理させるため不使用：サンプルで残している
// $request_body = file_get_contents('php://input'); 
// $data = json_decode($request_body,true);

// echo '<pre>';
// print_r($_POST);
// echo '</pre>';

$crItem = new ItemController();
$crItem->updateMemo($_POST);

exit;
// return 1;


// echo '<br />';
// var_dump($ret);
// return json_encode($ret);

