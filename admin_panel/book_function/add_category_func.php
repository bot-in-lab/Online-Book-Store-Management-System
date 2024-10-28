<?php

session_start();

# If the admin is logged in
if (isset($_SESSION['ad_id']) && isset($_SESSION['ad_email'])) {

    include "../../db_conn.php";

    # Check if category name is submitted
    if (isset($_POST['category_name'])){
        $name = trim($_POST['category_name']); // Trim spaces to avoid issues with extra spaces

        # Check if the category already exists
        $check_sql = "SELECT * FROM category WHERE cat_name = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->execute([$name]);
        
        if ($check_stmt->rowCount() > 0) {
            # Category already exists
            $em = "Category name already exists!";
            header("Location: add_category.php?error=$em");
            exit;
        } else {
            # Insert new category
            $sql = "INSERT INTO category (cat_name) VALUES (?)";
            $stmt = $conn->prepare($sql);
            $res = $stmt->execute([$name]);
            
            if ($res) {
                # Success message
                $sm = "Category successfully added!";
                header("Location: add_category.php?success=$sm");
                exit;
            } else {
                # Error message in case of query failure
                $em = "An unknown error occurred!";
                header("Location: add_category.php?error=$em");
                exit;
            }
        }
    } else {
        header("Location: ../admin_panel.php");
        exit;
    }

} else {
    header("Location: ../../account/login.php");
    exit;
}
?>
