<?php
session_start();

if (isset($_SESSION['ad_id']) && isset($_SESSION['ad_email'])) {
    include "../../db_conn.php";

    # Check if form fields are set
    if (isset($_POST['book_title']) && isset($_POST['award_description'])) {
        $book_id = $_POST['book_title'];
        $award_description = $_POST['award_description'];

        # Handle the checkboxes for the awards
        $best_rent = isset($_POST['best_rent']) ? 1 : 0;
        $popular = isset($_POST['popular']) ? 1 : 0;
        $award_winning = isset($_POST['award_winning']) ? 1 : 0;

        # Insert award into the 'award' table
        $sql = "INSERT INTO award (b_id, description, best_rent, popular, award_winning) 
                VALUES (?, ?, ?, ?, ?)
                ON DUPLICATE KEY UPDATE 
                description = VALUES(description),
                best_rent = VALUES(best_rent),
                popular = VALUES(popular),
                award_winning = VALUES(award_winning)";
                
        $stmt = $conn->prepare($sql);
        $res = $stmt->execute([$book_id, $award_description, $best_rent, $popular, $award_winning]);

        if ($res) {
            $sm = "Award successfully added!";
            header("Location: add_award.php?success=$sm");
            exit;
        } else {
            $em = "Unknown error occurred!";
            header("Location: add_award.php?error=$em");
            exit;
        }
    } else {
        $em = "All fields are required!";
        header("Location: add_award.php?error=$em");
        exit;
    }
} else {
    header("Location: ../../account/login.php");
    exit;
}
?>
