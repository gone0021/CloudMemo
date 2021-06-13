<?php
$root = $_SERVER['DOCUMENT_ROOT'];
$root .= '/data/CloudMemo/html';
require_once($root . '/app/model/BaseModel.php');

/**
 * itemTagModel
 */
class ItemTagModel extends BaseModel
{
   /**
    * コンストラクタ
    */
   public function __construct()
   {
      // 親クラスのコンストラクタを呼び出す
      parent::__construct();
   }

   /**
    * item_idからtagを取得するselect文
    * @return string レコードを取得するselect文
    */
   public function selectItemTag()
   {
      $sql = '';
      $sql .= 'SELECT';
      $sql .= ' it.item_id';
      $sql .= ' ,it.tag_id';
      $sql .= ' ,t.tag_name';
      $sql .= ' FROM item_tag as it';
      $sql .= ' JOIN tags as t ON it.tag_id = t.id';

      return $sql;
   }

   /**
    * 対象itemのtagを取得
    * @return array レコードの配列
    */
   public function getItemTag($item_id)
   {
      $ret = "";
      // 登録済みのカラムをセレクトで取得
      $sql = $this->selectItemTag();
      $sql .= ' WHERE t.deleted_at IS NULL ';
      $sql .= ' and it.item_id = :item_id ';
      $sql .= ' order by it.item_id';

      $stmt = $this->dbh->prepare($sql);
      $stmt->bindParam(':item_id', $item_id, PDO::PARAM_STR);
      $stmt->execute();
      $ret = $stmt->fetchAll(PDO::FETCH_ASSOC);

      // echo '<pre>';
      // print_r($ret);die;
      // echo '</pre>';

      return $ret;
   }
}
