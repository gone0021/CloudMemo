<?php
$root = $_SERVER['DOCUMENT_ROOT'];
$root .= "/data/CloudMemo/html";
require_once($root . "/app/model/itemModel.php");
require_once($root . "/app/model/itemTagModel.php");
require_once($root . "/app/model/TagModel.php");
require_once($root . "/app/model/MemoModel.php");
require_once($root . "/app/model/TodoModel.php");

/**
 * ItemContorollerクラス
 */
class ItemController
{
   /**
    * ユーザーの全てのアイテムの取得
    */
   public function getUserItem($user_id)
   {
      $dbItem = new ItemModel();
      $ret = $dbItem->getUserItem($user_id);

      return $ret;
   }

   /**
    * idに合致するアイテムの取得
    */
   public function getItemById($user_id, $item_id)
   {
      $args = ['memos', 'todos'];
      $dbItem = new ItemModel();
      $ret = $dbItem->getItemById($user_id, $item_id, $args);

      return $ret;
   }

   /**
    * アイテムのタグを取得
    */
   public function getItemTag($item_id)
   {
      $dbItemTag = new ItemTagModel();
      $ret = $dbItemTag->getItemTag($item_id);

      return $ret;
   }

   /**
    * ユーザーの持つタグの取得
    */
   public function getUserTag($user_id)
   {
      $dbItem = new TagModel();
      $ret = $dbItem->getUserTag($user_id);

      return $ret;
   }

   /**
    * memoの登録
    */
   public function storeMemo($req)
   {
      $dbItem = new ItemModel();
      $dbMemo = new MemoModel();

      $maxId = $dbItem->getMaxId();
      $nextId = $maxId['max_id'] + 1;
      // var_export($nextId);die;

      echo 'is memo';
      $toMemo = [];
      $toMemo['item_id'] = $nextId;
      $toMemo['memo'] = $req['memo'];
      // var_export($toMemo);die;
      $dbMemo->insert($toMemo);

      // 使用しない値を削除して代入
      unset($req['memo']);
      $toItem = [];
      $toItem = $req;

      if (!$toItem['sort_no']) {
         $toItem['sort_no'] = null;
      }

      // echo '<pre>';
      // var_export($toItem);
      // echo '</pre>';
      // die;

      $dbItem->insert($toItem);

      return true;
   }


   /**
    * todoの登録
    */
   public function storeTodo($req)
   {
      $dbItem = new ItemModel();
      $dbTodo = new TodoModel();

      $maxId = $dbItem->getMaxId();
      $nextId = $maxId['max_id'] + 1;
      // var_export($nextId);die;

      echo 'is todo';
      $toTodo = [];
      $toTodo['item_id'] = $nextId;
      $toTodo['todo'] = $req['todo'];
      // var_export($toTodo);
      $cnt = count($req['todo']);
      // echo($cnt);die;
      for ($i = 0; $i < $cnt; $i++) {
         // foreach($req['todo_id'] as $k => $v) {
         $toTodo['todo_id'] = $req['todo_id'][$i];
         $toTodo['todo'] = $req['todo'][$i];
         $toTodo['is_checked'] = $req['is_checked'][$i];
         // var_export($toTodo);
         $dbTodo->insert($toTodo);
      }

      // 使用しない値を削除して代入
      unset($req['memo']);
      $toItem = [];
      $toItem = $req;

      if (!$toItem['sort_no']) {
         $toItem['sort_no'] = null;
      }

      // echo '</br> ItemController';
      // echo '<pre>';
      // var_export($toItem);
      // echo '</pre>';
      // die;

      $dbItem->insert($toItem);

      return true;
   }

   /**
    * memoの更新
    */
   public function updateMemo($req)
   {
      $dbItem = new ItemModel();
      $dbMemo = new MemoModel();

      // memo
      $toMemo = [];
      $toMemo['memo_id'] = (int)$req['memo_id'];
      $toMemo['memo'] = $req['memo'];
      // var_export($toMemo);die;
      $dbMemo->update($toMemo);

      // 使用しない値を削除して代入
      unset($req['memo']);
      unset($req['memo_id']);

      // item
      $toItem = [];
      $toItem = $req;

      if (!$toItem['sort_no']) {
         $toItem['sort_no'] = null;
      }
      // var_export($toItem);die;
      $dbItem->update($toItem);

      return true;
   }


   /**
    * todoの更新
    * 既存の値を物理削除してから登録する：todoのみ
    */
   public function updateTodo($req)
   {
      $dbItem = new ItemModel();
      $dbTodo = new TodoModel();

      $dbTodo->hard_delete($req['item_id']);
      echo 'del ok';
      
      echo 'is todo';
      $toTodo = [];
      $toTodo['item_id'] = (int)$req['item_id'];
      $toTodo['todo'] = $req['todo'];
      // var_export($toTodo);
      $cnt = count($req['todo']);
      // echo($cnt);die;

      for ($i = 0; $i < $cnt; $i++) {
         // foreach($req['todo_id'] as $k => $v) {
         $toTodo['todo_id'] = $req['todo_id'][$i];
         $toTodo['todo'] = $req['todo'][$i];
         $toTodo['is_checked'] = $req['is_checked'][$i];
         // var_export($toTodo);
         $dbTodo->insert($toTodo);
      }

      // 使用しない値を削除して代入
      unset($req['todo']);
      unset($req['todo_id']);

      // item：タイトルの更新のみ
      $toItem = [];
      $toItem = $req;

      if (!$toItem['sort_no']) {
         $toItem['sort_no'] = null;
      }
      // var_export($toItem);die;
      $dbItem->update($toItem);

      return true;
   }



   /**
    * reqの削除
    */
   public function destroy($req)
   {
      $dbItem = new ItemModel();
      $dbMemo = new MemoModel();
      $dbTodo = new TodoModel();

      echo '<pre>';
      var_export($req);
      echo '</pre>';
      // die;

      $req['item_id'] = (int)$req['item_id'];

      if ($req['type'] == 'isMemo') {
         echo 'is memo';
         // var_export($toMemo);
         unset($req['type']);
         $dbMemo->soft_delete($req);
      }

      // todoの追加の場合
      // if (array_key_exists('isTodo', $req)) {
      if ($req['type'] == 'isTodo') {
         echo 'is todo';
         unset($req['type']);
         $dbTodo->soft_delete($req);
      }

      $dbItem->soft_delete($req);
   }





   public function getitemSearch($user_id, $search)
   {
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
