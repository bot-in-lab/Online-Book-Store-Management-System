<?php
session_start();

# If the admin is logged in
if (isset($_SESSION['ad_id']) && isset($_SESSION['ad_email'])) {
    include "../../../db_conn.php";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $b_id = $_POST['b_id'];
        $description = $_POST['description'];
        $best_rent = isset($_POST['best_rent']) ? 1 : 0;
        $popular = isset($_POST['popular']) ? 1 : 0;
        $award_winning = isset($_POST['award_winning']) ? 1 : 0;

        // Update the award details
        $sql = "UPDATE award 
                SET description = :description, best_rent = :best_rent, 
                    popular = :popular, award_winning = :award_winning 
                WHERE b_id = :b_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':best_rent', $best_rent);
        $stmt->bindParam(':popular', $popular);
        $stmt->bindParam(':award_winning', $award_winning);
        $stmt->bindParam(':b_id', $b_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            header("Location: ../add_award.php?b_id=$b_id&success=Award updated successfully");
            exit;
        } else {
            header("Location: ../add_award.php?b_id=$b_id&error=Failed to update award");
            exit;
        }
    } else {
        header("Location: ../../../account/login.php");
        exit;
    }
}