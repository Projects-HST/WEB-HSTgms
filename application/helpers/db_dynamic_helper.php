<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
function switch_maindb($name_db)
{
    $config_app['hostname'] = 'localhost';
    $config_app['username'] = 'root';
    $config_app['password'] = 'O+E7vVgBr#{}';
    $config_app['database'] = $name_db;
    $config_app['dbdriver'] = 'mysqli';
    $config_app['dbprefix'] = '';
    $config_app['pconnect'] = FALSE;
    $config_app['db_debug'] = TRUE;
    return $config_app;
}