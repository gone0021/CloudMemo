<?php
/**
 * 基本となるモデル
 */

 class BaseModel {
  /** @var string データベース接続ユーザー名 */
  protected const DB_USER = "root";

  /** @var string データベース接続パスワード */
  protected const DB_PASS = "";

  /** @var string データベースホスト名 */
  protected const DB_HOST = "localhost";

  /** @var string データベース名 */
  protected const DB_NAME = "cloud_memo";

  /** @var object PDOインスタンス */
  protected $dbh;

  /**
   * コンストラクタ
   */
  public function __construct() {
    try {
      // DBへ接続
      $dsn = "mysql:dbname=".self::DB_NAME.";host=".self::DB_HOST."; charset=utf8";
      $this->dbh = new PDO($dsn, self::DB_USER, self::DB_PASS);

      //DB接続における例外発生時にPDOExceptionが投げられる
      $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (Exception $e) {
      var_dump($e);
      exit;
    }

    // PDO::__construct()は指定したデータベースへの接続が失敗した場合にPDOExceptionがthrowされる
    // 参考：https://www.php.net/manual/ja/pdo.construct.php
  }

  /**
   * トランザクションを開始
   */
  public function begin() {
    $this->dbh->beginTransaction();
  }

  /**
   * トランザクションをコミット
   */
  public function commit() {
    $this->dbh->commit();
  }

  /**
   * トランザクションをロールバック
   */
  public function rollback() {
    $this->dbh->rollback();
  }
}