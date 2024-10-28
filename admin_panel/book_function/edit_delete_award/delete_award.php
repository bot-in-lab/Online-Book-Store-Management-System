<?php
session_start();

if (isset($_SESSION['ad_id']) && isset($_SESSION['ad_email'])) {
    include "../../../db_conn.php";

    // Check if 'b_id' is set in the URL (GET method)
    if (isset($_GET['b_id'])) {
        $b_id = $_GET['b_id'];

        $sql = "DELETE FROM award WHERE b_id = :b_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':b_id', $b_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            header("Location: ../add_award.php?success=Award deleted successfully");
            exit;
        } else {
            header("Location: ../add_award.php?error=Failed to delete the award");
            exit;
        }
    } else {
        header("Location: ../add_award.php?error=No award ID provided");
        exit;
    }
} else {
    header("Location: ../../../account/login.php");
    exit;
}
?>
