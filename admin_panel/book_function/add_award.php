<?php
session_start();

# If the admin is logged in
if (isset($_SESSION['ad_id']) && isset($_SESSION['ad_email'])) {
    include "../../db_conn.php";

    // Fetch books from the database
    $sql = "SELECT b_id, b_title FROM book";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $books = $stmt->fetchAll();

    // Fetch awards and book titles from the database
    $sql = "SELECT book.b_id, book.b_title, award.description, award.best_rent, award.popular, award.award_winning 
            FROM award
            INNER JOIN book ON award.b_id = book.b_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $awards = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Award</title>

    <!-- Bootstrap CDN 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>

<style>
        /* Logo styling */
        .navbar-brand img {
            height: 50px;
        }
    </style>
</head>

<body>

    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="../admin_panel.php">
                    <img src="../../image/admin.png" alt="ADMIN"><br>ADMIN</a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="../../index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="add_book.php">Add Book</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="add_category.php">Add/edit Category</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="add_award.php">Add/edit Award</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../user_list.php">User List</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../../account/logout.php">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <form action="add_award_func.php" method="post" class="shadow p-4 rounded mt-5" style="width: 90%; max-width: 50rem;">
            <h1 class="text-center p-5 display-4 fs-3">Add Book Award</h1>

            <?php if (isset($_GET['error'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?= htmlspecialchars($_GET['error']) ?>
                </div>
            <?php } ?>

            <?php if (isset($_GET['success'])) { ?>
                <div class="alert alert-success" role="alert">
                    <?= htmlspecialchars($_GET['success']) ?>
                </div>
            <?php } ?>

            <!-- Select Book Title -->
            <div class="mb-3">
                <label class="form-label">Book Title*</label>
                <select name="book_title" class="form-control" required>
                    <option value="0">Select Title</option>
                    <?php foreach ($books as $book){ ?>
                        <option value="<?=$book['b_id']?>"><?=htmlspecialchars($book['b_title'])?></option>
                    <?php } ?>
                </select>
            </div>

            <!-- Award Selection -->
            <div class="mb-3">
                <label class="form-label">Select Awards</label><br>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="best_rent" value="1" id="best_rent">
                    <label class="form-check-label" for="best_rent">Best Rent</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="popular" value="1" id="popular">
                    <label class="form-check-label" for="popular">Popular</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="award_winning" value="1" id="award_winning">
                    <label class="form-check-label" for="award_winning">Award Winning</label>
                </div>
            </div>

            <!-- Award Description -->
            <div class="mb-3">
                <label class="form-label">Award Description*</label>
                <input type="text" class="form-control" name="award_description" required>
            </div>

            <button type="submit" class="btn btn-primary">Add</button>
        </form>
    </div>

     <!-- List of all Awards in the table -->
     <br>
    <?php 
    if (empty($awards)) { ?>
        <p>No awards available.</p>
    <?php } else { ?>
        <h4>All Awards</h4>
        <table class="table table-hover table-striped table-bordered shadow-lg rounded" style="width: 90%; max-width: 50rem;">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Book Title</th>
                    <th>Awards</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($awards as $index => $award) { ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= htmlspecialchars($award['b_title']) ?></td>
                        <td>
                            <?php if ($award['best_rent']) echo "Best Rent "; ?>
                            <?php if ($award['popular']) echo "Popular "; ?>
                            <?php if ($award['award_winning']) echo "Award Winning "; ?>
                        </td>
                        <td><?= htmlspecialchars($award['description']) ?></td>
                        <td>
                            <a href="edit_delete_award/edit_award.php?b_id=<?= $award['b_id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="edit_delete_award/delete_award.php?b_id=<?= $award['b_id'] ?>" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } ?>
</body>
</html>

<?php 
} else {
    header("Location: ../../account/login.php");
    exit;
}
?>