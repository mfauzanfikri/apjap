<?php
session_start();

require_once '../dashboard/utils/utils.php';

session_destroy();

redirect('../login.php');
