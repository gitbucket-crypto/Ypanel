<?php

require_once '../config/init_set.php';
require_once '../models/session/database.session.php';
class SessionController
{
	function __construct()
	{

	}

	function setSession(array $data)
	{
		$id = rand(100,1000);
		session_start();
		$_SESSION['username'] = $data['username'];
		$_SESSION['nome']= $data['nome'];
		$_SESSION['email']=$data['email'];
		$_SESSION['data']= strval(date("d/m/Y"));
		$_SESSION['time']= strval(date("H:i"));
		$_SESSION['active']= 'true';	

		$cookie_mail='user';
		$cookie_username=$data['nome'];
		$cookie_uid=$id;
		$_COOKIE['$cookie_name']=$data['nome'];

		$uid= session_id();
		//echo ($uid.$id);
		setcookie($cookie_mail, $cookie_username, time() + (86400 * 60),'/');
		$sesdata  = 'username:'.$data['username'].',';
		$sesdata .= 'nome:'.$data['nome'].',';
		$sesdata .= 'email:'.$data['email'].',';
		$sesdata .= 'senha:'.strval(base64_encode($data['senha'])).',';
		$sesdata .= 'data:'.strval(date("d/m/Y")).',';
		$sesdata .= 'hora:'.strval(date("H:i")).',';
		$sesdata .= 'uid:'.$uid.'';	
		$nuid=$uid.$id;
    	$session = new Session_Database();
    	//$sesdata= json_encode($sesdata);
    	$session->write($nuid,$sesdata,$data['username']);
    	return $nuid;
	}

	function getSession($id)
	{
		if(!empty($id))
		{
			$session = new Session_Database();
			$data=$session->read($id);
			//$data = array_values($data);
			//$arrayString = print_r($data, true);
			//$arrayString = array_values($arrayString);
			//$data = array_values($data);
		
			if(empty($data))
			{
			 	$response = array('http'=>'404','data'=>'Usuario nao logado no sistema');
                echo json_encode($response);
			}
			else 
			{
				/**
				username:chronos,nome:Pedro Henrique,email:pedro.hsdeus@hotmail.com,senha:ZmFzdDkwMDI=,data:25/04	/2021,hora:19:03,uid:e27fd9d043ec817b2f10ae59ad81b315"
				**/
				
				$username = $this->get_string_between($data,'username:',',nome:');
				$nome =$this->get_string_between($data,',nome:',',email:');
				$email =$this->get_string_between($data,',email:',',senha:');
				$senha =$this->get_string_between($data,',senha:',',data:');
				$data =$this->get_string_between($data,',data:',',hora:');
				$hora =$this->get_string_between($data,',hora:',',uid:');
			
				$session= array(
					  'username'=>$username,
					  'nome'=>$nome,
					  'email'=>$email,
					  'senha'=>($senha),
					  'data'=> $data,
					  'hora'=>$hora);
				
				$response = array('http'=>'200','data'=>$session);
            	echo json_encode($response);
			}	
		}else 
		{
			$response = array('http'=>'404','data'=>'Usuario nao logado no sistema');
            echo json_encode($response);
		}	
		gc_collect_cycles(); die();	
	}

	function get_string_between( $string, $start, $end)
	{
  			$string = " " . $string; // Convert to string.
			$ini = strpos( $string, $start ); // Position of start text.
			if ($ini == 0) 
			{
    			return "";
  			}
			$ini += strlen( $start ); // Length of start text.  
			$len = strpos( $string, $end, $ini) - $ini; // Position of end text.
			return substr( $string, $ini, $len); // String betwen start and end.
	}

	function writeSession($id, $data, $username)
	{
		$session = new Session_Database();
		return	$session->update($id,$data,$username);
	}

	function dropSession($id, $username)
	{

	}


	private static $_instance;

	public static function getInstance()
    {
        if(!self::$_instance)
        {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
}

?>