<?php
//これで正しいパスになるのか怪しいが、BASE_URLという定数を定義して使いまわす。
define("DOCUMENT_ROOT",$_SERVER["DOCUMENT_ROOT"]);
define("REMOTE_ADDR",$_SERVER["REMOTE_ADDR"]);
session_start();

//ファイルを一気に読み込む。
foreach(glob(DOCUMENT_ROOT."/lib/*.php") as $file){ require_once $file; }
foreach(glob(DOCUMENT_ROOT."/models/*.php") as $file){ require_once $file; }
foreach(glob(DOCUMENT_ROOT."/controllers/*.php") as $file){ require_once $file; }
//foreach(glob(DOCUMENT_ROOT."/css/*.css") as $file){ require_once $file; }//cssのファイルはここで読み込むのがいいのか分からない。

//$actにゲットパラメータを代入する。
$act = isset($_GET['act']) ? $_GET['act'] : 'login';

//$actの値で場合分けをする。
//処理は基本的にそれぞれのexec()で行う。
//基本的にはページの分だけここの分岐が増えることになる。
switch($act)
{
	//getパラメータが指定されていなかったときには、この分岐に入る。
	case 'login':
		$html = DOCUMENT_ROOT . '/templates/login.html';
		$context = null;
		break;

	// ログインチェック
	case 'login_check':
		$html = DOCUMENT_ROOT . '/templates/login.html';
		$Login = new Login();
		$Login->id = trim($_POST['id']);
		$Login->password = trim($_POST['password']);
		$context = $Login->exec();
		break;

	//ログイン画面から新規登録ボタンが押されたとき。
	case 'new_registration':
		$html = DOCUMENT_ROOT . '/templates/new_registration.html';
		$context = null;
		break;

	//新規登録ボタンが押されたときに、メールアドレスとパスワードがちゃんと入力されているかの確認。
	case 'new_registration_check':
		$html = DOCUMENT_ROOT . '/templates/new_registration.html';
		$New_Registration = new New_Registration();
		$New_Registration->id = trim($_POST['id']);
		$New_Registration->password = trim($_POST['password']);
		$New_Registration->city = $_POST['city'];
		$context = $New_Registration->exec();
		break;

	//ホーム画面
	case 'home':
		$html = DOCUMENT_ROOT . '/templates/home.html';
		$Home = new Home();
		$context = $Home->exec();
		break;

	//それぞれのパーツごとに一覧表示するページについて。
	case 'head_list': case 'tops_list': case 'bottoms_list': case 'shoes_list':
		$html = DOCUMENT_ROOT . '/templates/item_list.html';
		$Item_List = new Item_List();
		$Item_List->what_part = $act;
		$context = $Item_List->exec();
		break;

	//選択した場所に過去に行ったときのコーデについて。
	case 'same_place_code':
		$html = DOCUMENT_ROOT . '/templates/same_place_code.html';
		$Same_Place_Code = new Same_Place_Code();
		$context = $Same_Place_Code->exec();
		break;

	//マネキンのページについて。
	case 'mannequin':
		$html = DOCUMENT_ROOT . '/templates/mannequin.html';
 		$Mannequin = new Mannequin();
 		$context = $Mannequin->exec();
		break;

	//コーデ決定ボタンが押されたとき。
	case 'decide_code':
		$html = DOCUMENT_ROOT . '/templates/decide_code.html';
		$Decide_Code = new Decide_Code();
		$context = $Decide_Code->exec();
		break;

	//帽子、トップス、ボトムス、シューズの画像一覧を表示するための処理
	case 'all_head': case 'all_tops': case 'all_bottoms': case 'all_shoes':
		$html = DOCUMENT_ROOT . '/templates/all_type.html';
		$All_Type = new All_Type();
		$All_Type->what_part = $act;
		$context = $All_Type->exec();
		break;

	//新アイテムを追加する処理
	case 'new_item_register':
		$html = DOCUMENT_ROOT . '/templates/new_item.html';
		$New_Item_Register = new New_Item_Register;
		$context = $New_Item_Register->exec();
		break;

	//新アイテム追加画面に飛ぶ
	case 'new_item':
		$html = DOCUMENT_ROOT . '/templates/new_item.html';
		$context = null;
		break;

	// ログアウト
	case 'logout':
		//セッションを破棄
		$_SESSION = array();
		session_destroy();
		//header('Status: 301 Moved Permanently');
		header("Location:?");
		exit();

	default:
		html_view('', '', '存在しないページです。');
		exit;

}

//最後にページとして表示するための関数を呼び出す。
html_view($html, $context);

function html_view($html = '', $context = array(), $not_exist_message = '')
{
	//$context配列に入っていた要素をばらす。
	//例えば、$context['part']は$partになる。
	if($context)
	{
		extract($context);
	}

	//URLを読み込んで表示する。
	if($html)
	{
		//include(DOCUMENT_ROOT . '/templates/header.html');
		include($html);
		//include(DOCUMENT_ROOT . '/templates/footer.html');
	}

	//デフォルトでは$messageはない。
	if($not_exist_message)
	{
		echo $not_exist_message;
	}
}
?>
