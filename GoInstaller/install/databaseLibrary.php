<?php
class Database {	
	private $sqlCommand;
	function __construct($sqlCommand = NULL){
		if(!empty($sqlCommand)){
			$this->sqlCommand = $sqlCommand;
		}				
	}
	function create_database($data)
	{
		$mysqli = new mysqli($data['hostname'],$data['username'],$data['password'],'');
		if(mysqli_connect_errno())
			return false;
		$mysqli->query("CREATE DATABASE IF NOT EXISTS ".$data['database']);
		$mysqli->close();
		return true;
	}

	function create_tables($data)
	{
		$mysqli = new mysqli($data['hostname'],$data['username'],$data['password'],$data['database']);
		if(mysqli_connect_errno())
			return false;
		$query = file_get_contents($this->sqlCommand);
		$mysqli->multi_query($query);
		$mysqli->close();
		return true;
	}
	
}
