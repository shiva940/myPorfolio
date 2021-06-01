<?php
require 'PHPMailer-master/PHPMailerAutoload.php';
if($_SERVER["REQUEST_METHOD"] == "POST"){
$f_name = $_REQUEST['name'];
$phone=  $_REQUEST['phone']; 
$email_id =  $_REQUEST['email'];
$subject_title =  $_REQUEST['subject'];
$description =  $_REQUEST['description']; 

$subject='Re: contact Application from portfolio.';

$mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 425;
        $mail->SMTPSecure = FALSE;
        $mail->SMTPAuth = true;
        $mail->SMTPAutoTLS = FALSE;
		$mail->CharSet = 'UTF-8';
		//From email address and name
        $mail->From = "shivanagaraju940@gmail.com";
        $mail->FromName = "website Contact-Form";
        //To address and name
        $mail->addAddress("shivanagaraju940@gmail.com", "MyPortfolio");
		$mail->isHTML(true);
		$mail->Subject = $subject;
		$mail->WordWrap   = 80;
		
$fields = array('name' => 'Full Name',
                'phone' => 'Phone',
				'email' => 'Email Id',
				'subject' => 'Subject',
				'description' => 'Reason for contact/ Message',
				);
	$okMessage = 'Hi '.$f_name.' , your form successfully submitted. Thank you, We will get back to you soon!';
	$errorMessage = 'There was an error while submitting the form. Please try again later';
error_reporting(E_ALL & ~E_NOTICE);
try
{
	 if(count($_POST) == 0) throw new \Exception('Form is empty');
    
    $emailTextHtml = "<h1>You have a new email Regarding $subject_title </h1><hr>";
    $emailTextHtml .= "<table>";
    foreach ($_POST as $key => $value) {
        if (isset($fields[$key])) {
			 $emailTextHtml .= "<tr><td><b>$fields[$key]   </td> <td></td><td>:</td><td></td><td>$value</td></tr>";
        }
    }
    $emailTextHtml .= "</table><hr>";
    $emailTextHtml .= "<p>Have a nice day,<br>Best Regards from,<br><strong>Peopleprime Worldwide</strong></p>";
    $mail->Body = $emailTextHtml;
	$mail->addAddress($to);
	if(!$mail->send()) {
        throw new \Exception('Could not send the email.' . $mail->ErrorInfo);
    }
        $responseArray = array('type' => 'success', 'message' => $okMessage);
}
catch (\Exception $e)
{
    $responseArray = array('type' => 'danger', 'message' => $e->getMessage());
}
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $encoded = json_encode($responseArray);
    header('Content-Type: application/json');
    echo $encoded;
}
else {
    echo $responseArray['message'];
}
}