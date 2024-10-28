<?php
session_start();

if (isset($_SESSION['ad_id']) && isset($_SESSION['ad_email'])) {
    include "../../../db_conn.php";

    if (isset($_GET['cat_id'])) {
        $cat_id = $_GET['cat_id'];

        $sql = "SELECT * FROM category WHERE cat_id = :cat_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':cat_id', $cat_id, PDO::PARAM_INT);
        $stmt->execute();
        $category = $stmt->fetch();

        if ($category) {
            try {
                $sql = "DELETE FROM category WHERE cat_id = :cat_id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':cat_id', $cat_id, PDO::PARAM_INT);
                $stmt->execute();

                header("Location: ../add_category.php?success=Category deleted successfully");
                exit;

            } catch (PDOException $e) {
                if ($e->getCode() == 23000) {
                    header("Location: ../add_category.php?error=Cannot delete category. It is associated with one or more books.");
                    exit;
                } else {
                    header("Location: ../add_category.php?error=Failed to delete category due to a database error.");
                    exit;
                }
            }

        } else {
            header("Location: ../add_category.php?error=Category not found");
            exit;
        }
    } else {
        header("Location: ../add_category.php?error=No category selected");
        exit;
    }
} else {
    header("Location: ../../../account/login.php");
    exit;
}
?>
