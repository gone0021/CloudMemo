<?php
$root = $_SERVER['DOCUMENT_ROOT'];
$root .= "/data/CloudMemo/html";
require_once($root . "/app/model/TagModel.php");


/**
 * ItemContorollerクラス
 */
class TagController
{
   /**
    * 全てのアイテムの取得
    */
   public function getUserTag($user_id)
   {
      $dbItem = new TagModel();
      $ret = $dbItem->getUserTag($user_id);

      return $ret;
   }

   public function getitemSearch($user_id, $search) {
      // var_dump($items);
      $dbItem = new itemModel();

      try {
         // 通常の一覧表示か、検索結果かを保存するフラグ
         $isSearch = false;

         // searchに値があればsearchで検索
         if (isset($_GET['search'])) {
            // GETに項目があるときは検索
            $_SESSION['search'] = $_GET['search'];
            $search = $_GET['search'];
            $isSearch = true;
            $items = $dbItem->getTripItemBySearch($search);
         } else if (isset($_SESSION['search'])) {
            // SESSIONに項目がある時はSESSIONの項目で検索
            $search =  $_SESSION['search'];
            $isSearch = true;
            $items = $dbItem->getTripItemBySearch($search);
         } else {
            // GET・SESSIONに項目がないときは項目を全件取得
            $items = $dbItem->getTripItemAll();
         }
      } catch (Exception $e) {
         echo '<pre>';
         var_dump($e);
         echo '</pre>';
         header('Location: ./error.php');
      }


   }
}
