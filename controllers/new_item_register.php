<?php
class New_Item_Register
{

	public function exec()
	{
		$Item = new Item;

		// バイナリデータ
		$fp = fopen($_FILES["image"]["tmp_name"], "rb");
		$imgdat = fread($fp, filesize($_FILES["image"]["tmp_name"]));
 		base64_decode($imgdat);
		fclose($fp);
// 		$imgdat = addslashes($imgdat);

		// 拡張子
		$dat = pathinfo($_FILES["image"]["name"]);
		$extension = $dat['extension'];

		// MIMEタイプ
		if ( $extension == "jpg" || $extension == "jpeg" ) $mime = "image/jpeg";
		else if( $extension == "gif" ) $mime = "image/gif";
		else if ( $extension == "png" ) $mime = "image/png";

		$Item->imgdat = $imgdat;
		$Item->mime = $mime;
		$Item->item_type = $_POST['select'];
		$get_max_item_id = $Item->get_max_item_id();
		$Item->item_id = $get_max_item_id+1;
		$flag = $Item->post_image();

		if ($flag === true)
		{
			$context['register_message'] = '新しいアイテムを登録しました';
		}
		else
		{
			$context['register_message'] = '新しいアイテムの登録に失敗しました';
		}

		return $context;
	}
}