<?php
$pixel_id = '554061686441388';

if (!$pixel_id) {
  // If FACEBOOK_PIXEL_ID is not set, exit the script
  exit();
}

$access_token = $_ENV['FACEBOOKACCESSTOKEN'];

if (!$access_token) {
  // If FACEBOOK_ACCESS_TOKEN is not set, exit the script
  exit();
}

if (isset($_POST['event_name'])) {
  $event_name = $_POST['event_name'];
  $user_ip = $_SERVER['REMOTE_ADDR'];
  $user_agent = $_SERVER['HTTP_USER_AGENT'];
  $event_time = time();

  $data = array(
    'data' => array(
      array(
        'event_name' => $event_name,
        'event_time' => $event_time,
        'user_data' => array(
          'client_ip_address' => $user_ip,
          'client_user_agent' => $user_agent
        )
      )
    )
  );

  $url = "https://graph.facebook.com/v12.0/{$pixel_id}/events";
  $curl = curl_init($url);
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
  curl_setopt($curl, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Authorization: Bearer ' . $access_token
  ));
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  $response = curl_exec($curl);
  curl_close($curl);
}
