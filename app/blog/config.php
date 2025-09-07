<?php

$app_config = array();

$app_config['APP_CONFIG_TIMEZONE'] = 'Europe/Moscow'; 
$app_config['APP_CONFIG_ERROR_DETAIL'] = true;
$app_config['APP_CONFIG_ERROR_IGNORE'] = 'E_NOTICE, E_USER_NOTICE, E_DEPRECATED, E_USER_DEPRECATED';
$app_config['APP_CONFIG_ERROR_LOG'] = true;
$app_config['APP_CONFIG_ERROR_LOG_FILE'] = APP_PATH.DS.'core.log';

foreach ($app_config as $const => $value) {
    if (! defined($const)) {
        define($const, $value);
    }
}

