<?php
session_start();

if (isset($_SESSION['ad_id']) && isset($_SESSION['ad_email'])) {
    include "../../../db_conn.php";

    if (isset($_GET['b_id'])) {
        $book_id = $_GET['b_id'];

        $sql = "SELECT cover, file FROM book WHERE b_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$book_id]);
        $book = $stmt->fetch();

        if ($book) {
            $cover_path = "../../../uploads/cover/" . $book['cover'];
            $file_path = "../../../uploads/file/" . $book['file'];

            if (file_exists($cover_path)) {
                unlink($cover_path);
            }

            if (file_exists($file_path)) {
                unlink($file_path);
            }

            try {
                $sql = "DELETE FROM book WHERE b_id = ?";
                $stmt = $conn->prepare($sql);
                $result = $stmt->execute([$book_id]);

                if ($result) {
                    header("Location: ../../admin_panel.php?msg=Book and associated files deleted successfully");
                }
            } catch (PDOException $e) {
                if ($e->getCode() == 23000) {
                    header("Location: ../../admin_panel.php?error=Cannot delete book. It is referenced in another table (e.g., awards).");
                } else {
                    header("Location: ../../admin_panel.php?error=Failed to delete the book due to a database error.");
                }
            }
        } else {
            header("Location: ../../admin_panel.php?error=Book not found");
        }
    } else {
        header("Location: ../../admin_panel.php?error=Invalid request");
    }
} else {
    header("Location: ../../../account/login.php");
    exit;
}
?>
