<?php

session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("location: ../index.php");
}

include "../config.php";
error_reporting(0);
if (isset($_POST['quantity'])) {
    foreach ($_SESSION["shopping_cart"] as &$value) {
        if ($value['id'] === $_POST["id"]) {
            $value['quantity'] = $_POST["quantity"];


            break; // Stop the loop after we've found the product
        }
    }
}
if (isset($_POST['remove'])) {
    foreach ($_SESSION["shopping_cart"] as $key => &$value) {
        if ($_POST["id"] == $value['id']) {
            unset($_SESSION["shopping_cart"][$key]);
        }
    }
}
if (isset($_POST['clear'])) {
    foreach ($_SESSION["shopping_cart"] as $key => &$value) {

        unset($_SESSION["shopping_cart"]);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>chef</title>
    <!-- icon -->
    
    <!-- bootstrap css -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <!-- zoom in animantion css -->
    <link href="../css/aos.min.css" rel="stylesheet">
    <!-- google font css-->
    <link href="../css/poppinsfont.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/exofont.min.css">
    <!-- iconfont css -->
    <link rel="stylesheet" href="../css/icofont/icofont.min.css">
    <!-- icons css css-->
    <link rel="stylesheet" href="../css/all.min.css">

    
    <!-- variable css -->
    <link rel="stylesheet" href="../css/variable1.min.css">

    <!-- sidebar css -->
    <link rel="stylesheet" href="../css/sidebar1.min.css">
    <!-- style css -->
    <link rel="stylesheet" href="../css/style.min.css">
    <!-- resposive css -->
    <link rel="stylesheet" href="../css/responsive.min.css">
</head>

<body>
    <!-- side bar -->

    <section>
        <div class="container d-flex align-items-center justify-content-around">

            <nav class="nav-menu d-none d-lg-block">
                <div class="logo text-center">
                    <span>Chef</span>
                </div>
                <hr>
                <?php
                include "./sidebar.php";
                ?>

            </nav>

        </div>


        <?php
        $id = $_SESSION['id'];

        $sql = "SELECT * FROM user WHERE id ='$id'";
        $result = mysqli_query($conn, $sql);
        while ($row = $result->fetch_assoc()) {

        ?>

        <!-- main body -->
        <main class="site-main main">
            <!-- incharge info area -->
            <div class="container info text-right">
                <div>
                    <p>
                        <?php
                            echo '<a class="test-popup-link" href="data:image/jpeg;base64,' . base64_encode($row['pic']) . '"><img src="data:image/jpeg;base64,' . base64_encode($row['pic']) . '"/></a>';
                            ?>
                        <?php echo "Welcome " . $_SESSION['name'] ?>
                    </p>

                    <hr>
                </div>
            </div>
            <?php

        }
            ?>

            <!-- cart -->



    </section>
    <?php
    $total_price = 0;
    ?>
    <section class="main">

        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 mx-auto text-right">
                    <form action="" method="POST"> <button class="btn btn-outline-danger text-uppercase" type="submit"
                            name="clear"><i class="fas fa-trash-alt"></i>
                            clear &nbsp; cart</button></form>
                </div>
            </div>
            <div class="table-responsive my-3">
                <table class="table text-capitalize table-hover table-bordered text-center">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>item</th>
                            <th>item name</th>
                            <th>quantity</th>
                            <th>unit price</th>
                            <th>total price</th>
                        </tr>
                    </thead>
                    <?php
                    $count = 1;
                    foreach ($_SESSION["shopping_cart"] as &$product) {
                    ?>
                    <tr>
                        <td><?php echo $count; ?></td>
                        <td>
                            <img src="data:image/jpeg;base64,<?php echo $product["image"]; ?>" alt="" width="50px"
                                height="40">
                        </td>
                        <td><?php echo $product["name"]; ?>
                            <form method='post' action=''>
                                <input type='hidden' name='id' value="<?php echo $product["id"]; ?>" />

                                <button type='submit' class='remove' name="remove" value="remove">Remove Item</button>
                            </form>
                        </td>
                        <td>
                            <form method='post' action=''>
                                <input type='hidden' name='id' value="<?php echo $product["id"]; ?>" />
                                <select name='quantity' class='quantity form-control' onChange="this.form.submit()">
                                    <?php
                                        $sql2 = "SELECT quantity FROM food WHERE id= '" . $product["id"] . "'";
                                        $result2 = mysqli_query($conn, $sql2);
                                        $row = $result2->fetch_assoc();
                                        $number = $row['quantity'];
                                        $i = 1;
                                        while ($i <= $number) {
                                        ?>

                                    <option <?php if ($product["quantity"] ==  $i) echo "selected"; ?>
                                        value="<?php echo $i; ?>">
                                        <?php echo $i; ?>
                                    </option>
                                    <?php
                                            $i += 1;
                                        }
                                        ?>
                                </select>
                            </form>
                        </td>
                        <td><?php echo '&#2547;&nbsp;' . $product["price"]; ?></td>
                        <td><?php echo '&#2547;&nbsp;' .  $product["price"] *  $product["quantity"]; ?></td>
                    </tr>
                    <?php
                        $count += 1;
                        $total_price += ($product["price"] * $product["quantity"]);
                    }
                    ?>
                    <tr class="bg-warning">

                        <td colspan="6">
                            <strong>TOTAL: <?php echo '&#2547;&nbsp;' . $total_price; ?></strong>
                        </td>
                    </tr>

                </table>

            </div>



            <form action="Export.php" method="POST">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12  text-center">
                        <p class="text-capitalize">customer info-
                        </p>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <label for="exampleInputPassword1"> Name <span>*</span></label>
                        <div class="input-group-prepend">
                            <span style="border:none;" class="input-group-text"><i class="fa fa-user"></i></span>
                            <input type="text" class="form-control" id="name1" name="name1" value='<?php echo $_SESSION["name"];?>'
                                required="">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <label for="exampleInputPassword1"> Cell Number <span>*</span></label>
                        <div class="input-group-prepend">
                            <span style="border:none;" class="input-group-text"><i class="fas fa-mobile-alt"></i></span>
                            <input type="text" class="form-control" id="number1" name="number1"
                                placeholder="01XXXXXXXXX" required="">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <label for="exampleInputPassword1">
                            Address<span>*</span>
                        </label>
                        <div class="input-group-prepend">
                            <span style="border:none;" class="input-group-text"><i
                                    class="fas fa-map-marked-alt"></i></span>
                            <input type="text" class="form-control" id="address" name="address"
                                placeholder="home address" required="">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <label for="exampleInputPassword1">
                            Customer Bid
                        </label>
                        <div class="input-group-prepend">
                            <span style="border:none;" class="input-group-text">&#2547;</span>
                            <input type="text" class="form-control" id="Bid" name="Bid"
                                placeholder="Customer Bid">
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 mx-auto text-center my-3"> <button
                            class="btn btn-danger text-uppercase" type="submit" name="export">
                            submit order</button> </div>
                </div>
            </form>


        </div>
    </section>


    <?php
    include './footer.php';
    ?>

    <!-- gotop -->
    <div class="container-fluid"><a class="gotop" href="#"><i class="fas fa-level-up-alt"></i></a></div>

    <script src="../js/jquery-3.5.1.min.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/jquery.easing.min.js"></script>
    <script type="text/javascript">
    window.addEventListener("scroll", function() {
        // var header = document.querySelector("section");
        // header.classList.toggle("sticky", window.scrollY > 0);
        var gotop = document.querySelector(".gotop");
        gotop.classList.toggle("gotopbutton", window.scrollY > 0);
    });
    $(function() {

        $('[data-toggle="tooltip"]').tooltip()
    });
    </script>
    <script src="../js/aos.min.js"></script>
    <script>
    AOS.init();
    </script>
    <script src="../js/owl.carousel.min.js"></script>
    <script src="../Magnific-Popup/dist/jquery.magnific-popup.min.js"></script>
    <script src="../js/header.min.js"></script>
    <script src="../js/alert.min.js"></script>
    <script src="../js/index.js"></script>
</body>

</html>