<?

require_once '../models/email/email.model.php';

class emailController
{
	function __construct()
	{

	}



	public function setNome($string)
	{
		$this->nome=$string;
	}


	public function setEmail($string)
	{
		$this->email=$string;
	}


	public function setUsername($string)
	{
		$this->username=$string;
	}


	public function setPassword($string)
	{
		$this->password=$string;
	}


	public function getNome()
	{
		return $this->nome;
	}

	public function getEmail()
	{
		return $this->email;
	}


	public function getUsername()
	{
		return $this->username;
	}

	public function getPassword()
	{
		return $this->password;
	}


	public function emailOnLoging()
	{
		$this->_mail = new EmailServerModel();
		return $this->_mail->_emailLogin($this->getNome(),$this->getEmail(),$this->getUsername());
	}

	public function emailRecoverUser()
	{
		if(empty($this->_mail))
		{
			$this->_mail = new EmailServerModel();
		}	
		return $this->_mail->_emailRecover($this->getNome(),$this->getEmail(),$this->getUsername(),$this->getPassword());
	}

	private $_mail;
	private $nome;
	private $email;
	private $username;
	private $password;
}
?>