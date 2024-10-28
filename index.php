<?php
include "db_conn.php";

$sql_categories = "SELECT * FROM category";
$stmt_categories = $conn->prepare($sql_categories);
$stmt_categories->execute();
$categories = $stmt_categories->fetchAll(PDO::FETCH_ASSOC);

$awards = [
    'Best Rent' => 'best_rent',
    'Popular' => 'popular',
    'Award Winning' => 'award_winning'
];

$sql_books = "SELECT book.*, category.cat_name, award.best_rent, award.popular, award.award_winning
              FROM book 
              JOIN category ON book.cat_id = category.cat_id
              LEFT JOIN award ON book.b_id = award.b_id";

if (isset($_GET['cat_id'])) {
    $sql_books .= " WHERE category.cat_id = :cat_id";
} elseif (isset($_GET['award'])) {
    $award_filter = $_GET['award'];
    $sql_books .= " WHERE award.$award_filter = 1";
}

$stmt_books = $conn->prepare($sql_books);

if (isset($_GET['cat_id'])) {
    $stmt_books->bindParam(':cat_id', $_GET['cat_id'], PDO::PARAM_INT);
}

$stmt_books->execute();
$books = $stmt_books->fetchAll(PDO::FETCH_ASSOC);
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
                    <input class="form-control me-2" type="search" name="query" placeholder="Enter Book Title, Author, or Category" aria-label="Search" required>
                    <button class="btn search-button" type="submit">Search</button>
                </form>

                <div class="navbar-text">
                    <div class="phone-section">
                        <img src="image/phone.png" alt="Phone Icon">
                        <span class="phone-number">Hotline <br> 017xxxxxxx</span>
                    </div>

                    <div class="icon-section">
                        <a href="rent/rent.php"><img src="image/rent.png" alt="Rent"></a>
                        <a href="account/login.php"><img src="image/login.png" alt="Log in"></a>
                    </div>
                </div>
            </div>
        </nav>

        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Categories
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="index.php">All Categories</a></li>
                <?php foreach ($categories as $category) { ?>
                    <li><a class="dropdown-item" href="?cat_id=<?= htmlspecialchars($category['cat_id']) ?>">
                        <?= htmlspecialchars($category['cat_name']) ?>
                    </a></li>
                <?php } ?>
            </ul>

            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Awards
            </button>
            <ul class="dropdown-menu">
                <?php foreach ($awards as $award_name => $award_field) { ?>
                    <li><a class="dropdown-item" href="?award=<?= htmlspecialchars($award_field) ?>">
                        <?= htmlspecialchars($award_name) ?>
                    </a></li>
                <?php } ?>
            </ul>
        </div>

        <br>
        <h3>Books</h3>

        <?php if (empty($books)) { ?>
            <p>No books found in the selected category or award.</p>
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
                                <?php if ($book['best_rent']) { ?>
                                    <p class="card-text"><strong>Award: Best Rent</strong></p>
                                <?php } ?>
                                <?php if ($book['popular']) { ?>
                                    <p class="card-text"><strong>Award: Popular</strong></p>
                                <?php } ?>
                                <?php if ($book['award_winning']) { ?>
                                    <p class="card-text"><strong>Award: Award Winning</strong></p>
                                <?php } ?>
                                <a href="rent/rent.php?book_id=<?= htmlspecialchars($book['b_id']) ?>" class="btn btn-rent">Rent Book</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</body>
</html>