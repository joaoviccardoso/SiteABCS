<?php
@include_once "./lib/PHPMailer/PHPMailerAutoload.php";
class emailModel{
    public function __construct($destinatario,$nome, $assunto, $mensagem, $remetente, $nome_remetente) {
        $this->sendMail($destinatario,$nome, $assunto, $mensagem, $remetente, $nome_remetente);
    }
    
    public function sendMail($destinatario,$nome, $assunto, $mensagem, $remetente, $nome_remetente){
        @require './const/const.php';
        $qry = "INSERT INTO email (email_dest, nome_dest, assunto, mensagem, email_rem, nome_rem) VALUES ('".$destinatario."','".$nome."', '".$assunto."', '".(string)$mensagem."', '".$remetente."', '".$nome_remetente."')";
        mysqli_query($conn, $qry);
        $id = mysqli_insert_id($conn);
        $link_leitura = "<img src = 'http://abcsinformatica.com.br/leitura.php?id=".$id."' width='0' height='0'>";
        $mail = new PHPMailer(true);
        $mail->setLanguage('pt_br', '../vendor/PHPMailer/language/phpmailer.lang-pt_br.php');
        //$mail->SMTPDebug = 3;
        $mail->isSMTP();
        $mail->Host = 'mail.santaficha.com.br; mail.santaficha.com.br';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'i@santaficha.com.br';                 // SMTP username
        $mail->Password = 'xx$<.42rHRKm';                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to
        $mail->CharSet = 'UTF-8';
        $mail->setFrom( $remetente, $nome_remetente);
        $mail->addAddress($destinatario, $nome);    // Add a recipient
        $mail->addReplyTo( $remetente, $nome_remetente);
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $assunto;
        $mail->Body    = $mensagem.$link_leitura;

        if(!$mail->send()) {
            return false;
        } else {
            $qry = "UPDATE email SET enviado = 1 WHERE idemail ='".$id."' ";
            mysqli_query($conn, $qry);
        
            return true;  
        }
    }
}
