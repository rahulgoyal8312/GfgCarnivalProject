<?php
include_once "./config.php";
session_start();
session_unset();
header("Location: ".HOST_URL);