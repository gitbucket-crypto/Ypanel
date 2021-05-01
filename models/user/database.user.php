<?php
require_once '../config/init_set.php';

class User_Database 
{

    private $nome;
    private $username;
    private $senha;
    private $data;
    private $flag;
    private $email;
    private $mysqli;

	public function __construct()
	{
		$this->connect();
	}


	private function connect()
	{
		$this->mysqli = new PDO("mysql:host=".BD_SERVIDOR.';port='.BD_PORT.';dbname='.BD_BANCO, BD_USUARIO, BD_SENHA);
		$this->mysqli->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);  
		$this->mysqli->query('SET NAMES utf8');
		$this->mysqli->query('SET CHARACTER SET utf8');
	}

    //=========================================================================
	public function setNome($string)
	{
        $this->nome = $string;
    }

    public function setFlag($string)
    {
        $this->flag = $string;
    }

    public function setData($string)
    {
        $this->data = $string;
    }

    public function setUsername($string)
    {
        $this->username = $string;
    }

    public function setEmail($string)
    {
        $this->email = $string;
    }

    public function setSenha($string)
    {
        $this->senha = $string;
    }

    //=========================================================================

    public function getNome()
    {
        return $this->nome;
    }

    public function getFlag()
    {
        return $this->flag;
    }
    public function getData()
    {
        return $this->data;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getSenha()
    {
        return $this->senha;
    }

    //=========================================================================

	public function loginUser()
	{  
        ////SELECT * FROM `tb_usuario` WHERE username ='pedro.hsdeus@hotmail.com' OR email='pedro.hsdeus@hotmail.com' and senha='fast9002'
		$sql = "SELECT nome, email, senha, username FROM datatest.tb_usuario WHERE email like'$this->getEmail()' OR username like '$this->getUsername()' AND senha= '$this->getSenha()' and is_active=1";
		//AND senha like'$pass'
		$statement = $this->mysqli->prepare($sql);
		$statement->execute();
		$resultSet=$statement->fetchAll(PDO::FETCH_ASSOC);
		if(sizeof($resultSet)>0 )
		{
			$row= $resultSet[0];
			$data= array
			(
                'username'=>strval($row['username']),
                'nome'=>strval($row['nome']),
                'email'=>strval($row['email']),       
                'senha'=>strval($row['senha'])
            );
            return $data;
		}return FALSE;
	}



    //=========================================================================

    public function updateUser()
    {
        $timestamp = $this->getData();
        $nome = $this->getNome();
        $email = $this->getEmail();
        $password = $this->getSenha();
        $username = $this->getUsername();
        $sql="UPDATE datatest.tb_usuario SET nome='".$nome."', email='".$email."', senha='".$password."', data_criacao='".$timestamp."' WHERE username ='".$username."' AND is_active=1";
        $statement = $this->mysqli->prepare($sql);
        $statement->execute();
        $result=$statement->execute([$nome, $email,$password,$timestamp,$username]);

        if($result)
        {
                return TRUE;
        }
        else return FALSE;
        die();
    }

    //=========================================================================

    public function createUser()
    {
        $sql="INSERT INTO tb_usuario (nome,username,email,senha,data_criacao,is_active)
            VALUES ('$this->nome', '$this->username','$this->email','$this->senha','$this->data',1)";

        $statement = $this->mysqli->prepare($sql);
      
        $result=$statement->execute([$this->getNome(),$this->getUsername(), $this->getEmail(),$this->getSenha(),$this->getData(),1]);
        if($result)
        {
               return TRUE;
        }
        else return FALSE;
        die();
    }

    public function recoverUserData()
    {  //SELECT * FROM `tb_usuario` WHERE username ='chronos' OR email like 'lara.mora@hotmail.com' AND is_active like 1 LIMIT 1

        $sql = "SELECT nome, email, senha, username,is_active FROM datatest.tb_usuario WHERE email like'$this->email' OR username like '$this->username' and is_active=1  LIMIT 1";
        $statement = $this->mysqli->prepare($sql);
        $statement->execute();
        $resultSet=$statement->fetchAll(PDO::FETCH_ASSOC);
        if(sizeof($resultSet)>0 )
        {
            $row= $resultSet[0];
            $data= array
            (
                'username'=>strval($row['username']),
                'nome'=>strval($row['nome']),
                'email'=>strval($row['email']),       
                'senha'=>strval($row['senha'])
            );
            return $data;
        }return FALSE;
    }



}

?>