<?php
class All_Type
{
	public $what_part;

	public function exec()
	{
		$Item = new Item;

		$Item->item_type = str_replace('all_', '', $this->what_part);
		$context['my_picture_info'] = $Item->get_my_all_item();

		return $context;
	}

}