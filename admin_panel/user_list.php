<?php
session_start();

# If the admin is logged in
if (isset($_SESSION['ad_id']) && isset($_SESSION['ad_email'])) {

    # Database Connection
    include "../db_conn.php";

    $sql = "SELECT * FROM customer ORDER BY c_id DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $users = $stmt->fetchAll();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>

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
                            <a class="nav-link active" href="user_list.php">User List</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../account/logout.php">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

    <?php 
        if (!$users) { ?>
            <p>No user found.</p>
        <?php } else { ?>

        <?php 
            if (isset($_GET['success'])) {
                echo '<div class="alert alert-success" role="alert">' . htmlspecialchars($_GET['success']) . '</div>';
            }
            
            if (isset($_GET['error'])) {
                echo '<div class="alert alert-danger" role="alert">' . htmlspecialchars($_GET['error']) . '</div>';
            }
        ?>
        <h4>List of User</h4>
        <table class="table table-hover table-striped table-bordered shadow-lg rounded">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Phone No.</th>
                    <th>Full Address</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $index => $user) { ?>
                <tr>
                <td><?= $index + 1 ?></td>
                    <td><?= htmlspecialchars($user['f_name']) ?></td>
                    <td><?= htmlspecialchars($user['l_name']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td><?= htmlspecialchars($user['ph_no']) ?></td>
                    <td><?= htmlspecialchars($user['full_address']) ?></td>
                    <td>
                        <a href="delete_user.php?user_id=<?= $user['c_id'] ?>" class="btn btn-danger"
                           onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
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
