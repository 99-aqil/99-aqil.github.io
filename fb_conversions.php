<?php
// ------------------------------------------------
// This is a Facebook Conversions API PHP Integration
// Created by: Gilberto C.
// InteractiveUtopia.com
// ------------------------------------------------
// First, we need to start by obtaining the information that will be sent to Facebook
// ------------------------------------------------

// ------------------------------------------------
// Get Current User IP Address
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $user_ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $user_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $user_ip = $_SERVER['REMOTE_ADDR'];
}

// ------------------------------------------------
// Get current page
$actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
//echo $actual_link;

// ------------------------------------------------
// Generate Json code to provide
$submitJson = '{
    "data": [
        {
            "action_source": "website",
            "event_name": [
                "ViewContent",
                "Search",
                "AddToCart",
                "Purchase",
                "Subscribe",
                "Lead",
                "Download",
                "SignUp",
                "Contact",
                "Custom",
                "PageView"
            ],
            "event_time": ' . time() . ',
            "event_source_url": "' . $actual_link . '",
            "user_data": {
                "client_ip_address": "' . $user_ip . '",
                "client_user_agent": "' . $_SERVER['HTTP_USER_AGENT'] . '"
            }
        }
    ]
}';

// ------------------------------------------------
// Set the Facebook Conversions API URL
$url = "https://graph.facebook.com/v12.0/{554061686441388}/events";

// ------------------------------------------------
// Use cURL to send the POST request
include './curl.class.php';
$_curl_ = new CurlServer();
$_curl_->post_request($url, $submitJson);