<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form method="POST">
    <br><br>
    Получатели: <input type="text" name="receivers" size=20%/ value="<?php if (isset($_POST['receivers'])) Echo $_POST['receivers']; ?>"><br><br>
    Тема: <input type="text" name="subject" size=20%/ value="<?php if (isset($_POST['subject'])) Echo $_POST['subject']; ?>"><br><br>
    Текст сообщения: <input type="text" name="message" size=20%/ value="<?php if (isset($_POST['message'])) Echo $_POST['message']; ?>"><br><br>
    <input type="submit" name="send" value="Отправить">
</form>
</body>
</html>

<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    // Load Composer's autoloader
    require 'vendor/autoload.php';
    require "connection.php";//загрузка данных о почтовом аккаунте ($username, $password, $name)
    if (isset($_POST['send']) && $_POST['receivers'] !== "" && $_POST['message'] !== "" && $_POST['subject'] !== ""){
        $receivers = preg_split("/[,|;|\s]+/" , $_POST['receivers']);
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->SMTPAuth = 'true';
        $mail->SMTPSecure = 'tls';
        $mail->Port = '587';
        $mail->Username = $username;
        $mail->Password = $password;
        $mail->Subject = $_POST['subject'];
        $mail->setFrom($username, $name);
        $mail->Body = $_POST['message'];
        foreach ($receivers as $email){
            if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                $mail->addAddress($email);
            }
            else{
                echo "$email не является корректно введенным email<br>";
            }
        }
        if ($mail->send()) {
            $file = fopen('receivers.txt', 'w+');
            foreach ($receivers as $receiver){
                fputs($file, $receiver."\n");
            }
            fclose($file);
            echo "Отправлено";
        } else {
            echo 'Ошибка отправки:' . $mail->ErrorInfo;
        };


    }
?>