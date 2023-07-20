<?php

require 'function.php';

if(isset($_SESSION['login'])){
    // dilakukan
}else{
    // tidak dilakukan
    header('location: login.php');
}
?>
