<?php

    require "./bibliotecas/PHPMailer/Exception.php";
    require "./bibliotecas/PHPMailer/OAuth.php";
    require "./bibliotecas/PHPMailer/PHPMailer.php";
    require "./bibliotecas/PHPMailer/POP3.php";
    require "./bibliotecas/PHPMailer/SMTP.php";
     
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;




     class Mensagem
     {
         private $email = null;
         private $assunto = null;
         private $mensagem = null;
         public $status = array('codStatus' => null , 'descStatus' => '' );

         public function __get($attr){
         	return $this->$attr;
         }

          public function __set($attr, $valor){
         $this->$attr = $valor;
     }

          public function msgValida(){
          if(empty($this->email) || empty($this->assunto) || empty($this->mensagem)) {
          	return false;
          }
            return true;
          }

      }

      $msg = new Mensagem();

      $msg->__set('email', $_POST['email']);

      $msg->__set('assunto', $_POST['assunto']);

      $msg->__set('mensagem', $_POST['mensagem']);

      if(!$msg->msgValida()){
      	echo "mensagem não é valida";
      	header('Location: index.php?Erro:crieprimeiroumemail');
      }

      $mail = new PHPMailer(true);

try {
    //Server settings
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'marcojosiel2@gmail.com';                     //SMTP username
    $mail->Password   = 'hkoi elfl mydh wktu';                               //SMTP password
    $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('marcojosiel2@gmail.com', 'remetente');
    $mail->addAddress($msg->__get('email'));     //Add a recipient
                 //Name is optional
    //$mail->addReplyTo('info@example.com', 'Information');
    //$mail->addCC('cc@example.com');
   // $mail->addBCC('bcc@example.com');

    //Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $msg->__get('assunto');
    $mail->Body    = $msg->__get('mensagem');
    $mail->AltBody = 'Necessário utilizar um client que suporta HTML para conseguir ver a mensagem!';

    $mail->send();
    $msg->status['codStatus'] = 1;
    $msg->status['descStatus'] = "Email foi enviado com sucesso!!";
    

} catch (Exception $e) {
	$msg->status['codStatus'] = 2;
	$msg->status['descStatus'] = 'A mensagem não foi enviada';
   
}
      
 ?>

<html>
<head>
	<meta charset="utf-8">
	<title>App Mail Send</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body>
       <div class="container">
       	        <div class="py-3 text-center">
				<img class="d-block mx-auto mb-2" src="logo.png" alt="" width="72" height="72">
				<h2>Send Mail</h2>
				<p class="lead">Seu app de envio de e-mails particular!</p>
			</div>

			<div class="row">
				<div class="col-md-12">
					<?php
                         if ($msg->status['codStatus'] == 1 ) { ?>
                         	
                         	<div class="container">
                         		<h1 class="display-4 text-success">Sucesso</h1>
                         		<p><?php $msg->status['descStatus']?></p>
                         		<a href="index.php" class="btn btn-success btn-lg mt-5 text-white">Voltar</a>
                         	</div>
                         

                     <?php } ?>

                     <?php
                         if ($msg->status['codStatus'] == 2 ) { ?>
                         	
                         	<div class="container">
                         		<h1 class="display-4 text-danger">Erro</h1>
                         		<p><?php $msg->status['descStatus']?></p>
                         		<a href="index.php" class="btn btn-danger btn-lg mt-5 text-white">Voltar</a>
                         	</div>
                         

                     <?php } ?>

				</div>

			</div>

       </div>


</body>

</html>
 
 	

