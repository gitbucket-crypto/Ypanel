	<?php
require_once '../controller/session/session.controller.php';
require_once '../controller/email/email.controller.php';
require_once '../models/user/database.user.php';
require_once '../config/init_set.php';


class loginController
{
	private $login;


	public function __construct()
	{
		$this->login= new User_Database();
	}


	private function is_loginUserValid(array $data)
    {
	       $err='Por favor preencha ';
	       if(empty(trim($data['LUser'])))
	       {
		          $err.='seu usuario ou e-mail,';
		          $err.=' ';
	        }
	        if(empty(trim($_POST['LPwd'])))
	        {	
	        	if(strpos($err,'seu usuario ou e-mail, ')!==FALSE)	
	        	{
	        		$err.= ' e ';
	        	}	
		        $err.='sua senha';
		        $err.=' ';
	        }
	        if(strpos($err,'Por favor preencha s')!== false)
	         {
		            //$this->_error_(10,$err);
	         	 $this->_error_(10, $err);
	         	  return FALSE;
	         }
	         else return TRUE; 
	         die();
    }

    private function passwordChecK($pass1, $pass2)
    {
	       $val=0;
	      if($pass1==$pass2)
	      {
		        $e1=str_split($pass1);
		        $e2=str_split($pass2);
		        for($i = 0; $i < strlen($pass1); $i++)
		        {
			           if($e1[$i]===$e2[$i])
			           {
				             $val=1;
			           }else $val=0;
		        }
		        if($val===1)
		        {
			           return TRUE;
		        }
		        else return FALSE;
	      }
	      else return FALSE ;
    }

    private function _error_($code,$e)
    {
        switch($code)
        {
            case 10:
                $response = array('id'=>'10','msg'=>$e);
                echo json_encode($response);
            break;
            case 20:
                $response = array('id'=>'20','msg'=>$e);
                echo json_encode($response);
            break;
            default:
                $response = array('id'=>$code,'msg'=>$e);
                echo json_encode($response);
            break;
        }
    }

    private function setsession(array $data)
    {
		$session = SessionController::getInstance();
		$id=$session->setSession($data);
		$_mail = new emailController();
		$_mail->setNome($data['nome']);
		$_mail->setUsername($data['username']);
		$_mail->setEmail($data['email']);
		if($_mail->emailOnLoging())
		{
			$response = array('id'=>20,'msg'=>'Login realizado com sucesso','session'=>$id);
       		 echo json_encode($response);
    	}
    }

	public function realizarLogin(array $data)
	{
		$val;
		if($this->is_loginUserValid($data))
		{
			//SELECT * FROM `tb_usuario` WHERE username ='pedro.hsdeus@hotmail.com' OR email='pedro.hsdeus@hotmail.com' and senha='fast9002'
				
				$this->login->setSenha(base64_encode(strval($data['LPwd'])));
				$this->login->setUsername(strval($data['LUser']));
				$this->login->setEmail(strval($data['LUser']));
				$val = $this->login->loginUser();	
				if(!empty($val) )
				{	
					if($this->passwordChecK(strval($val['senha']),strval($this->login->getSenha())))
					{
						//array_push($skills, "jQuery", "PHP");

						 array_push($val, 'session_valid','TRUE');
						 $this->setsession($val);	
						 //$this->_error_(200,'Login realizado com sucesso');	
					}	
					else $this->_error_(10,'Usuario ou senha informados errados');	
				}
				else if($val===FALSE )
				{
					 $this->_error_(10,'Usuario nao encontrado');	
				}	
		}gc_collect_cycles(); die();
	}	

}


?>