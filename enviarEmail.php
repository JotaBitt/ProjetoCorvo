<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Carregar o autoloader do Composer
require 'vendor/autoload.php';

$mail = new PHPMailer(true);

$email = $_POST['Email'];

try {
    
    // Configurações do servidor
    $mail->isSMTP();                                            // Enviar usando SMTP
    $mail->Host       = 'smtp.gmail.com';                       // Servidor SMTP do Gmail
    $mail->SMTPAuth   = true;                                   // Habilitar autenticação SMTP
    $mail->Username   = 'sistemacorvo@gmail.com';                  // Seu endereço de e-mail Gmail
    $mail->Password   = "lfay bjno rgjt dsao";              // Sua senha de aplicativo do Gmail
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Habilitar encriptação TLS
    $mail->Port       = 587;                                    // Porta TCP para TLS

    // Configurações do remetente e destinatário
    $mail->setFrom('sistemacorvo@gmail.com', 'noreply');
    $mail->addAddress($email, "José Wilson"); // Adicionar um destinatário

    // Conteúdo do e-mail
    $mail->isHTML(true);                                        // Definir o formato do e-mail como HTML
    $mail->Subject = 'Sistema Corvo - Redefinir senha';

    $codigo = gerarCodigoVerificador(6);

    $mensagemEmail = 
    "<html>
        <body>
            <h1 style='text-align: center;'>Sistema Corvo</h1>
            <p>Foi solicitado uma redefinição de senha na conta associada a este e-mail. Valide o código usando <strong>$codigo</strong> no sistema clicando <a href='https://e794f451-d0b3-47e4-9ee0-028953a05e12-00-1d15i24l5rn01.spock.replit.dev/esqueceuSenha.html'>aqui</a>.</p>
        </body>
    </html>";
    $mail->Body    = $mensagemEmail;

    // Enviar o e-mail
    $mail->send();
    
    header("Location: /login");
    exit;


} catch (Exception $e) {
    echo "A mensagem não pôde ser enviada. Erro do Mailer: {$mail->ErrorInfo}";
}


function gerarCodigoVerificador($tamanho) {
    $alfabeto   = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    $tamanhoAlfabeto = strlen($alfabeto);
    $codigo = '';
    for ($i = 0; $i < $tamanho; $i++) {
        $codigo .= $alfabeto[rand(0, $tamanhoAlfabeto - 1)];
    }
    return $codigo;
}