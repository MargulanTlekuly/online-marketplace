<?php
require_once 'includes/functions.php';
$_SESSION = [];
session_destroy();
redirectTo('login.php?loggedout=1');
