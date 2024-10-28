<?php
session_start();

if (isset($_SESSION['ad_id']) && isset($_SESSION['ad_email'])) {
    include "../../../db_conn.php";

    if (isset($_GET['cat_id'])) {
        $cat_id = $_GET['cat_id'];

        $sql = "SELECT * FROM category WHERE cat_id = :cat_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':cat_id', $cat_id, PDO::PARAM_INT);
        $stmt->execute();
        $category = $stmt->fetch();

        if ($category) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $new_cat_name = $_POST['category_name'];

                $sql = "UPDATE category SET cat_name = :cat_name WHERE cat_id = :cat_id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':cat_name', $new_cat_name, PDO::PARAM_STR);
                $stmt->bindParam(':cat_id', $cat_id, PDO::PARAM_INT);

                if ($stmt->execute()) {
                    header("Location: ../add_category.php?success=Category updated successfully");
                    exit;
                } else {
                    $error = "Failed to update the category. Please try again.";
                }
            }
        } else {
            header("Location: ../add_category.php?error=Category not found");
            exit;
        }
    } else {
        header("Location: ../add_category.php?error=No category selected");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category</title>

    <!-- Bootstrap CDN 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Bootstrap CDN 5.3 Js Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <style>
        .navbar-brand img {
            height: 50px;
        }
    </style>
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
                            <a class="nav-link active" href="../add_category.php">Add/edit Category</a>
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

        <form action="" method="post" class="shadow p-4 rounded mt-5" style="width: 90%; max-width: 50rem;">
            <h1 class="text-center p-5 display-4 fs-3">Edit Category</h1>

            <!-- Display error or success messages -->
            <?php if (isset($error)) { ?>
                <div class="alert alert-danger" role="alert">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php } ?>

            <!-- Category edit form -->
            <div class="mb-3">
                <label class="form-label">Category Name</label>
                <input type="text" class="form-control" name="category_name" value="<?= htmlspecialchars($category['cat_name']) ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Category</button>
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
