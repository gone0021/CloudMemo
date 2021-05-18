<?php
// クラスの読み込み
$root = $_SERVER["DOCUMENT_ROOT"];
$root .= "/data/CloudMemo/html";
require_once($root . "/app/util/SessionUtil.php");
require_once($root . "/app/util/CommonUtil.php");
require_once($root . "/app/model/UserModel.php");

// セッションスタート
SessionUtil::sessionStart();

// サニタイズ
$post = CommonUtil::sanitaize($_POST);
unset($post['token']);
try {
   // ユーザー情報の取得
   $users = new UserModel();
   $user = $users->checkPassEmail($post["email"], $post["password"]);
   if (empty($user)) {
      // --- ユーザーの情報が取得できなかったとき ---
      // エラーメッセージをSESSIONに保存
      $_SESSION["msg"]["error"] = "情報が一致しません";

      // POSTされてきたメールアドレスをSESSIONに保存
      $_SESSION["post"]["email"] = $post["email"];

      // ログインページへリダイレクト
      header("Location: ./");
   } else {
      // --- ユーザー情報が取得できたとき ---
      // ユーザー情報をSESSIONに保存
      $_SESSION["user"] = $user;
      $users->updateUserLastLogin($user['id']);

      // SESSIONに保存されているエラーメッセージをクリア
      $_SESSION["msg"]["error"] = "";
      unset($_SESSION["msg"]["error"]);

      // SESSIONに保存されているPOSTされてきたデータをクリア
      $_SESSION["post"] = "";
      unset($_SESSION["post"]);

      // var_dump($user);
      // die('die 2');
      // itemsページへリダイレクト
      header("Location: ../../items/");
   }
} catch (Exception $e) {
   // echo '<pre>';
   // var_dump($e);exit;
   // echo '</pre>';
   header("Location: ../../error.php");
}
