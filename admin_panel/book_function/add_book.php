<?php
session_start();

# If the admin is logged in
if (isset($_SESSION['ad_id']) && isset($_SESSION['ad_email'])) {
    include "../../db_conn.php";
    include "book_func.php";

    // Fetch categories from the database
    $sql = "SELECT * FROM category";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $categories = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Book</title>

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
                            <a class="nav-link active" href="add_book.php">Add Book</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="add_category.php">Add/edit Category</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="add_award.php">Add/edit Award</a>
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

        <form action="add_book_func.php" 
              method="post" 
              enctype="multipart/form-data"
              class="shadow p-4 rounded mt-5" 
              style="width: 90%; max-width: 50rem;">
            <h1 class="text-center p-5 display-4 fs-3">
                Add New Book
            </h1>

            <!-- Display error or success messages -->
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

            <!-- Book Title -->
            <div class="mb-3">
                <label class="form-label">Book Title*</label>
                <input type="text" class="form-control" name="book_title" required>
            </div>

            <!-- Book Author -->
            <div class="mb-3">
                <label class="form-label">Book Author*</label>
                <input type="text" class="form-control" name="book_author" required>
            </div>

            <!-- Book Description -->
            <div class="mb-3">
                <label class="form-label">Book Description*</label>
                <input type="text" class="form-control" name="book_description" required>
            </div>

            <!-- Book Category -->
            <div class="mb-3">
                <label class="form-label">Book Category*</label>
                <select name="book_category" class="form-control" id="" required>
                    <option value="0">Select Category</option>
                    <?php foreach ($categories as $category){ ?>
                        <option value="<?=$category['cat_id']?>"><?=$category['cat_name']?></option>
                    <?php } ?>
                </select>
            </div>

            <!-- Book Cover -->
            <div class="mb-3">
                <label class="form-label">Book Cover(.jpg)*</label>
                <input type="file" class="form-control" name="book_cover" required>
            </div>

            <!-- Book File -->
            <div class="mb-3">
                <label class="form-label">Book File(.pdf)*</label>
                <input type="file" class="form-control" name="book_file" required>
            </div>
            
            <button type="submit" class="btn btn-primary">Add</button>
        </form>
    </div>
</body>
</html>

<?php 
} else {
    header("Location: ../../account/login.php");
    exit;
}
?>
