<?php
class User
{

	public $id;
	public $password;

	//ログインチェック。一致したらSELECT COUNTで'1'が、一致しなかったら'0'がreturnされる。
	public function login()
	{
		$pdo = DBAccess::connect();

		try {
			$sql = "
				SELECT COUNT(id)
				FROM
					user
				WHERE
					id = ?
				AND
					password = ?
			";

			$param_array = array(
				$this->id,
				$this->password
			);

			$stmt = $pdo->prepare($sql);
			$stmt->execute($param_array);
			$row = $stmt->fetch(PDO::FETCH_NUM);
			$match_number = $row[0];

		} catch (Exception $e) {
			return FALSE;
		}

		DBAccess::close($pdo);

		return $match_number;
	}

	//新規登録。userテーブルに新しくレコードを追加する。
	public function new_register()
	{
		$pdo = DBAccess::connect();

		try {

			$sql = "
				INSERT INTO
					user (id, password, city)
				VALUES
					(?, ?, ?)
			";

			$param_array = array(
				$this->id,
				$this->password,
				$this->city
			);

			$stmt = $pdo->prepare($sql);
    		$flag = $stmt->execute($param_array);

		} catch (Exception $e) {
			return FALSE;
		}

		DBAccess::close($pdo);

		return $flag;
	}

	public function get_city()
	{
		$pdo = DBAccess::connect();

		try {

			$sql = "
				SELECT
					city
				FROM
					user
				WHERE
					id = ?
			";

			$param_array = array(
				$_SESSION['id']
			);

			$stmt = $pdo->prepare($sql);
			$stmt->execute($param_array);
			$row = $stmt->fetch(PDO::FETCH_NUM);

		} catch (Exception $e) {
			return FALSE;
		}

		DBAccess::close($pdo);

		return $row[0];
	}

	public function distinct_check()
	{
		$pdo = DBAccess::connect();

		try {

			$sql = "
				SELECT
					COUNT(id)
				FROM
					user
				WHERE
					id = ?
			";

			$param_array = array(
				$this->id
			);

			$stmt = $pdo->prepare($sql);
			$stmt->execute($param_array);
			$row = $stmt->fetch(PDO::FETCH_NUM);

		} catch (Exception $e) {
			return FALSE;
		}

		DBAccess::close($pdo);

		return $row[0];//マッチしたidの数
	}
}