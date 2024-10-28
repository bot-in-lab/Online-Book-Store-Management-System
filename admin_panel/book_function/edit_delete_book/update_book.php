<?php
session_start();

if (isset($_SESSION['ad_id']) && isset($_SESSION['ad_email'])) {
    include "../../../db_conn.php";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $b_id = $_POST['b_id'];
        $b_title = $_POST['b_title'];
        $author = $_POST['author'];
        $description = $_POST['description'];
        $category = $_POST['category'];

        $cover = null;
        $file = null;

        if (isset($_FILES['cover']) && $_FILES['cover']['error'] === UPLOAD_ERR_OK) {
            $coverTmpName = $_FILES['cover']['tmp_name'];
            $coverName = time() . "_" . $_FILES['cover']['name'];
            $coverPath = "../../../uploads/cover/" . $coverName;
            move_uploaded_file($coverTmpName, $coverPath);
            $cover = $coverName;
        }

        if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
            $fileTmpName = $_FILES['file']['tmp_name'];
            $fileName = time() . "_" . $_FILES['file']['name'];
            $filePath = "../../../uploads/file/" . $fileName;
            move_uploaded_file($fileTmpName, $filePath);
            $file = $fileName;
        }

        // Update the book record
        $sql = "UPDATE book 
                SET b_title = ?, author = ?, description = ?, cat_id = ?" . 
                ($cover ? ", cover = ?" : "") . 
                ($file ? ", file = ?" : "") . " 
                WHERE b_id = ?";

        $params = [$b_title, $author, $description, $category];
        if ($cover) $params[] = $cover;
        if ($file) $params[] = $file;
        $params[] = $b_id;

        $stmt = $conn->prepare($sql);
        $stmt->execute($params);

        header("Location: ../../admin_panel.php");
        exit;
    }
} else {
    header("Location: ../../../account/login.php");
    exit;
}
?>
