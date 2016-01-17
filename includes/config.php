<?php
/*
+----------------------------+
+ Project Name : iNew Works` File
+ Author : Roldhan Dasalla(@iNew Works Web Solution)
+ Date : November 2016 (c)
+----------------------------+
*/
	define("SITE_NAME","TFVC - Grading System");
	error_reporting(E_ALL ^ E_NOTICE);
	//error_reporting(0);
	session_name('iNew'.SESSION_NAME);
	session_start();
	$iNew = new iNew_dbConnect();

	class iNew_dbConnect {
	  public $db_Host = 'localhost';
	  public $db_User = 'root';
	  public $db_Pass = '';
	  public $db_Name = 'gradingsystems';
	  public $isConnected;
	  public function __construct($options=array()){
	     $this->isConnected = true;
	     try { 
	         $this->dbCon = new PDO("mysql:host=".$this->db_Host.";dbname=".$this->db_Name.";charset=utf8", $this->db_User, $this->db_Pass, $options); 
	         $this->dbCon->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
	         $this->dbCon->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
		   } 
	     catch(PDOException $e) { 
	        $this->isConnected = false;
	         throw new Exception($e->getMessage());
	  	 }
	    }

		public function esc($str){
			return htmlentities($str);
		}
	}
?>