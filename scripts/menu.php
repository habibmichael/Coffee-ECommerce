<?php

include "db.php";
$query = "SELECT display_name,price,size FROM products";
$result = mysqli_query($conn,$query);

?>


<html>
<head>
    <title>Home</title>
    <meta charset="utf-8">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
          rel="stylesheet">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.css">
</head>
<body>
<div class="container">
    <nav class="navbar navbar-toggleable-md navbar-inverse bg-inverse">
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="#">Tsarbucks</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Menu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link">My Orders</a>
                </li>
                <li class="nav-item">
                    <p class="navbar-text">Welcome, Customer!</p>
                </li>
                <li class="nav-item">
                    <a class="nav-link">My Cart</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link">Logout</a>
                </li>
            </ul>
        </div>
    </nav>
    <h1>Menu</h1>
    <table class="table">
        <th>Product Name</th>
        <th>Price</th>
        <th>Size(oz)</th>
    </table>










</div>
<script src="../scripts/jquery-3.2.0.js"></script>
<script src="../tether-1.3.3/dist/js/tether.min.js"></script>
<script src="../bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
