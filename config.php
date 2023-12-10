<?php
$web_address = 'healthylife';
$protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://';
$domain = $protocol . $_SERVER['SERVER_NAME'] . '/' . $web_address . '/';
$config = array(
    'db_host' => 'localhost',
    'db_username' => 'root',
    'db_password' => '',
    'db_name' => 'healthylife',
);

$routing = array(
    'base_url' => $domain,
    'diet_record' => $domain . 'view/diet_record.php',
    'person_data' => $domain . 'view/person_data.php',
    'login' => $domain . 'view/login.php',
);
