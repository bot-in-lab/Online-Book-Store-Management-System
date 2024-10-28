<?php
session_start();

# If the admin is logged in
if (isset($_SESSION['ad_id']) && isset($_SESSION['ad_email'])) {

    # Database Connection
    include "../db_conn.php";

    # Book helper function
    include "book_function/book_func.php";
    $books = get_all_books($conn);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>

    <!-- Bootstrap CDN 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Bootstrap CDN 5.3 Js Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

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
                <a class="navbar-brand" href="admin_panel.php">
                    <img src="../image/admin.png" alt="ADMIN"><br>ADMIN</a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="../index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="book_function/add_book.php">Add Book</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="book_function/add_category.php">Add/edit Category</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="book_function/add_award.php">Add/edit Award</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="user_list.php">User List</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../account/logout.php">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <?php 
        if ($books == 0) { ?>
            <p>No Book is available.</p>
        <?php } else { ?>

        <?php
        if (isset($_GET['msg'])) {
            echo '<div class="alert alert-success" role="alert">' . htmlspecialchars($_GET['msg']) . '</div>';
        }
        
        if (isset($_GET['error'])) {
            echo '<div class="alert alert-danger" role="alert">' . htmlspecialchars($_GET['error']) . '</div>';
        }
        ?>

        <h4>All Books</h4>
        <table class="table table-hover table-striped table-bordered shadow-lg rounded">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Description</th>
                    <th>Category</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($books as $index => $book) { ?>
                <tr>
                <td><?= $index + 1 ?></td>
                <td>
                    <!-- Display the book cover -->
                    <img width="100" src="../uploads/cover/<?= htmlspecialchars($book['cover']) ?>" alt="Cover Image">
                    <br>
                    <!-- link to the PDF file -->
                    <a href="../uploads/file/<?= htmlspecialchars($book['file']) ?>" target="_blank">Read PDF</a>
                    <br>
                    <br>
                    <!-- Display the book title -->
                    <?= htmlspecialchars($book['b_title']) ?>
                </td>
                <td><?= htmlspecialchars($book['author']) ?></td>
                <td><?= htmlspecialchars($book['description']) ?></td>
                <td><?= htmlspecialchars($book['cat_name'])?></td>
                <td>
                    <a href="book_function/edit_delete_book/edit_book.php?b_id=<?= $book['b_id'] ?>" class="btn btn-warning">Edit</a>
                    <a href="book_function/edit_delete_book/delete_book.php?b_id=<?= $book['b_id'] ?>" class="btn btn-danger">Delete</a>
                </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php } ?>
    </div>
</body>
</html>

<?php 
} else {
    header("Location: ../account/login.php");
    exit;
}
?>
