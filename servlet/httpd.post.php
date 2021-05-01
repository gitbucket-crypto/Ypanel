<?php

require_once  '../controller/user/loginController.php';
require_once  '../controller/user/createController.php';
require_once  '../controller/user/updateController.php';
require_once  '../controller/user/recuperarController.php';
require_once '../controller/session/session.controller.php';
class handlerPOST
{

	 private $data ;

	function __construct__()
	{
			
	}

	public function setData (array $d)
	{
		$this->data = $d;
	}

	public function doHandler(array $postix)
	{
		$origin = strval($_SERVER['HTTP_REFERER']);
		if(strpos($origin,'/ypanel/index.html'))	
		{
		 	$op = $this->data['code'];
		 	switch ($op)
		 	{
		 		case 1000: case '1000':
		 			$login = new loginController();
		 			$login->realizarLogin($this->data);	
		 		break;
		 		case 2000: case '2000':
		 			$user = new createUserController();
		 			$user->cadastrarUsuario($this->data);
		 		break;
		 		case 3000: case '3000':
		 			$recover = new recuperarUsuario();
		 			$recover->recuperarCadastro($this->data);
		 		break;
		 	}
		}
		else if (strpos($origin,'/ypanel/dash-inf/'))
		{
		 	$op = $this->data['code'];
		 	switch($op)
		 	{
		 	  	case 6000:
		 	  		$id = $this->data['session_id'];
		 	  		$session = SessionController::getInstance();
		 	  		echo $session->getSession($id);
		 	  	break; 
		 	  	case 4000:
		 	  		$atualizar = new atualizarUsuarioController();
		 	  		echo $atualizar->updateUsuario($this->data);
		 	  	break;
		 	}	
		}	
		
	}
}


?>