<?php

final class DB
{
	private static $_conn;
	public static function getConnection()
	{
		if(self::$_conn == null)
		{
			//generate a connect $conn
			$dsn      = "mysql:host=localhost; dbname=sportgear; charset=utf8";
			$username = "root";
			$password = "";

			try
			{
				self::$_conn = new PDO($dsn, $username, $password);
				self::$_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				//set fetch mode, when setting to FETCH_ASSOC, when printing out, may not be good
				//$conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

			}
			catch(PDOException $e)
			{
				echo "Failed to connect database: ".$e->getMessage();
			}
		}
		return self::$_conn;
	}

	public static function disconnect()
	{
		self::$_conn = null;
	}

	private function __construct()
	{

	}
}