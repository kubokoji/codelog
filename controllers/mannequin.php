<?php
/*
 --------------------
コントローラーのクラスについて
--------------------
できるだけexec()とexec()で使う関数だけを書くようにしたい。
exec()では$contextをreturnする。
*/
class Mannequin
{

	public function exec()
	{
		$context = array();

		if (isset($_GET['item_type']))
		{
			$_SESSION[$_GET['item_type']]['id'] = isset($_GET['id']) ? $_GET['id'] : '';
			$_SESSION[$_GET['item_type']]['item_id'] = $_GET['item_id'];

			if ($_GET['item_id'] === 'no_item_id')
			{
				unset($_SESSION[$_GET['item_type']]);
			}
		}

		$Item = new Item;
		if (isset($_SESSION['head']))
		{
			$context['head'] = $Item->get_head_imgdat_mime();
		}

		if (isset($_SESSION['tops']))
		{
			$context['tops'] = $Item->get_tops_imgdat_mime();
		}

		if (isset($_SESSION['bottoms']))
		{
			$context['bottoms'] = $Item->get_bottoms_imgdat_mime();
		}

		if (isset($_SESSION['shoes']))
		{
			$context['shoes'] = $Item->get_shoes_imgdat_mime();
		}

		return $context;
	}

}