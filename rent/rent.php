<?php
session_start();
include '../db_conn.php';


if (!isset($_SESSION['c_id']) && !isset($_SESSION['c_email'])) {
    header("Location: ../account/login.php");
    exit();
}

$c_id = $_SESSION['c_id'];


if (isset($_GET['book_id'])) {
    $book_id = $_GET['book_id'];

    $check_sql = "SELECT * FROM rent WHERE b_id = :book_id AND c_id = :c_id";
    $stmt_check = $conn->prepare($check_sql);
    $stmt_check->bindParam(':book_id', $book_id, PDO::PARAM_INT);
    $stmt_check->bindParam(':c_id', $c_id, PDO::PARAM_INT);
    $stmt_check->execute();

    if ($stmt_check->rowCount() == 0) {
        $start_date = date('y-m-d');
        $return_date = date('y-m-d', strtotime('+1 week'));

        $sql_rent = "INSERT INTO rent (c_id, b_id, start_date, return_date) VALUES (:c_id, :b_id, :start_date, :return_date)";
        $stmt_rent = $conn->prepare($sql_rent);
        $stmt_rent->bindParam(':c_id', $c_id, PDO::PARAM_INT);
        $stmt_rent->bindParam(':b_id', $book_id, PDO::PARAM_INT);
        $stmt_rent->bindParam(':start_date', $start_date);
        $stmt_rent->bindParam(':return_date', $return_date);
        $stmt_rent->execute();

        header("Location: rent.php");
    } else {
        header("Location: rent.php?error=You have already rented this book.");
    }
}

$sql_rented = "SELECT r.b_id, b.b_title, b.cover, b.file, r.start_date, r.return_date 
               FROM rent r 
               JOIN book b ON r.b_id = b.b_id 
               WHERE r.c_id = :c_id";
$stmt_rented = $conn->prepare($sql_rented);
$stmt_rented->bindParam(':c_id', $c_id, PDO::PARAM_INT);
$stmt_rented->execute();
$rented_books = $stmt_rented->fetchAll(PDO::FETCH_ASSOC);

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
    <link rel="stylesheet" href="../css/style.css">
    
</head>
<body>

    <div class="container">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="../index.php">
                    <img src="../image/logo.png" alt="Online Book Store">
                </a>

                <div class="navbar-text">
                    <div class="phone-section">
                        <img src="../image/phone.png" alt="Phone Icon">
                        <span class="phone-number">Hotline <br> 017xxxxxxx</span>
                    </div>

                    <div class="icon-section">
                        <a href="rent.php"><img src="../image/rent.png" alt="Rent"></a>
                        <a href="../account/profile.php"><img src="../image/login.png" alt="Profile"></a>
                        <a href="../account/logout.php"><img src="../image/logout.png" alt="Logout"></a>
                    </div>
                </div>
            </div>
        </nav>

        <?php
        if (isset($_GET['msg'])) {
            echo '<div class="alert alert-success" role="alert">' . htmlspecialchars($_GET['msg']) . '</div>';
        }
        
        if (isset($_GET['error'])) {
            echo '<div class="alert alert-danger" role="alert">' . htmlspecialchars($_GET['error']) . '</div>';
        }
        ?>

        <h3>Rented Books</h4>
        <?php if (!empty($rented_books)) { ?>
            <table class="table table-hover table-striped table-bordered shadow-lg rounded">
                <thead class="table-dark">
                    <tr>
                        <th>Cover</th>
                        <th>Title</th>
                        <th>Start Date</th>
                        <th>Return Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rented_books as $book) { ?>
                        <tr>
                            <td>
                                <img src="../uploads/cover/<?= htmlspecialchars($book['cover']) ?>" alt="Cover Image" width="100">
                                <br>
                                <a href="../uploads/file/<?= htmlspecialchars($book['file']) ?>" target="_blank">Read PDF</a>
                            </td>
                            <td><?= htmlspecialchars($book['b_title']) ?></td>
                            <td><?= htmlspecialchars($book['start_date']) ?></td>
                            <td><?= htmlspecialchars($book['return_date']) ?></td>
                            <td>
                                <a href="renew.php?b_id=<?= $book['b_id'] ?>" class="btn btn-warning">Renew</a>
                                <br>
                                <br>
                                <a href="return.php?b_id=<?= $book['b_id'] ?>" class="btn btn-danger">Return</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p>You have not rented any books yet.</p>
        <?php } ?>
    </div>
</body>
</html>
