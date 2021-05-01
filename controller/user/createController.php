<?php
require_once '../controller/email/email.controller.php';
require_once '../models/user/database.user.php';
require_once '../config/init_set.php';


class createUserController
{
	private $login;

	function __construct()
	{
		$this->login= new User_Database();
	}

	public function cadastrarUsuario(array $data)
	{	
		if($this->is_addUserValid($data))
		{
			if($this->validMail($data['Cmail']) && $this->passwordChecK($data['Cpwd1'], $data['Cpwd2']))
			{
				
				$this->login->setNome(strval($data['Cname']));
				$this->login->setUsername(strval($data['CUser']));
				$this->login->setEmail(strval($data['Cmail']));
				$this->login->setSenha(base64_encode($data['Cpwd1']));
				$this->login->setData(strval(date('Y-m-d H:i:s')));
				if($this->login->createUser())
				{
					$this->_error_(20,'Usuario cadastrado com sucesso');
				}
				else $this->_error_(10,'Usuario ou e-mail ja cadastrados');
				die();	
			}	
		}
	}

	function is_addUserValid(array $data)
    {
    	$e = strlen('Por favor preencha');
		$err='Por favor preencha';
		if(empty(trim($data['Cname'])))
		{
				$err.=' seu nome, ';	
		}
		if(empty(trim($data['CUser'])))
		{
			if(strpos($err,'Por favor preencha seu nome,')!==FALSE)
			{
				$err .= ' seu usuario, ';
			}	
			else $err.= ' o seu usuario';	
		}
		if(empty(trim($data['Cmail'])))
		{
			if(strpos($err,'Por favor preencha seu nome, seu usuario, ')!==FALSE)
			{
				$err.= ' seu e-mail,';
			}
			else $err.= ' seu e-mail';	
		}
		if(empty(trim($data['Cpwd1'])))
		{
			if(strpos($err,'Por favor preencha s')!==FALSE)
			{
					$err.= ', sua senha';
			}
			else $err.= ' sua senha';	
		}
		if(empty(trim($data['Cpwd2'])))
		{
			if(strpos($err,'Por favor preencha s')!==FALSE)
			{
					$err.= ' e a confirmacao de senha';
			}
			else $err.= ' a confirmacao de senha';
			//$this->_error_(10,strpos($err,'Por favor preencha s')!==FALSE);	
		}
		if(strlen($err)>$e ===TRUE)
		{
			$this->_error_(10,$err);
			return FALSE;
		}
		else return TRUE;
		die();
	}

	function validMail($email)
    {
         $email = filter_var($email, FILTER_SANITIZE_EMAIL);
         if (filter_var($email, FILTER_VALIDATE_EMAIL))
         {
              if(!preg_match("/^([[:alnum:]_.-]){3,}@([[:lower:][:digit:]_.-]{3,})(.[[:lower:]]{2,3})(.[[:lower:]]{2})?$/", trim($email)))
              {
                  $this->_error_(10,'O Email dever ser valido.');
                  return FALSE;
               }
               else return TRUE;
         }
         else $this->_error_(10,'O Email dever ser valido.'); return FALSE;
    }

    function passwordChecK($pass1, $pass2)
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
		        else $this->_error_(10,'As senhas não coincidem');return FALSE;
	      }
	      else $this->_error_(10,'As senhas não são igauis') ;return FALSE ;
    }

    function _error_($code,$e)
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


}

?>