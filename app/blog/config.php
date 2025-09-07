<?php

$app_config = array();

$app_config['APP_CONFIG_TIMEZONE'] = 'Europe/Moscow'; 


foreach ($app_config as $const => $value) {
    if (! defined($const)) {
        define($const, $value);
    }
}
