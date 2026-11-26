<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once './lib/PHPMailer/src/Exception.php';
require_once './lib/PHPMailer/src/PHPMailer.php';
require_once './lib/PHPMailer/src/SMTP.php';

class emailModel
{
    public $enviado = false;

    public function __construct($destinatario, $nome, $assunto, $mensagem, $remetente, $nome_remetente)
    {
        $this->enviado = $this->sendMail($destinatario, $nome, $assunto, $mensagem, $remetente, $nome_remetente);
    }

    public function sendMail($destinatario, $nome, $assunto, $mensagem, $remetente, $nome_remetente)
    {
        @require './const/const.php';

        // Registro no banco (histórico). Falha aqui NÃO impede o envio do e-mail.
        $id = 0;
        try {
            $stmt = mysqli_prepare($conn, "INSERT INTO email (email_dest, nome_dest, assunto, mensagem, email_rem, nome_rem) VALUES (?,?,?,?,?,?)");
            $msg = (string)$mensagem;
            mysqli_stmt_bind_param($stmt, 'ssssss', $destinatario, $nome, $assunto, $msg, $remetente, $nome_remetente);
            mysqli_stmt_execute($stmt);
            $id = (int)mysqli_insert_id($conn);
            mysqli_stmt_close($stmt);
        } catch (\Throwable $t) {
            error_log('emailModel INSERT falhou: ' . $t->getMessage());
        }

        $link_leitura = $id > 0
            ? "<img src='http://abcsinformatica.com.br/leitura.php?id=" . $id . "' width='0' height='0'>"
            : '';

        try {
            $mail = new PHPMailer(true);
            $mail->setLanguage('pt_br', './lib/PHPMailer/language/');
            //$mail->SMTPDebug = 3;
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'joao.viccardoso.silva@gmail.com';
            $mail->Password   = 'wtrs fzbj fmrh levg'; // senha de app de 16 caracteres (mover para const/const.php)
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // equivale a 'tls'
            $mail->Port       = 587;
            $mail->CharSet    = 'UTF-8';

            // From fixo (conta autenticada); o visitante fica no Reply-To
            $mail->setFrom('joao.viccardoso.silva@gmail.com', 'Site ABCS Informática');
            $mail->addAddress($destinatario, $nome);
            $mail->addReplyTo($remetente, $nome_remetente);

            $mail->isHTML(true);
            $mail->Subject = $assunto;
            $mail->Body    = $mensagem . $link_leitura;

            $mail->send();
        } catch (\Throwable $ex) {
            error_log('emailModel envio falhou: ' . $ex->getMessage());
            return false;
        }

        if ($id > 0) {
            try {
                $stmt = mysqli_prepare($conn, "UPDATE email SET enviado = 1 WHERE idemail = ?");
                mysqli_stmt_bind_param($stmt, 'i', $id);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
            } catch (\Throwable $t) {
                error_log('emailModel UPDATE falhou: ' . $t->getMessage());
            }
        }

        return true;
    }
}
?>