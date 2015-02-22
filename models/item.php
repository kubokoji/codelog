<?php
class Item
{
	public $imgdat;
	public $mime;
	public $item_type;
	public $item_id;

	public function get_my_all_item()
	{
		$pdo = DBAccess::connect();

		try {
			$sql = "
				SELECT
					item_id, item_type, imgdat, mime
				FROM
					item
				WHERE
					item_type = ?
				AND
					id = ?
			";


			$param_array = array(
					$this->item_type,
					$_SESSION['id']
			);

			$stmt = $pdo->prepare($sql);
			$stmt->execute($param_array);

			$row = $stmt->fetchAll(PDO::FETCH_ASSOC);

		} catch (Exception $e) {
			return FALSE;
		}

		DBAccess::close($pdo);

		return $row;
	}

	public function get_others_item()
	{
		$pdo = DBAccess::connect();

		try {
			$sql = "
				SELECT
					*
				FROM
					item
				WHERE
					item_type = ?
				AND
					id != ?
			";


			$param_array = array(
					$this->item_type,
					$_SESSION['id']
			);

			$stmt = $pdo->prepare($sql);
			$stmt->execute($param_array);

			$row = $stmt->fetchAll(PDO::FETCH_ASSOC);

		} catch (Exception $e) {
			return FALSE;
		}

		DBAccess::close($pdo);

		return $row;
	}

	public function insert_item()
	{
		$pdo = DBAccess::connect();

		try {
			$sql = "
				INSERT INTO
					item (id,item_id,item_type)
				VALUE ('b', '011','head')
			";

			$stmt = $pdo->prepare($sql);
			$stmt->execute();

			$row = $stmt->fetchAll(PDO::FETCH_ASSOC);

		} catch (Exception $e) {
			return FALSE;
		}

		DBAccess::close($pdo);

		return $row;
	}

	public function post_image()
	{
		$pdo = DBAccess::connect();

		try {

			$sql = "
				INSERT INTO
					item (id, item_id, item_type, imgdat, mime)
				VALUES (?, ?, ?, ?, ?)
			";

			$param_array = array(
					$_SESSION['id'],
					$this->item_id,
					$this->item_type,
					$this->imgdat,
					$this->mime
			);

			$stmt = $pdo->prepare($sql);
			$flag = $stmt->execute($param_array);

		} catch (Exception $e) {
			return FALSE;
		}

		DBAccess::close($pdo);

		return $flag;
	}

	public function get_max_item_id()
	{
		$pdo = DBAccess::connect();

		try {
			$sql = "
				SELECT
					item_id
				FROM
					item
				WHERE
					id = ?
				ORDER BY
					item_id DESC
				LIMIT
					1
			";


			$param_array = array(
					$_SESSION['id']
			);

			$stmt = $pdo->prepare($sql);
			$stmt->execute($param_array);

			$row = $stmt->fetchAll(PDO::FETCH_ASSOC);

		} catch (Exception $e) {
			return FALSE;
		}

		DBAccess::close($pdo);

		if(empty($row))
		{
			return 0;
		}

		return $row[0]['item_id'];
	}

	public function get_head_imgdat_mime()
	{
		return $this->common_sql_exec('head');
	}

	public function get_tops_imgdat_mime()
	{
		return $this->common_sql_exec('tops');
	}

	public function get_bottoms_imgdat_mime()
	{
		return $this->common_sql_exec('bottoms');
	}

	public function get_shoes_imgdat_mime()
	{
		return $this->common_sql_exec('shoes');
	}

	private function common_sql_exec($type)
	{
		$pdo = DBAccess::connect();

		try {
			$sql = "
				SELECT
					imgdat, mime
				FROM
					item
				WHERE
					id = ?
				AND
					item_id = ?
				AND
					item_type = ?
			";


			$param_array = array(
					$_SESSION[$type]['id'],
					$_SESSION[$type]['item_id'],
					$type
			);

			$stmt = $pdo->prepare($sql);
			$stmt->execute($param_array);

			$row = $stmt->fetchAll(PDO::FETCH_ASSOC);

		} catch (Exception $e) {
			return FALSE;
		}

		DBAccess::close($pdo);

		return $row[0];
	}

}