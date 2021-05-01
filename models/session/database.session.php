<?php
require_once '../config/init_set.php';

class Session_Database 
{
	/***
	CREATE TABLE datatest.tb_session ( 
    session_id CHAR(62) NOT NULL, 
    session_data LONGTEXT NOT NULL, 
    session_lastaccesstime TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, 
    is_valid TINYINT(1) DEFAULT 1,
    session_user varchar(80) NOT NULL,
    PRIMARY KEY (session_id)
);

	**/
	private $db;

	public function __construct()
	{

	}


	function open($path, $name) 
	{
    	$db = new PDO("mysql:host=".BD_SERVIDOR.";dbname=".BD_BANCO, BD_USUARIO, BD_SENHA);
    	$sql = "INSERT INTO tb_session SET session_id =" . $db->quote($sessionId) . ", session_data = '' ON DUPLICATE KEY UPDATE session_lastaccesstime = NOW()";
    	$db->query($sql);    
	}

	function read($sessionId) 
	{ 
    	$db = new PDO("mysql:host=".BD_SERVIDOR.";dbname=".BD_BANCO, BD_USUARIO, BD_SENHA);

    	$sql = "SELECT session_data FROM tb_session where session_id =" . $db->quote($sessionId). 'AND is_valid=1';
    	//$result = $db->query($sql);
    	//$data = $result->fetchAll(PDO::FETCH_ASSOC);
    	//$result->closeCursor();
    	$statement = $db->prepare($sql);
		$statement->execute();
		$resultSet=$statement->fetchAll(PDO::FETCH_ASSOC);
		$statement->closeCursor();
		if(sizeof($resultSet)>0 )
		{
			$rs = $resultSet[0];
			return  $rs['session_data'];
		}		
		
		return  FALSE;
		
	}

	function write($sessionId, $data,$username) 
	{ 
    	$db = new PDO("mysql:host=".BD_SERVIDOR.";dbname=".BD_BANCO, BD_USUARIO, BD_SENHA);

    	$sql = "INSERT INTO tb_session SET session_id =" . $db->quote($sessionId) . ", session_data =" . $db->quote($data) .', is_valid=1, session_user='.$db->quote($username). " ON DUPLICATE KEY UPDATE session_data =" . $db->quote($data);
   		 $db->query($sql);
	}

	function destroy($sessionId) 
	{
    	$db = new PDO("mysql:host=".BD_SERVIDOR.";dbname=".BD_BANCO, BD_USUARIO, BD_SENHA);

    	$sql = "DELETE FROM tb_session WHERE session_id =" . $db->quote($sessionId); 
    	$db->query($sql);
    	setcookie(session_name(), "", time() - 3600);
	}

	function gc($lifetime) 
	{
    	$db = new PDO("mysql:host=".BD_SERVIDOR.";dbname=".BD_BANCO, BD_USUARIO, BD_SENHA);

    	$sql = "DELETE FROM tb_session WHERE session_lastaccesstime < DATE_SUB(NOW(), INTERVAL " . $lifetime . " SECOND)";
    	$db->query($sql);
	}

	function update($sessionId, $data,$username) 
	{
		$db = new PDO("mysql:host=".BD_SERVIDOR.";dbname=".BD_BANCO, BD_USUARIO, BD_SENHA);
		$sql= 'UPDATE tb_session SET session_data='.$db->quote($data).", session_user=".$db->quote($username)." WHERE session_id=".$db->quote($sessionId);
		//echo $sql;
		$db->query($sql);

	}

}


?>