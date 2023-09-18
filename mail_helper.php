<?php
function sendmail($fromname,$to,$subject,$body)
{
    $ci = get_instance();
    $ci->load->library("Phpmailer_library");
    $mail = $ci->phpmailer_library->load();
    /* setting SMTP */
    $mail->isSMTP();
    $mail->Host = "ssl://smtp.gmail.com";
    $mail->Port = 465; //sesuaikan port
    $mail->SMTPAuth = true;
    $mail->Username = "alfian.github404@gmail.com";
    $mail->Password = "@Qwe123qwe123qwe";
    $mail->WordWrap = 300;
//    $mail->SMTPDebug = 2;

    $mail->setFrom("alfian.github404@gmail.com", "$fromname");
    $mail->addAddress($to); //alamat email yang dituju
    $mail->Subject = "$subject"; //subject
    $mail->Body = $body;
    $mail->isHTML(true);

    $sends = $mail->send();
    return $sends;
}
