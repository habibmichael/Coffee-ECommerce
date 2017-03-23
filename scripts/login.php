<?php
/**
 * Created by PhpStorm.
 * User: mhabib
 * Date: 3/22/2017
 * Time: 9:16 AM
 */

include "db.php";

$data = $_POST;

$user = $data['username'];
$pw = $data['password'];

$query = "SELECT username,password,display_name FROM users WHERE username='$user' AND password='$pw'";
//echo $query;

$result = mysqli_query($conn,$query);
$authenticated=false;
$row = null;

if($result) {
    $row = mysqli_fetch_array($result);
    //echo sizeof($row);
    if (sizeof($row) > 0) {
        $authenticated = true;
    }
}
if ($authenticated){
    if($row['display_name']=='Barista'){
        header("Location:../public/barista-home.html");
        exit();
    }else if($row['display_name']=='Customer'){
        header("Location: ../public/customer-home.html");
        exit();
    }

}else{
    header("Location: ../public/login.html");
    exit();
}

mysqli_close($conn);


