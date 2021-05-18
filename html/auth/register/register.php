<?php
  $root = $_SERVER["DOCUMENT_ROOT"];
  $root .= "/data/CloudMemo/html";
  require_once($root."/app/util/SessionUtil.php");
  require_once($root."/app/util/CommonUtil.php");
  require_once($root."/app/util/ValidationUtil.php");
  require_once($root."/app/model/UserModel.php");

  // セッションスタート
  SessionUtil::sessionStart();

  // サニタイズ
  $post = CommonUtil::sanitaize($_POST);

  // データベースに登録する内容を連想配列にする。
  $data = array (
    'user_name' => $post['name'],
    'email' => $post['email'],
    'birthday' => $post['birthday'],
    'password' => $post['pass2'],
  );

//   var_dump($post); exit;

  try {
    $db = new UserModel();
    $db->insertUser($data);

  } catch (Exception $e) {
    var_dump($e);exit;
    header('Location: ../../error.php');
  }
  // ページタイトル
  $title = '登録完了';
?>

<!DOCTYPE html>
<html lang="jp">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <title> <?= $title ?> </title>
  <link rel="stylesheet" href="../../css/normalize.css">
  <link rel="stylesheet" href="../../css/bootstrap.css">
  <link rel="stylesheet" href="../../css/main.css">
</head>

<body>
<div class="container">
  <!-- body-header -->
  <?php require_once($root."./auth/header.php"); ?>

  <main>
    <table>
      <tr>
        <th>登録が完了しました</th>
      </tr>

      <tr>
        <td>
          <a href="../../">ログイン画面へ</a>
        </td>
      </tr>
    </table>
  </main>

  <footer>
  </footer>
</div>

</body>
</html>