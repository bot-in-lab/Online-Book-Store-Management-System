<?php
include "db_conn.php"; // Include your database connection

// Check if the search query is set
$search_query = '';
$books = [];

if (isset($_GET['query'])) {
    $search_query = $_GET['query'];

    // Fetch books from the database based on the search query (title, author, or category)
    $sql = "SELECT book.*, category.cat_name 
            FROM book 
            LEFT JOIN category ON book.cat_id = category.cat_id 
            WHERE b_title LIKE ? OR author LIKE ? OR cat_name LIKE ?";
    $stmt = $conn->prepare($sql);
    $search_term = '%' . $search_query . '%';
    $stmt->execute([$search_term, $search_term, $search_term]);
    $books = $stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Store</title>

    <!-- Bootstrap CDN 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Bootstrap CDN 5.3 Js Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<!-- Link to the external CSS file -->
<link rel="stylesheet" href="css/style.css">

</head>
<body>

    <div class="container">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">
                    <img src="image/logo.png" alt="Online Book Store">
                </a>

                <form class="d-flex search-bar" action="search.php" method="GET">
                    <input class="form-control me-2" type="search" name="query" placeholder="Enter Book Title, Author, or Category" aria-label="Search">
                    <button class="btn search-button" type="submit">Search</button>
                </form>

                <div class="navbar-text">
                    <div class="phone-section">
                        <img src="image/phone.png" alt="Phone Icon">
                        <span class="phone-number">Hotline <br> 017xxxxxxx</span>
                    </div>

                    <div class="icon-section">
                        <a href="rent/rent.php"><img src="image/rent.png" alt="Rent"></a>
                        <a href="account/login.php"><img src="image/login.png" alt ="Log in"></a>
                    </div>
                </div>
            </div>
        </nav>

        <br>
        <h2>Search Results</h2>

        <?php if (!empty($search_query)) { ?>
            <p><strong><?= htmlspecialchars($search_query) ?></strong></p>
        <?php } ?>

        <?php if (empty($books)) { ?>
            <p>No books found matching your search.</p>
        <?php } else { ?>
            <div class="row">
                <?php foreach ($books as $book) { ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <img src="uploads/cover/<?= htmlspecialchars($book['cover']) ?>" class="card-img-top" alt="Book Cover">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($book['b_title']) ?></h5>
                                <h6 class="card-text">By: <?= htmlspecialchars($book['author']) ?></h6>
                                <p class="card-text"><?= htmlspecialchars($book['description']) ?></p>
                                <p class="card-text">Category: <?= htmlspecialchars($book['cat_name']) ?></p>
                                <a href="rent.php?book_id=<?= htmlspecialchars($book['b_id']) ?>" class="btn btn-rent">Rent Book</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
    </div>

</body>
</html>
