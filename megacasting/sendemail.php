<?php
	header('Content-type: application/json');
	$status = array(
		'type'=>'success',
		'message'=>'Merci de nous avoir contacter. Nous vous répondrons dès que possible'
	);

    $name = @trim(stripslashes($_POST['name'])); 
    $email = @trim(stripslashes($_POST['email'])); 
    $subject = @trim(stripslashes($_POST['subject'])); 
    $message = @trim(stripslashes($_POST['message'])); 

    $email_from = $email;
    $email_to = 'megacasting.pro@gmail.com';//replace with your email

    $body = 'Nom: ' . $name . "\n\n" . 'Email: ' . $email . "\n\n" . 'Sujet: ' . $subject . "\n\n" . 'Message: ' . $message;

    $success = @mail($email_to, $subject, $body, 'From: <'.$email_from.'>');

    echo json_encode($status);
    die;