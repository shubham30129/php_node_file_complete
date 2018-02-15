<?php
/**
 * Created by PhpStorm.
 * User: lcom148-two
 * Date: 2/14/2018
 * Time: 5:21 PM
 */

session_start();
session_destroy();
header("location:login.php");
?>