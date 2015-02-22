<?php
class Login
{

	public $id;
	public $password;

	function exec()
	{
		if( (empty($this->id)) || (empty($this->password)) )
		{
			$context['error_message'] = 'IDとパスワードを入力してください。';
			return $context;
		}

		$User = new User();
		$User->id = $this->id;
		$User->password = $this->password;
		$match_number = $User->login();

		if($match_number === '0')
		{
			$context['error_message'] = 'IDまたはパスワードが正しくありません。';
			return $context;
		}
		else if($match_number === '1')
		{
			$_SESSION['id'] = $this->id;
			$_SESSION['city'] = $User->get_city();

			//ログインに成功したときに天気と温度を取得しておく。
			$this->get_weather_temperature();

			header("Location: ?act=home");
			exit();
		}
		else
		{
			$context['error_message'] = '複数のアカウントが登録されています。';
			return $context;
		}
	}

	//天気と気温をセッション変数に格納する関数
	function get_weather_temperature()
	{
		//apiを使って天気と気温を取得する
		$weatherDatas_json = file_get_contents('http://api.openweathermap.org/data/2.5/find?q=' . $_SESSION['city']);
		//Json形式のデータを配列変数に変換
		$weatherDatas = json_decode($weatherDatas_json, true);

		$_SESSION['temperature'] = round($weatherDatas['list'][0]['main']['temp'] - 273.15);
		//Clear,Clouds,Rain,Mist,Drizzleは少なくともある。
		//MistとDrizzleはRainに変換することにより、Clear,Clouds,Rainの3種類にする。
		if ($weatherDatas['list'][0]['weather'][0]['main'] === "Mist" || $weatherDatas['list'][0]['weather'][0]['main'] === "Drizzle")
		{
			$_SESSION['weather'] = "Rain";
		}
		else
		{
			$_SESSION['weather'] = $weatherDatas['list'][0]['weather'][0]['main'];
		}

		switch($_SESSION['weather'])
		{
			case 'Clear':
				$_SESSION['weather_in_japanese'] = '晴れ';
				break;

			case 'Clouds':
				$_SESSION['weather_in_japanese'] = '曇り';
				break;

			case 'Rain':
				$_SESSION['weather_in_japanese'] = '雨';
				break;
		}
	}

}