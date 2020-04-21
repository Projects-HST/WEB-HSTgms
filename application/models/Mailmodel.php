<?php
Class Mailmodel extends CI_Model
{
	public function __construct()
	{
	  parent::__construct();
	}

	function sendEmail($to_email,$subject,$htmlContent)
	{
		// Set content-type header for sending HTML email
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		// Additional headers
		$headers .= 'From: GMS Administrator<info@happysanztech.com>' . "\r\n";
		mail($to_email,$subject,$htmlContent,$headers);
	}
}
?>
