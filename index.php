<?php

/**
 * Simple RESTful server for home management
 *
 * @package home-shell
 * @author Alison Bento
 * @license http://opensource.org/licenses/MIT MIT License
 */

// load the (optional) Composer auto-loader
if (file_exists('vendor/autoload.php')) {
    require 'vendor/autoload.php';
}

// load application config (error reporting etc.)
require 'application/config/config.php';
require 'application/config/hs.php';

// load application class
require 'application/libs/model.php';
require 'application/libs/homeshell/application/homeshellapplication.php';
require 'application/libs/homeshell/controller/homeshellcontroller.php';
require 'application/libs/homeshell/controller/homeshellsubcontroller.php';

// load utils
require 'application/src/utils/homeshellrequest.php';
require 'application/src/utils/urlhandler.php';
require 'application/src/res/getter/strres.php';

// load global functions
require 'application/src/global_functions.php';

// start the application
$app = new HomeShellApplication();
$app->runApp();
