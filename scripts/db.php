<?php
/**
 * Created by PhpStorm.
 * User: mhabib
 * Date: 3/22/2017
 * Time: 3:12 PM
 */

include 'config.php';

$conn = mysqli_connect($host,$username,$password);

if(!$conn){
    echo "Connection Failed!";
    die("Connection Failed".mysqli_connect_error());
}else{
    echo "Connected Succesfully";
}
