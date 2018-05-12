<?php
session_start();
unset($_SESSION["user"]);
session_destroy(); //清空以创建的所有SESSION
header("Location: ../homepage.php");

