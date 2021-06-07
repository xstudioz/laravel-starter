<?php


namespace App\Xstudioz;


class SmsService
{
  static function sendSms($mobilenumber, $message, $senderID = "SMRTWD")
  {

    $user = "bookyourown"; //your username
    $password = "bookingonline07"; //your password
    $url = "http://www.smscountry.com/SMSCwebservice_Bulk.aspx";

    $message = urlencode($message);
    $ch = curl_init();
    $ret = curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "User=$user&passwd=$password&mobilenumber=$mobilenumber&message=$message&sid=$senderID&mtype=N&DR=Y");
    $ret = curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch); // execute
  }

}
