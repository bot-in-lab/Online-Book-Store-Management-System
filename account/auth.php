<?php

session_start();

if (isset($_POST['email']) && isset($_POST['password'])) {

    include "../db_conn.php";

    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM admin WHERE email=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$email]);

    if ($stmt->rowCount() === 1) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        $ad_id = $user['ad_id'];
        $ad_email = $user['email'];
        $ad_password = $user['password'];

        if ($email === $ad_email){
            if (password_verify($password, $ad_password)) {
                $_SESSION['ad_id'] = $ad_id;
                $_SESSION['ad_email'] = $ad_email;
                header("Location: ../admin_panel/admin_panel.php");
                exit();
            } else {
                $ms = "error";
                header("Location: login.php?error=Incorrect password");
                exit();
            }
        }
    } else {
        $sql = "SELECT * FROM customer WHERE email=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$email]);

        if ($stmt->rowCount() === 1) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            $c_id = $user['c_id'];
            $c_email = $user['email'];
            $c_password = $user['password'];

            if ($email === $c_email){
                if (password_verify($password, $c_password)) {
                    $_SESSION['c_id'] = $c_id;
                    $_SESSION['c_email'] = $c_email;
                    header("Location: ../index.php");
                    exit();
                } else {
                    $ms = "error";
                    header("Location: login.php?error=Incorrect password");
                    exit();
                }
            }
        } else {
            header("Location: login.php?error=No account found with that email");
            exit();
        }
    }
} else {
    header("Location: login.php");
    exit();
}
?>
