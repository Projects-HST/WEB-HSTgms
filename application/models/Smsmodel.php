<?php
Class Smsmodel extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

//#################### SMS ####################//

	public function sendSMS($to_phone,$smsContent)
	{
        //Your authentication key
        $authKey = "308533AMShxOBgKSt75df73187";

        //Multiple mobiles numbers separated by comma
        $mobileNumber = "$to_phone";

        //Sender ID,While using route4 sender id should be 6 characters long.
        $senderId = "GADMIN";

        //Your message to send, Add URL encoding here.
        $message = urlencode($smsContent);

        //Define route
        $route = "transactional";

        //Prepare you post parameters
        $postData = array(
            'authkey'=> $authKey,
            'mobiles'=> $mobileNumber,
            'message'=> $message,
            'sender'=> $senderId,
            'route'=> $route
        );

        //API URL
        $url="https://control.msg91.com/api/sendhttp.php";

        // init the resource
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $postData
            //,CURLOPT_FOLLOWLOCATION => true
        ));



        //Ignore SSL certificate verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);


        //get response
        $output = curl_exec($ch);

        //Print error if any
        if(curl_errno($ch))
        {
            echo 'error:' . curl_error($ch);
        }

        curl_close($ch);
	}

//#################### SMS End ####################//

//#################### voice call start  ####################//


		function send_voice_call($constituent_id){

			$get_phone="SELECT * FROM constituent where id='$constituent_id'";
			$res=$this->db->query($get_phone);
			foreach($res->result() as $rows){}
			$phone=$rows->mobile_no;
			$username = urlencode("u2630");
			$token = urlencode("57cchT");
			$plan_id = urlencode("5949");
			$announcement_id = urlencode("209974");
			$caller_id = urlencode("newcompany");
			$contact_numbers = urlencode($phone);
			$api = "http://103.255.100.37/api/voice/voice_broadcast.php?username=".$username."&token=".$token."&plan_id=".$plan_id."&announcement_id=".$announcement_id."&caller_id=".$caller_id."&contact_numbers=".$contact_numbers."";
			$curl = curl_init();
      curl_setopt_array($curl, array(
      CURLOPT_URL => $api,

      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_SSL_VERIFYHOST => 0,
      CURLOPT_SSL_VERIFYPEER => 0,
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    if ($err) {
      echo "cURL Error #:" . $err;
    } else {
      echo $response;
    }

		}

//#################### voice call end ####################//

}
?>
