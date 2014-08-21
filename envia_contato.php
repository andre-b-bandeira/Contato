<?



include("contador.php");


$meu_arquivo = "contato_email.html";
 

$id = fopen($meu_arquivo,"r");
$conteudo = fread($id,filesize($meu_arquivo));


foreach ($_POST as $key => $value) {

	$conteudo = str_replace("%$key%",$value ,$conteudo);


}

$email = $_POST['email'];

$conteudo = str_replace("%data%",date("j/n/Y - H:i:s") ,$conteudo);
$conteudo = str_replace("%ip%",$_SERVER['REMOTE_ADDR'] ,$conteudo);
$conteudo = str_replace("%host%",$_SERVER['HTTP_HOST'] ,$conteudo);

	
	$data_inc_a = date("j-n-Y H-i-s");
	
	$email_vendedor_contador = sprintf("%05d",$contador);

	$filename = $email_vendedor_contador ." - " . $data_inc_a .".html";
	$diretorio = "contato";

	chdir($diretorio);	
	@$arquivo = fopen($filename,"w");

	$email_remetente = $_POST["nome"];
	$email_reply = $email;
	$email_assunto = "Fale Conosco - ". $email_vendedor_contador;
	
	$usuario = 'usuario@seudominio.com.br';

	$senha = '1234567890';



//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
date_default_timezone_set('Etc/UTC');

require 'PHPMailerAutoload.php';

//Create a new PHPMailer instance
$mail = new PHPMailer();
//Tell PHPMailer to use SMTP
$mail->isSMTP();
//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 0;
//Ask for HTML-friendly debug output
$mail->Debugoutput = 'html';
//Set the hostname of the mail server
$mail->Host = "smtp.seudominio.com.br";
//Set the SMTP port number - likely to be 25, 465 or 587
$mail->Port = 587;
//Whether to use SMTP authentication
$mail->SMTPAuth = true;
//Username to use for SMTP authentication
$mail->Username = $usuario;
//Password to use for SMTP authentication
$mail->Password = $senha;
//Set who the message is to be sent from
$mail->setFrom($usuario, $email_remetente);
//Set an alternative reply-to address
$mail->addReplyTo($email_reply, $email_remetente);
//Set who the message is to be sent to
$mail->addAddress($usuario, $email_remetente);
//Set the subject line
$mail->Subject = $email_assunto;


$mail->msgHTML($conteudo);

//send the message, check for errors
if (is_writable($filename)) {
	if (!$mail->send()) {
		echo "Mailer Error: " . $mail->ErrorInfo;
	} else {
		echo "<script>

			alert('Enviado com sucesso');
			javascript:history.back();
			
			</script>";
	}
}

?>