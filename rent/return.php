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
        $check_sql = "SELECT * FROM rent WHERE c_id = :c_id AND b_id = :b_id";
        $stmt_check = $conn->prepare($check_sql);
        $stmt_check->bindParam(':c_id', $c_id, PDO::PARAM_INT);
        $stmt_check->bindParam(':b_id', $b_id, PDO::PARAM_INT);
        $stmt_check->execute();

        if ($stmt_check->rowCount() == 1) {
            $sql_return = "DELETE FROM rent WHERE c_id = :c_id AND b_id = :b_id";
            $stmt_return = $conn->prepare($sql_return);
            $stmt_return->bindParam(':c_id', $c_id, PDO::PARAM_INT);
            $stmt_return->bindParam(':b_id', $b_id, PDO::PARAM_INT);
            $stmt_return->execute();

            header("Location: rent.php");
            exit();
        } else {
            header("Location: rent.php?error=You cannot return a book you haven't rented.");
        }
    } catch (PDOException $e) {
        echo "<p class='alert alert-danger'>Error: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p class='alert alert-danger'>No book selected for return.</p>";
}
?>
