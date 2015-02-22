<?php
class New_Item
{

	public function exec()
	{
		$Item = new Item;

		$flag = $Item->insert_item();
		$context['register_ok_message'] = '新しいアイテムを登録しました。';

		return $context;
	}
}