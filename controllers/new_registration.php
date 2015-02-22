<?php
class New_Registration
{

	public $id;
	public $password;
	public $city;

	function exec()
	{
		if( (empty($this->id)) || (empty($this->password)) )
		{
			$context['error_message'] = 'メールアドレスとパスワード入力してください。';
			return $context;
		}

		$User = new User();
		$User->id = $this->id;
		$User->password = $this->password;
		$User->city = $this->city;

		$match_number = $User->distinct_check();

		if(intval($match_number) !== 0)
		{
			$context['error_message'] = '同じIDが既に登録されています。<br>違うIDを設定してください。';
			return $context;
		}

		$register_flag = $User->new_register();

		if($register_flag === true)
		{
			$context['success_message'] = '新規登録が完了しました。<br>「ホームまたはログイン画面へ戻る」ボタンを押してください。';
			$_SESSION['id'] = $this->id;
			$_SESSION['city'] = $this->city;
			return $context;
		}
		else
		{
			$context['error_message'] = '新規登録に失敗しました。';
			return $context;
		}
	}

}