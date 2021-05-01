<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';
require_once '../config/init_set.php';


class EmailServerModel
{

		function __construct()
		{

		}



		
	private static $_mail;
	private $host='mail.fastcoffee.com.br';
	private $host_uname =  'ti@fastcoffee.com.br';
	private $host_pwd='-o6Ya0nt47EU!W';
	private $host_port =465;


	public function _emailLogin($name,$email,$username)
	{
		//date_default_timezone_set('America/Sao_Paulo');
		$cleanedFrom= 'noreply@ypanel.com';
		$headers = "From: " . $cleanedFrom . "\r\n";
		$headers .= "Reply-To: ". $email . "\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		$subject = "Login Realizado ".date("d/m/y")."  ".date("H:i")." no YPanel";
		$msg = " Não responda este e-mail, este é um email de aviso, toda vez que se logarem.";
		$posted = false;
		$htmlbody="";
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; ' . "\r\n";
		$headers .= "From: noreply@inesp.com.br\r\n";
		$headers .= "Reply-To: noreply@inesp.com.br\r\n";
		$htmlbody.="<!DOCTYPE html>";
		$htmlbody.="<html>";
		$htmlbody.='<table>';
		$htmlbody.='<tr>';
		$htmlbody.='<td width="80px">&nbsp;</td>';
		$htmlbody.=' <td width="84%" align="left" valign="top"><p><strong><em>"'.$subject.'"</em></strong><br/>';
		$htmlbody.='</p>';
		$htmlbody.='<p>>Nome:'.' '.$name.'</p><hr>';
		$htmlbody.='<p>Email:'.' '.$email.'</p><hr>';
		$htmlbody.='<p>Username:'.' '.$username.'</p><hr>';
		$htmlbody.='<br>';
		$htmlbody.='<p><strong><em>Enviou a seguinte menssagem,</em></strong></p>';
		$htmlbody.='<p><font style="font-family: Verdana, Geneva, sans-serif; color:#666766; font-size:13px; line-        height:21px">'.$msg.'<br/>';
		$htmlbody.='<br/>';
		$htmlbody.='<td width="8%">&nbsp;</td>';
		$htmlbody.='</tr>';
		$htmlbody.='<tr>';
		$htmlbody.='<td>&nbsp;</td>';
		$htmlbody.='</tr>';
		$htmlbody.='</table>';
		$htmlbody.="</html>";
		//=========================================================
		if(empty($_mail))
		{
			$_mail = new PHPMailer(true);
		}	
	    $_mail->isSMTP();
	    $_mail->Host = HOST;
	    $_mail->SMTPAuth = true;
	    $_mail->SMTPSecure = 'ssl';
	    $_mail->SMTPDebug = 0;  
	    $_mail->Username = USER;
	    $_mail->Password = PWD;
	    $_mail->Port = PORT;
	    $_mail->CharSet="UTF-8";
	    $_mail->Sender='noreply@hospedagemphpcpanel.com';
	    $_mail->setFrom('noreply@hospedagemphpcpanel.com');
	    $_mail->AddReplyTo('noreply@hospedagemphpcpanel.com');
	    $_mail->addAddress($email, $name);
	    $_mail->Subject=$subject;
	    $_mail->IsHTML(true);
	    $_mail->Body =$htmlbody;
		//=========================================================
			try
			{
    			$_mail->send();
  				return TRUE; 
  				die();
			}
			catch (Exception $e)
			{
    		 	//$_mail->ErrorInfo;
    		 	return FALSE;
    		 	die();
		}
		//=========================================================

	}



	public function _emailRecover($name,$email,$username,$senha)
	{
		//date_default_timezone_set('America/Sao_Paulo');
		$cleanedFrom= 'noreply@ypanel.com';
		$headers = "From: " . $cleanedFrom . "\r\n";
		$headers .= "Reply-To: ". $email . "\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		$subject = "Recuperacao de Dados, feita em ".date("d/m/y")."  ".date("H:i")." no YPanel";
		$msg = " Não responda este e-mail. Caso nao  requisitou recuperar dados de acesso troque sua senha";
		$posted = false;
		$htmlbody="";
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; ' . "\r\n";
		$headers .= "From: noreply@inesp.com.br\r\n";
		$headers .= "Reply-To: noreply@inesp.com.br\r\n";
		$htmlbody.="<!DOCTYPE html>";
		$htmlbody.="<html>";
		$htmlbody.='<table>';
		$htmlbody.='<tr>';
		$htmlbody.='<td width="80px">&nbsp;</td>';
		$htmlbody.=' <td width="84%" align="left" valign="top"><p><strong><em>"'.$subject.'"</em></strong><br/>';
		$htmlbody.='</p>';
		$htmlbody.='<p>>Nome:'.' '.$name.'</p><hr>';
		$htmlbody.='<p>Email:'.' '.$email.'</p><hr>';
		$htmlbody.='<p>Username:'.' '.$username.'</p><hr>';
		$htmlbody.='<p>Senha:'.' '.$senha.'</p><hr>';
		$htmlbody.='<br>';
		$htmlbody.='<p><strong><em>Enviou a seguinte menssagem,</em></strong></p>';
		$htmlbody.='<p><font style="font-family: Verdana, Geneva, sans-serif; color:#666766; font-size:13px; line-height:21px">'.$msg.'<br/>';
		$htmlbody.='<br/>';
		$htmlbody.='<td width="8%">&nbsp;</td>';
		$htmlbody.='</tr>';
		$htmlbody.='<tr>';
		$htmlbody.='<td>&nbsp;</td>';
		$htmlbody.='</tr>';
		$htmlbody.='</table>';
		$htmlbody.="</html>";
		//=========================================================
		$_mail = new PHPMailer(true);
	    $_mail->isSMTP();
	    $_mail->Host = HOST;
	    $_mail->SMTPAuth = true;
	    $_mail->SMTPSecure = 'ssl';
	   // $_mail->SMTPDebug = 3;  
	    $_mail->Username = USER;
	    $_mail->Password = PWD;
	    $_mail->Port = PORT;
	    $_mail->CharSet="UTF-8";
	    $_mail->Sender='noreply@hospedagemphpcpanel.com';
	    $_mail->setFrom('noreply@hospedagemphpcpanel.com');
	    $_mail->AddReplyTo('noreply@hospedagemphpcpanel.com');
	    $_mail->addAddress($email, $name);
	    $_mail->Subject=$subject;
	    $_mail->IsHTML(true);
	    $_mail->Body =$htmlbody;
			//=========================================================
			try
			{
    			$_mail->send();
  				return TRUE; 
			}
			catch (Exception $e)
			{
				//$_mail->ErrorInfo;
				 return FALSE;
			}
		//=========================================================

	}


}


?>