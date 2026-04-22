<?php

/**
 * CodeIgniter 4.7 Preload File
 */

// Path to the front controller
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR);

// Ensure we are in the right directory
chdir(__DIR__);

// Load the framework bootstrapper
require __DIR__ . '/vendor/codeigniter4/framework/system/Boot.php';

use CodeIgniter\Boot;
use Config\Paths;

// Load Paths object correctly
require __DIR__ . '/app/Config/Paths.php';
$paths = new Paths();

// Use Paths object as required by CI 4.7
Boot::preload($paths);
