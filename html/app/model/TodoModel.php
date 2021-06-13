<?php
$root = $_SERVER['DOCUMENT_ROOT'];
$root .= '/data/CloudMemo/html';
require_once($root . '/app/model/BaseModel.php');

/**
 * TagModel
 */
class TodoModel extends BaseModel
{
   /**
    * コンストラクタ
    */
   public function __construct()
   {
      // 親クラスのコンストラクタを呼び出す
      parent::__construct();
   }

   // コントローラーでの実装まだ
   /**
    * 新規追加
    * @return array レコードの配列
    */
   public function insert($data)
   {
      //  var_export($data);die;
      // テーブルの構造でデフォルト値が設定されているカラムをinsert文で指定する必要はありません（特に理由がない限り）。
      $sql = '';
      $sql .= 'INSERT into todos (';
      $sql .= ' item_id';
      $sql .= ' ,todo';
      $sql .= ' ,is_checked';
      $sql .= ') values (';
      $sql .= ' :item_id';
      $sql .= ' ,:todo';
      $sql .= ' ,:is_checked';
      $sql .= ')';

      $stmt = $this->dbh->prepare($sql);
      $stmt->bindParam(':item_id', $data['item_id'], PDO::PARAM_INT);
      $stmt->bindParam(':todo', $data['todo'], PDO::PARAM_STR);
      $stmt->bindParam(':is_checked', $data['is_checked'], PDO::PARAM_STR);
      $ret = $stmt->execute();

      return $ret;
   }


   /**
    * 更新
    *
    * @param array $data 更新する作業項目の連想配列
    * @return bool 成功した場合:TRUE、失敗した場合:FALSE
    */
   public function update($data)
   {
      // var_export($data);die;
      // $this->checkId($data['todo_id']);
      $sql = '';
      $sql .= 'UPDATE todos set';
      $sql .= ' deleted_at = CURRENT_TIMESTAMP';
      $sql .= ' WHERE item_id = :item_id';

      $stmt = $this->dbh->prepare($sql);
      $stmt->bindParam(':item_id', $data['item_id'], PDO::PARAM_INT);
      $ret = $stmt->execute();

      return $ret;
   }

   /**
    * 論理削除
    *
    * @param array $data 更新する作業項目の連想配列
    * @return bool 成功した場合:TRUE、失敗した場合:FALSE
    */
   public function soft_delete($data)
   {
      // $this->checkId($data['id']);
      $sql = '';
      $sql .= 'UPDATE todos set';
      $sql .= ' deleted_at = CURRENT_TIMESTAMP';
      $sql .= ' WHERE item_id = :item_id';

      $stmt = $this->dbh->prepare($sql);
      $stmt->bindParam(':item_id', $data['item_id'], PDO::PARAM_INT);
      $ret = $stmt->execute();

      return $ret;
   }

   /**
    * 物理削除
    *
    * @param array $data 更新する作業項目の連想配列
    * @return bool 成功した場合:TRUE、失敗した場合:FALSE
    */
   public function hard_delete($item_id)
   {
      var_export($item_id);
      // die;
      // $this->checkId($data['id']);

      $sql = '';
      $sql .= 'DELETE FROM todos';
      $sql .= ' WHERE item_id = :item_id';

      $stmt = $this->dbh->prepare($sql);
      $stmt->bindParam(':item_id', $item_id, PDO::PARAM_INT);
      $ret = $stmt->execute();

      return $ret;
   }

   /**
    * IDの整合性チェック
    *
    * @return bool boool型
    */
   public function checkId($id)
   {
      // $data['id']が存在しなかったら、falseを返却
      if (!isset($id)) {
         return false;
      }

      // $idが数字でなかったら、falseを返却する。
      if (!is_numeric($id)) {
         return false;
      }

      // $idが0以下はありえないので、falseを返却
      if ($id <= 0) {
         return false;
      }
   }
}
