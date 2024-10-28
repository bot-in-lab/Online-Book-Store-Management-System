<?php
session_start();

# If the admin is logged in
if (isset($_SESSION['ad_id']) && isset($_SESSION['ad_email'])) {
    include "../../../db_conn.php";

    // Check if b_id is provided in the URL
    if (isset($_GET['b_id'])) {
        $b_id = $_GET['b_id'];

        // Fetch the award details for the given b_id
        $sql = "SELECT a.b_id, a.description, a.best_rent, a.popular, a.award_winning 
                FROM award a 
                JOIN book b ON a.b_id = b.b_id 
                WHERE a.b_id = :b_id";
        try {
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':b_id', $b_id, PDO::PARAM_INT);
            $stmt->execute();
            $award = $stmt->fetch();
        } catch (PDOException $e) {
            die("Error executing query: " . $e->getMessage());
        }
        

        if ($award) {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Award</title>

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
                            <a class="nav-link" href="../../../account/logout.php">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <form action="update_award.php" method="post" class="shadow p-4 rounded mt-5" style="width: 90%; max-width: 50rem;">
            <h1 class="text-center p-5 display-4 fs-3">
                Edit Award
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

            <!-- Hidden input for the book ID -->
            <input type="hidden" name="b_id" value="<?= $award['b_id'] ?>">

            <!-- Description -->
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea class="form-control" name="description" rows="3" required><?= htmlspecialchars($award['description']) ?></textarea>
            </div>

            <!-- Awards Selection (Checkboxes) -->
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="best_rent" value="1" <?= $award['best_rent'] ? 'checked' : '' ?>>
                <label class="form-check-label">Best Rent</label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="popular" value="1" <?= $award['popular'] ? 'checked' : '' ?>>
                <label class="form-check-label">Popular</label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="award_winning" value="1" <?= $award['award_winning'] ? 'checked' : '' ?>>
                <label class="form-check-label">Award Winning</label>
            </div>

            <button type="submit" class="btn btn-primary mt-4">Update Award</button>
        </form>
    </div>
</body>
</html>

<?php
        } else {
            echo "<p>Invalid award ID</p>";
        }
    } else {
        echo "<p>No award selected</p>";
    }
} else {
    header("Location: ../../../account/login.php");
    exit;
}
?>
