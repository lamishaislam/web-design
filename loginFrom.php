<?php
require_once "./config.php";

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name1 = trim($_POST['name']);
    $password1 = trim($_POST['password']);
   






    $sql = "SELECT * FROM  user";
    $result = mysqli_query($conn, $sql);
    $flag = 0;
    while ($row = $result->fetch_assoc()) {

        $name = $row['name'];
        $password = $row['pass'];
        $id = $row['id'];

        if ($name1 == $name) {
            if ($password1 == $password) {
               
                    $flag = 1;
                    break;
                
                   
                
            } else {
                $response['error'] = true;
                $response['msg']   = "Password is Wrong!";
            }
        } else {
            $response['error'] = true;
            $response['msg']   = "User Name does not Exit!";
        }
    }

    if ($flag == 1) {
        $response['error'] = false;
        $response['msg']   = "Log In Successfull";
        session_start();
        $_SESSION["name"] = $name;
        $_SESSION["name1"] = $name1;
        $_SESSION["login"] = true;
        $_SESSION["id"] = $id;
    }
    echo json_encode($response);
}