<?php

session_start();

if (isset($_SESSION['login'])) {
    header("location: ./dashboard/");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>freelance-chef</title>
    <!-- icon -->
    <link rel="icon" href="./img/chef.png">
    <!-- bootstrap css -->
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <!-- google font css-->
    <link href="./css/poppinsfont.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/exofont.min.css">
    <!-- icons css css-->
    <link rel="stylesheet" href="./css/all.min.css">
    <!-- iconfont css -->
    <link rel="stylesheet" href="./css/icofont/icofont.min.css">
    <!-- variable css -->
    <link rel="stylesheet" href="./css/variable1.min.css">

    <!-- style css -->
    <link rel="stylesheet" href="./css/style.min.css">
    <!-- resposive css -->
    <link rel="stylesheet" href="./css/responsive.min.css">
    
</head>

<body class="login-body">
    <main class="site-main">

        <!-- incharge login area -->
        <section class="login-area d-flex align-items-center" id="login">
            <div class="container">
                <div class="row my-3">
                    <div class=" col-lg-12 col-md-12  my-auto text-right">
                        
                    </div>
                </div>
                <div class="row my-5">
                    <div class="col-lg-6 col-md-6 mx-auto my-auto text-center">
                    <p class="section-title  text-uppercase"><span>freelance chef</span>
                        </p>
                        <!-- <hr style="background: white;"> -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-4 mx-auto my-auto text-center">
                        <p class="section-title  text-uppercase"><span>sign in</span>
                        </p>
                    </div>
                </div>

                <div class="row my-5">
                    <!-- form area -->
                    <div class="col-lg-4 col-md-4 col-sm-12 form-area mx-auto">
                        <form action="" method="POST" class="login-form">
                            <div class="form-group">
                                <label for="exampleInputPassword1"> User Name -</label>
                                <div class="input-group-prepend">
                                    <span style="border:none;" class="input-group-text"><i
                                            class="far fa-envelope-open"></i></span>
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="user name" required="">
                                </div>
                                <label for="exampleInputPassword1"> Password -</label>
                                <div class="input-group-prepend">
                                    <span style="border:none;" class="input-group-text"><i
                                            class="fas fa-unlock-alt"></i></span>
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Enter Your Password" required="">
                                </div>


                            </div>
                            <div class="text-center">
                                <button class="btn btn-warning text-uppercase" type="button" name="sendmsg"
                                    id="registerButton">sign in
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
            </div>

        </section>

    </main>

    <?php
    include './footer.php';
    ?>

    <!-- gotop -->
    <div class="container-fluid"><a class="gotop" href="#"><i class="fas fa-level-up-alt"></i></a></div>

    <script src="./js/jquery-3.5.1.min.js"></script>
    <script src="./js/popper.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script src="./js/jquery.easing.min.js"></script>
    <script type="text/javascript">
    window.addEventListener("scroll", function() {

        var gotop = document.querySelector(".gotop");
        gotop.classList.toggle("gotopbutton", window.scrollY > 0);
    });
    $(function() {

        $('[data-toggle="tooltip"]').tooltip()
    });
    </script>
    
    <script src="./js/alert.min.js"></script>
    <Script>
    $("#registerButton").click(function() {
        var name = $("#name").val();
        var password = $("#password").val();

        if (name == "" || password == "") {
            swal.fire("Error!", "Info Missing", "error");
        } else {
            swal.fire("Processing", "", "warning");

            $.ajax({
                type: "POST",
                url: 'loginFrom.php',
                data: $('.login-form').serialize(),
                dataType: "JSON",
                success: function(data) {
                    if (data.error) {
                        swal.fire("Error!", data.msg, "error");
                    } else {
                        swal.fire("success!", data.msg, "success").then(okay => {
                            if (okay) {
                                window.location.replace("./dashboard/");
                            }
                        });
                       
                    }
                }

            });
        }
    });
    </Script>
</body>

</html>