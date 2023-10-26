<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);
ini_set('session.cookie_httponly', 1);

return [

    'URL' => 'https://' . $_SERVER['HTTP_HOST'] . str_replace('public', '', dirname($_SERVER['SCRIPT_NAME'])),
    'PATH_CONTROLLER' => realpath(dirname(__FILE__).'/../../') . '/src/Http/Controllers/',
    'PATH_VIEW' => realpath(dirname(__FILE__).'/../../') . '/src/view/',
    'DEFAULT_CONTROLLER' => 'index',
    'DEFAULT_ACTION' => 'index',
    'ENCRYPTION_KEY' => '6#x0gÊìf^25cL1f$08&',
    'HMAC_SALT' => '8qk9c^4L6d#15tM8z7n0%',

    'DB_TYPE' => 'mysql',
    'DB_HOST' => '',
    'DB_NAME' => '',
    'DB_USER' => '',
    'DB_PASS' => '',
    'DB_PORT' => '',
    'DB_CHARSET' => 'utf8',

    'COOKIE_RUNTIME' => 1209600,
    'COOKIE_PATH' => '/',
    'COOKIE_DOMAIN' => "",
    'COOKIE_SECURE' => false,
    'COOKIE_HTTP' => true,
    'SESSION_RUNTIME' => 604800,

    'EMAIL_USED_MAILER' => 'phpmailer',
    'EMAIL_USE_SMTP' => false,

    'EMAIL_SMTP_HOST' => 'yourhost',
    'EMAIL_SMTP_AUTH' => true,
    'EMAIL_SMTP_USERNAME' => 'yourusername',
    'EMAIL_SMTP_PASSWORD' => 'yourpassword',
    'EMAIL_SMTP_PORT' => 465,
    'EMAIL_SMTP_ENCRYPTION' => 'ssl',

    'EMAIL_PASSWORD_RESET_URL' => 'login/verifypasswordreset',
    'EMAIL_PASSWORD_RESET_FROM_EMAIL' => 'no-reply@example.com',
    'EMAIL_PASSWORD_RESET_FROM_NAME' => 'My Project',
    'EMAIL_PASSWORD_RESET_SUBJECT' => 'Password reset for PROJECT XY',
    'EMAIL_PASSWORD_RESET_CONTENT' => 'Please click on this link to reset your password: ',
    'EMAIL_VERIFICATION_URL' => 'register/verify',
    'EMAIL_VERIFICATION_FROM_EMAIL' => 'no-reply@example.com',
    'EMAIL_VERIFICATION_FROM_NAME' => 'My Project',
    'EMAIL_VERIFICATION_SUBJECT' => 'Account activation for PROJECT XY',
    'EMAIL_VERIFICATION_CONTENT' => 'Please click on this link to activate your account: ',
];
