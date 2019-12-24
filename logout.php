<?php
require "connection.php";
require "session.php";
use iot\connection\connection;
use session\session;

$sessionHandler = new session();
$initDb = connection::initDatabase();

if(!$sessionHandler->isRegistered()){
    header('Location: login.php');
    return;
}

$sessionHandler->end();

header('Location: /login.php');
?>