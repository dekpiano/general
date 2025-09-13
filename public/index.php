<?php

// Path to the front controller (this file)
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);

// Ensure the current directory is pointing to the front controller's directory
chdir(FCPATH);

/*
 *---------------------------------------------------------------
 * BOOTSTRAP THE APPLICATION
 *---------------------------------------------------------------
 * This process sets up the path constants, loads and registers
 * our autoloader, along with Composer's, loads our constants,
 * and fires up the global error handling.
 */

// Load ENVIRONMENT from .env file if not already set
if (! defined('ENVIRONMENT')) {
    if (file_exists(FCPATH . '../.env')) {
        require_once FCPATH . '../.env';
    }

    if (! defined('ENVIRONMENT')) {
        define('ENVIRONMENT', $_SERVER['CI_ENVIRONMENT'] ?? 'development');
    }
}

// Load the framework bootstrap file
require_once FCPATH . '../system/bootstrap.php';

/*
 *---------------------------------------------------------------
 * LAUNCH THE APPLICATION
 *---------------------------------------------------------------
 * Now that everything is setup, it's time to actually fire
 * up the engines and make this app do its thang.
 */
$app = \Config\Services::codeigniter();
$app->run();
