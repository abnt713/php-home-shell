<?php

/**
 * Configuration
 *
 * For more info about constants please @see http://php.net/manual/en/function.define.php
 * If you want to know why we use "define" instead of "const" @see http://stackoverflow.com/q/2447791/1114320
 */

/**
 * Configuration for: Error reporting
 * Useful to show every little problem during development, but only show hard errors in production
 */
error_reporting(E_ALL);
ini_set("display_errors", 1);

/**
 * Configuration for: Project URL
 * Put your URL here, for local development "127.0.0.1" or "localhost" (plus sub-folder) is fine
 */
define('SERVER_ADDR', '127.0.0.1/nightingale/home-shell/');
define('HTTP_URL', 'http://' . SERVER_ADDR);
define('HTTPS_URL', 'http://' . SERVER_ADDR);

/**
 * Configuration for: Database
 * This is the place where you define your database credentials, database type etc.
 */
define('DB_TYPE', 'mysql');
//define('DB_HOST', './application/database/homeshell.sqlite3');
define('DB_HOST', 'localhost');

/* If you are using SQLite, set the values below as blank (or whatever, they will not be read)*/
define('DB_NAME', 'home-shell');
define('DB_USER', 'app');
define('DB_PASS', '123456abc');
