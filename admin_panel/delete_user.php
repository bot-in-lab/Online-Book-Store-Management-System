<?php
session_start();

if (isset($_SESSION['ad_id']) && isset($_SESSION['ad_email'])) {
    
    if (isset($_GET['user_id'])) {
        $user_id = $_GET['user_id'];

        include "../db_conn.php";

        $sql = "DELETE FROM customer WHERE c_id = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt->execute([$user_id])) {
           header("Location: user_list.php?success=User deleted successfully");
        } else {
            header("Location: user_list.php?error=Failed to delete user");
        }

    } else {
        header("Location: user_list.php?error=Invalid user ID");
    }

} else {
    header("Location: ../account/login.php");
    exit;
}
