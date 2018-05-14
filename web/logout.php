<?php
session_start();
session_unset();
$_SESSION['loggedIn'] = 0;
session_destroy();
