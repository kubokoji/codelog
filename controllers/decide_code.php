<?php
class Decide_Code
{
	public function exec()
	{
		if (!isset($_SESSION['tops']) || !isset($_SESSION['bottoms']) || !isset($_SESSION['shoes']))
		{
			$context['error_message'] = '少なくともトップス、ボトムス、シューズは全て選択してください。';
			return $context;
		}

		//画像名の_001.pngより前の部分がログイン中のidと一致しているか確認する。
		if (isset($_SESSION['head']) && ($_SESSION['head']['id'] !== $_SESSION['id']))
		{
			$context['error_message'] = '他ユーザーのアイテムは登録できません。';
			return $context;
		}

		if (
				($_SESSION['tops']['id'] !== $_SESSION['id'])
				||
				($_SESSION['bottoms']['id'] !== $_SESSION['id'])
				||
				($_SESSION['shoes']['id'] !== $_SESSION['id'])
			)
		{
			$context['error_message'] = '他ユーザーのアイテムは登録できません。';
			return $context;
		}


		date_default_timezone_set('Asia/Tokyo');//東京の時刻にする。
		$date = date("Y-m-d");
		$unixtime = strtotime($date);

		$Circumstances = new Circumstances;

		$Circumstances->date = $date;
		$Circumstances->unixtime = $unixtime;
		$Circumstances->place = $_GET['place'];

		if (isset($_SESSION['head']))
		{
			$Circumstances->item_id = $_SESSION['head']['item_id'];
			$Circumstances->register_code();
		}

		$Circumstances->item_id = $_SESSION['tops']['item_id'];
		$Circumstances->register_code();

		$Circumstances->item_id = $_SESSION['bottoms']['item_id'];
		$Circumstances->register_code();

		$Circumstances->item_id = $_SESSION['shoes']['item_id'];
		$Circumstances->register_code();

		$context['message'] = 'コーデを登録しました。';
		return $context;

	}
}