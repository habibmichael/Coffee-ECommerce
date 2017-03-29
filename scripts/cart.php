<?php
session_start();
if(($_SESSION['username']=='' &&!($_SESSION['login']))|| $_SESSION['username']=='Barista'){
    header("Location: ../public/login.html");
}

include "db.php";
$query = "SELECT cart.order_id,products.product_id,products.display_name,products.price, products.size FROM products RIGHT JOIN cart 
          ON products.product_id=cart.product_id";
$result = mysqli_query($conn,$query);
//if(!$result){
//
//    printf("Error %s\n",mysqli_error($conn));
//}
//else{
//    printf("All good!");
//}

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
            <a class="navbar-brand" href="../public/customer-home.php">Tsarbucks</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="../public/customer-home.php">Home<span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="menu.php">Menu</a>
                    </li>
                    <li class="nav-item">
                        <a href="customerOrders.php" class="nav-link">My Orders</a>
                    </li>
                    <li class="nav-item">
                        <p class="navbar-text">Welcome, Customer!</p>
                    </li>
                    <li class="nav-item active">
                        <a href="#"class="nav-link">My Cart</a>
                    </li>
                    <li class="nav-item">
                        <a href="logout.php" class="nav-link">Logout</a>
                    </li>
                </ul>
            </div>
        </nav>
        <h1>My Cart</h1>
        <table id="cart-table" class="table">
            <th>Product Name</th>
            <th>Price</th>
            <th>Size(oz)</th>
            <th></th>

            <?php
            $totalCost =0;
            $totalSize=0;
            $i=0;
            while($row=mysqli_fetch_array($result)){
                $totalCost+=$row['price'];
                $totalSize+=$row['size'];
                echo "<tr>";
                echo "<td>".$row['display_name']."</td>";
                echo "<td>$".$row['price']."</td>";
                echo "<td>".$row['size']."</td>";
                echo "<td><button id=".$row['product_id']." class='btn btn-danger'>Remove From Cart</button></td>";
                echo "</tr>";

            }
            $totalCost=number_format((float)$totalCost, 2, '.', '');

            ?>



        </table>
        <div class="row">
            <div class="col-md-3">
                <h3 id="total-cost">Total Cost: $<?php echo $totalCost ?> </h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <h3 id="total-size">Total Size: <?php echo $totalSize ?> oz</h3>
            </div>
        </div>
        <form method="post" action="submitOrder.php">
            <button  id="submit-order" type="submit" class="form-control btn btn-primary">Submit Order</button>
        </form>










    </div>
    <script src="../scripts/jquery-3.2.0.js"></script>
    <script src="../tether-1.3.3/dist/js/tether.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <script>

        $td= $("table").find("td");
        $submitButton = $("#submit-order");
        if($td.length==0){
            $("#total-cost").hide();
            $("#total-size").hide();
            $("table").hide();
            $submitButton.hide();
        }




        $(".btn-danger").click(function () {
            var id = this.id;
            var $tr = $(this).closest("tr");
            $.ajax({
                url:'updateCart.php',
                data:{
                    id:id,
                    op:"del"
                },
                type:'post',
                success: function(res){
                    $tr.find("td").fadeOut(750,function(){
                        $tr.remove();
                    });

                }

            });
        });

        $submitButton.click(function(){
            $.ajax({
                url:'submitOrder.php'
            });
        });


    </script>
    </body>
</html>
