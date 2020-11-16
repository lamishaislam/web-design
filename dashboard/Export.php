<?php

session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("location: ../index.php");
}

include "../config.php";
error_reporting(0);

if (isset($_POST["export"])) {

    $name1 = $_POST['name1'];
    $number1 = $_POST['number1'];
    $address = $_POST['address'];
    $Bid = $_POST['Bid'];

    $details = '';

    
    





    foreach ($_SESSION["shopping_cart"] as &$product) {


       
        $details .= $product["name"];
        $details .= '-';
        $details .= '\t';
        $details .= $product["quantity"];
        $details .= '-';
        $details .= '\t';
        $details .=  $product["price"] *  $product["quantity"];
        $details .= ',';
        $details .= '\n';




        $count += 1;
        $total_price += ($product["price"] * $product["quantity"]);
    }
    $details .=   'Total-';
    $details .=   $total_price;
    // $sql1 = "INSERT INTO customer VALUES(Null,'$name1','$number1','$Bid','$address','$details')";
    // mysqli_query($conn, $sql1);
    $sql1 = "INSERT INTO orderlist VALUES(Null,'$name1',' $number1','$details','$address','$Bid',NOW())";
    mysqli_query($conn, $sql1);

    foreach ($_SESSION["shopping_cart"] as &$value) {
        // update quantity
        $sql3 = "SELECT * FROM food WHERE id ='" . $value['id'] . "'";
        $result3 = mysqli_query($conn, $sql3);
        $row = $result3->fetch_assoc();
        $updateQuantity = $row['quantity'] - $value['quantity'];

        $sql4 = "UPDATE food SET quantity= $updateQuantity WHERE id ='" . $value['id'] . "'";
        $result4 = mysqli_query($conn, $sql4);
    }
    header("location: ./cart.php");

    mysqli_close($con);
}