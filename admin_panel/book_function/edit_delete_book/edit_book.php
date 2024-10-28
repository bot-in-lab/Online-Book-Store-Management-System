<?php
session_start();

// Check if the admin is logged in
if (isset($_SESSION['ad_id']) && isset($_SESSION['ad_email'])) {
    include "../../../db_conn.php";

    if (isset($_GET['b_id'])) {
        $book_id = $_GET['b_id'];

        $sql = "SELECT * FROM book WHERE b_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$book_id]);
        $book = $stmt->fetch();

        $sql = "SELECT * FROM category";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $categories = $stmt->fetchAll();
    } else {
        header("Location: ../../admin_panel.php");
        exit;
    }
?>

<style>
    .navbar-brand img {
        height: 50px;
    }
</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book</title>

    <!-- Bootstrap CDN 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

<div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="../../admin_panel.php">
                    <img src="../../../image/admin.png" alt="ADMIN"><br>ADMIN</a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="../../../index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../add_book.php">Add Book</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../add_category.php">Add/edit Category</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../add_award.php">Add/edit Award</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../../user_list.php">User List</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../../../account/logout.php">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <form action="update_book.php" method="post" enctype="multipart/form-data" class="shadow p-4 rounded mt-5" style="width: 90%; max-width: 50rem;">
        <h1 class="text-center p-5 display-4 fs-3">Edit Book</h1>
            <input type="hidden" name="b_id" value="<?= htmlspecialchars($book['b_id']) ?>">

            <!-- Book Title -->
            <div class="mb-3">
                <label for="b_title" class="form-label">Book Title*</label>
                <input type="b_text" class="form-control" id="b_title" name="b_title" value="<?= htmlspecialchars($book['b_title']) ?>" required>
            </div>

            <!-- Author -->
            <div class="mb-3">
                <label for="author" class="form-label">Author*</label>
                <input type="text" class="form-control" id="author" name="author" value="<?= htmlspecialchars($book['author']) ?>" required>
            </div>

            <!-- Description -->
            <div class="mb-3">
                <label for="description" class="form-label">Description*</label>
                <textarea class="form-control" id="description" name="description" rows="4" required><?= htmlspecialchars($book['description']) ?></textarea>
            </div>

            <!-- Category -->
            <div class="mb-3">
                <label for="category" class="form-label">Category*</label>
                <select class="form-control" id="category" name="category" required>
                    <?php foreach ($categories as $category) { ?>
                        <option value="<?= $category['cat_id'] ?>" <?= $book['cat_id'] == $category['cat_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($category['cat_name']) ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <!-- Book Cover -->
            <div class="mb-3">
                <label for="cover" class="form-label">Book Cover(.jpg)*</label>
                <input type="file" class="form-control" id="cover" name="cover">
                <!-- Show the current cover if it exists -->
                <?php if (!empty($book['cover'])) { ?>
                    <p class="mt-3">Current Cover: <img src="../../../uploads/cover/<?= $book['cover'] ?>" alt="Book Cover" style="max-width: 100px;"></p>
                <?php } ?>
            </div>

            <!-- Book File -->
            <div class="mb-3">
                <label for="file" class="form-label">Book File(.pdf)*</label>
                <input type="file" class="form-control" id="file" name="file">
                <!-- Show the current file link if it exists -->
                <?php if (!empty($book['file'])) { ?>
                    <p class="mt-3">Current File: <a href="../../../uploads/file/<?= $book['file'] ?>" target="_blank">View PDF</a></p>
                <?php } ?>
            </div>

            <button type="submit" class="btn btn-primary">Update Book</button>
        </form>
    </div>

</body>
</html>

<?php 
} else {
    header("Location: ../../../account/login.php");
    exit;
}
?>
