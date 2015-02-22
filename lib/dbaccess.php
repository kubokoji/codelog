<?php
class DBAccess
{

	// データベースOPEN
	public static function connect()
	{
		// MySQLサーバへ接続。パスワードはhogehogeに変えてある。
		$pdo = new PDO("mysql:host=localhost; dbname=codelog", 'hogehoge', 'hogehoge');

		//文字化け対応
		$pdo->query("SET NAMES utf8;");

		return $pdo;
	}

	// データベースCLOSE
	public static function close(PDO &$pdo)
	{
		$pdo = NULL;
	}
}