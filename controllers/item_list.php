<?php
/*
--------------------
コントローラーのクラスについて
--------------------
できるだけexec()とexec()で使う関数だけを書くようにしたい。
exec()では$contextをreturnする。
*/
class Item_List
{
	public $what_part;

	public function exec()
	{
		$Item = new Item;
		$Circumstances = new Circumstances;

		switch ($this->what_part) {
			case 'head_list':
				$context['part'] = '帽子';
				break;
			case 'tops_list':
				$context['part'] = 'トップス';
				break;
			case 'bottoms_list':
				$context['part'] = 'ボトムス';
				break;
			case 'shoes_list':
				$context['part'] = 'シューズ';
				break;
		}

		$context['type'] = str_replace('_list', '', $this->what_part);
		$Item->item_type = $context['type'];
		$context['all_picture_info'] = $Item->get_my_all_item();

		$Circumstances->item_type = str_replace('_list', '', $this->what_part);
		$context['within_three_days'] = $Circumstances->get_within_three_days_item();

		$context['similar_weather'] = $Circumstances->get_similar_weather_item();

		$context['others_picture_info'] = $Item->get_others_item();

		return $context;
	}

}