<?php
$link = mysqli_connect("localhost", "root", "password", "ghub"); 
if (mysqli_connect_errno()){
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}