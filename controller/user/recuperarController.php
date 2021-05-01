<?php
require_once '../controller/email/email.controller.php';
require_once '../models/user/database.user.php';
require_once '../config/init_set.php';

class recuperarUsuario
{
	private $db;

	function __construct()
	{
		$this->db = new User_Database(); 
	}


	public function recuperarCadastro(array $data)
	{
		if($this->is_recoveryUserValid($data))
		{
			if($this->validMail($data['Rmail']))
			{
				$this->db->setUsername(strval($data['Ruser']));
				$this->db->setEmail(strval($data['Rmail']));
				$row =$this->db->recoverUserData();
				if($row!==FALSE)
				{
					$email = new emailController();
					$email->setUsername( $row['username']);
					$email->setEmail($row['email']);
					$email->setNome($row['nome']);
					$email->setPassword(base64_decode($row['senha']));
					$b = $email->emailRecoverUser();
					if($b===TRUE)
					{
						$this->_error_(20,'Dados de acesso enviado no email cadastrado');	
					}	
				}
				else if($row===FALSE )
				{
					 $this->_error_(10,'Usuario nao encontrado');	
				}	
			}	
		}gc_collect_cycles(); die();	
	}

	private function is_recoveryUserValid(array $data)
    {
    	$e = strlen('Por favor preencha,');
        $err='Por favor preencha,';
        if(empty(trim($data['Rmail'])))
        {
            $err.= ' seu email';
        }
        if(empty(trim($data['Ruser'])))
        {
        	if(strpos($err,'Por favor preencha, seu email')===TRUE)
        	{
        		$err .= ' e sua senha';
        	}
        	else $err.= ' sua senha';
        }
        if(strlen($err)>$e ===TRUE)
        {
            $this->_error_(10,$err);
            return FALSE;
        }else return TRUE;
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