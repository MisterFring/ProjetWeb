<?php
function send_mail($email){
    $to      =  $email;
    $subject = '[ITEFY] Thank you for registering on our website.';
    $message = 'Thank you for registering on our website.';
    $headers = array(
        'From' => 'support@itefy.com',
        'Reply-To' => 'notreply@itefy.com',
        'X-Mailer' => 'PHP/' . phpversion()
    );
    mail($to, $subject, $message, $headers);
}
function check_password($password){ 
    if( strlen($password ) < 8 ) {
    $error .= "Password too short!
    ";
    }
    if( strlen($password ) > 20 ) {
    $error .= "Password too long!
    ";
    }
    if( strlen($password ) < 8 ) {
    $error .= "Password too short!
    ";
    }
    if( !preg_match("#[0-9]+#", $password ) ) {
    $error .= "Password must include at least one number!
    ";
    }
    if( !preg_match("#[a-z]+#", $password ) ) {
    $error .= "Password must include at least one letter!
    ";
    }
    if( !preg_match("#[A-Z]+#", $password ) ) {
    $error .= "Password must include at least one CAPS!
    ";
    }
    if( !preg_match("#\W+#", $password ) ) {
    $error .= "Password must include at least one symbol!
    ";
    }

    if($error){    
        $errorLogPw_2 = '<div style="font-style: italic; font-weight: bold; text-align: center">Password validation failure '.$error.'</div></br>';
        return $errorLogPw_2;
    } else {
        return true;
    }
   
}
?>
