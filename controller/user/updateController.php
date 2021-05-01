<?PHP
require_once '../config/init_set.php';
require_once '../controller/session/session.controller.php';
require_once '../models/user/database.user.php';

class atualizarUsuarioController
{
	private $login;

	public function __construct()
	{
		$this->login= new User_Database();
	}


	public function updateUsuario(array $data)
	{
		if($this->is_updateUserValid($data))
		{
			if($this->validMail($data['mailU']) && $this->checkPassword($data['Upwd1'],$data['Upwd2']))
			{
					$this->login->setData(date('Y-m-d H:i:s'));
					$this->login->setUsername($data['userU']);
					$this->login->setNome($data['nameU']);
					$this->login->setEmail($data['mailU']);
					$this->login->setSenha(base64_encode($data['Upwd1']));
					if($this->login->updateUser())
					{
						$session = SessionController::getInstance();
						//$id=$session->setSession($data);
						$sesdata  = 'username:'.$data['userU'].',';
						$sesdata .= 'nome:'.$data['nameU'].',';
						$sesdata .= 'email:'.$data['mailU'].',';
						$sesdata .= 'senha:'.$data['Upwd1'].',';
						$sesdata .= 'data:'.strval(date("d/m/Y")).',';
						$sesdata .= 'hora:'.strval(date("H:i")).',';
						$sesdata .= 'uid:'.$data['session_id'].'';	
						//echo $sesdata;
						$id = $session->writeSession($data['session_id'],$sesdata,$data['userU']);
						$this->_error_(20,'Usuario atualizado com Sucesso');
					}	
			}	
		}	
	}


	function is_updateUserValid(array $data)
    {
    	$err='';
    	if(empty(trim($data['nameU'])))
    	{
    		$err.='O Nome deve ser preenchido,';
    		$err.=' ';
    	}
    	if(empty(trim($data['mailU'])))
    	{
    		$err.='O e-mail deve ser preenchido,';
    		$err.=' ';
    	}
    	if(empty(trim($data['Upwd1'])))
    	{
    		$err.='A senha deve ser preenchido,';
    		$err.=' ';
    	}
    	if(empty(trim($data['Upwd2'])))
    	{
    		$err.='A confimação de senha deve ser preenchida,';
    		$err.=' ';
    	}
    	if(isset($err) && strlen(trim($err))>0)
    	{
    		$this->_error_(10,$err);
    		return FALSE;
    	}
    	else return TRUE;
    }

    function checkPassword($pass1, $pass2)
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