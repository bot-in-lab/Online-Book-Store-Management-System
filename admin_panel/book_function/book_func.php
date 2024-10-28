<?php

# Get All books with category names
function get_all_books($con) {
    $sql = "SELECT book.*, category.cat_name 
            FROM book 
            JOIN category ON book.cat_id = category.cat_id 
            ORDER BY b_id DESC";
            
    $stmt = $con->prepare($sql);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $books = $stmt->fetchAll();
    } else {
        $books = 0;
    }

    return $books;
}
?>
