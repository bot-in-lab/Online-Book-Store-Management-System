<?php
session_start();
include '../db_conn.php';

if (!isset($_SESSION['c_id'])) {
    header("Location: login.php");
    exit();
}

$c_id = $_SESSION['c_id'];

if (isset($_GET['b_id'])) {
    $b_id = $_GET['b_id'];

    try {
        $check_sql = "SELECT * FROM rent WHERE b_id = :b_id AND c_id = :c_id";
        $stmt_check = $conn->prepare($check_sql);
        $stmt_check->bindParam(':b_id', $b_id, PDO::PARAM_INT);
        $stmt_check->bindParam(':c_id', $c_id, PDO::PARAM_INT);
        $stmt_check->execute();

        if ($stmt_check->rowCount() == 1) {
            $renew_sql = "UPDATE rent SET return_date = DATE_ADD(return_date, INTERVAL 1 WEEK) 
                          WHERE b_id = :b_id AND c_id = :c_id";
            $stmt_renew = $conn->prepare($renew_sql);
            $stmt_renew->bindParam(':b_id', $b_id, PDO::PARAM_INT);
            $stmt_renew->bindParam(':c_id', $c_id, PDO::PARAM_INT);
            $stmt_renew->execute();

            header("Location: rent.php?msg=You have successfylly renewed the book.");
            exit();
        } else {
            echo "<p class='alert alert-danger'>Invalid request. You cannot renew a book you haven't rented.</p>";
        }
    } catch (PDOException $e) {
        echo "<p class='alert alert-danger'>Error: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p class='alert alert-danger'>No book selected for renewal.</p>";
}
?>
