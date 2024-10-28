<?php
session_start();

# If the admin is logged in
if (isset($_SESSION['ad_id']) && isset($_SESSION['ad_email'])) {
    include "../../db_conn.php";

    # Check if all form fields are submitted
    if (isset($_POST['book_title']) && isset($_POST['book_author']) && 
        isset($_POST['book_description']) && isset($_POST['book_category']) &&
        isset($_FILES['book_cover']) && isset($_FILES['book_file'])) {

        $title = $_POST['book_title'];
        $author = $_POST['book_author'];
        $description = $_POST['book_description'];
        $category = $_POST['book_category']; // This should be the category ID

        # Directory paths
        $cover_dir = "../../uploads/cover/";
        $file_dir = "../../uploads/file/";

        # Handle book cover upload
        $cover_file = $cover_dir . basename($_FILES["book_cover"]["name"]);
        $coverFileType = strtolower(pathinfo($cover_file, PATHINFO_EXTENSION));

        # Handle book file upload
        $book_file = $file_dir . basename($_FILES["book_file"]["name"]);
        $bookFileType = strtolower(pathinfo($book_file, PATHINFO_EXTENSION));

        # Ensure the directories exist
        if (!is_dir($cover_dir)) {
            mkdir($cover_dir, 0777, true); // Create the directory if it doesn't exist
        }
        if (!is_dir($file_dir)) {
            mkdir($file_dir, 0777, true); // Create the directory if it doesn't exist
        }

        # Move uploaded files to target directories
        if (move_uploaded_file($_FILES["book_cover"]["tmp_name"], $cover_file) &&
            move_uploaded_file($_FILES["book_file"]["tmp_name"], $book_file)) {

            # Insert the book into the database with file paths
            $sql = "INSERT INTO book (b_title, author, description, cover, file, cat_id) 
                    VALUES (?, ?, ?, ?, ?, ?)";

            $stmt = $conn->prepare($sql);
            $res = $stmt->execute([$title, $author, $description, $cover_file, $book_file, $category]);

            if ($res) {
                $sm = "Book successfully added!";
                header("Location: add_book.php?success=$sm");
                exit;
            } else {
                $em = "Unknown error occurred!";
                header("Location: add_book.php?error=$em");
                exit;
            }

        } else {
            $em = "File upload failed!";
            header("Location: add_book.php?error=$em");
            exit;
        }

    } else {
        $em = "All fields are required!";
        header("Location: add_book.php?error=$em");
        exit;
    }
} else {
    header("Location: ../../../login.php");
    exit;
}
