<?php
class Circumstances
{

	public $item_type;
	public $weather;
	public $date;
	public $unixtime;
	public $item_id;
	public $place;

	/*
	 * 3日以内に使用したアイテム(item_id)を取得する関数
	 */
	public function get_within_three_days_item()
	{
		$pdo = DBAccess::connect();

		try {

			//86400 * 3でなく86400 * 4とした理由は、
			//unixtimeカラムにその日の午前0時の値を格納するようにしているから。
			$sql = "
				SELECT DISTINCT
					item.id AS id, circumstances.item_id AS item_id, item.item_type AS item_type, imgdat, mime
				FROM
					circumstances
				INNER JOIN
					item
				ON
					(item.id = circumstances.id AND item.item_id = circumstances.item_id)
				WHERE
					item.item_type = ?
				AND
					item.id = ?
				AND
					circumstances.unixtime > UNIX_TIMESTAMP(NOW()) - 86400 * 4
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

	/*
	 *過去の同じ天気のときに使用したアイテム(item_id)を取得する関数
	 */
	public function get_similar_weather_item()
	{
		$pdo = DBAccess::connect();

		try {

			$sql = "
				SELECT DISTINCT
					item.id AS id, circumstances.item_id AS item_id, item.item_type AS item_type, imgdat, mime
				FROM
					circumstances
				INNER JOIN
					item
				ON
					(item.id = circumstances.id AND item.item_id = circumstances.item_id)
				WHERE
					item.item_type = ?
				AND
					item.id = ?
				AND
					circumstances.weather = ?
			";


			$param_array = array(
					$this->item_type,
					$_SESSION['id'],
					$_SESSION['weather']
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

	public function register_code()
	{
		$pdo = DBAccess::connect();

		try {

			$sql = "
				INSERT
					circumstances (id, date, unixtime, item_id, place, weather, temperature)
				VALUES
					(?, ?, ?, ?, ?, ?, ?)
			";


			$param_array = array(
					$_SESSION['id'],
					$this->date,
					$this->unixtime,
					$this->item_id,
					$this->place,
					$_SESSION['weather'],
					$_SESSION['temperature']
			);

			$stmt = $pdo->prepare($sql);
			$stmt->execute($param_array);

		} catch (Exception $e) {
			return FALSE;
		}

		DBAccess::close($pdo);
	}

	//過去に同じ場所に行ったときのコーデを取得する関数
	public function get_same_place_code()
	{
		$pdo = DBAccess::connect();

		try {

			$sql = "
				SELECT
					item.id, circumstances.item_id, item.item_type AS item_type, imgdat, mime, date, weather
				FROM
					circumstances
				INNER JOIN
					item
				ON
					(item.id = circumstances.id AND item.item_id = circumstances.item_id)
				WHERE
					item.id = ?
				AND
					circumstances.place = ?
				ORDER BY
					created_sort ASC
			";


			$param_array = array(
					$_SESSION['id'],
					$this->place
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
}