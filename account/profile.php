<?php
session_start();
include '../db_conn.php';

if (!isset($_SESSION['c_id'])) {
    header("Location: login.php");
    exit();
}

$c_id = $_SESSION['c_id'];

$sql = "SELECT f_name, l_name, email, ph_no, full_address FROM customer WHERE c_id = :c_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':c_id', $c_id, PDO::PARAM_INT);
$stmt->execute();
$profile = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $f_name = $_POST['f_name'];
    $l_name = $_POST['l_name'];
    $email = $_POST['email'];
    $ph_no = $_POST['ph_no'];
    $full_address = $_POST['full_address'];

    $update_sql = "UPDATE customer 
                   SET f_name = :f_name, l_name = :l_name, email = :email, ph_no = :ph_no, full_address = :full_address 
                   WHERE c_id = :c_id";
    $stmt_update = $conn->prepare($update_sql);
    $stmt_update->bindParam(':f_name', $f_name);
    $stmt_update->bindParam(':l_name', $l_name);
    $stmt_update->bindParam(':email', $email);
    $stmt_update->bindParam(':ph_no', $ph_no);
    $stmt_update->bindParam(':full_address', $full_address);
    $stmt_update->bindParam(':c_id', $c_id, PDO::PARAM_INT);
    $stmt_update->execute();

    header("Location: profile.php?msg=You have successfully updated your profile.");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Online Book Store</title>

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
        <nav class="navbar navbar-expand-lg bg-body-tertiary mb-4">
            <div class="container-fluid">
                <a class="navbar-brand" href="../index.php">
                    <img src="../image/logo.png" alt="Online Book Store">
                </a>
                <div class="navbar-text">
                    <div class="icon-section">
                        <a href="../rent/rent.php"><img src="../image/rent.png" alt="Rent"></a>
                        <a href="login.php"><img src="../image/login.png" alt="Log in"></a>
                        <a href="logout.php"><img src="../image/logout.png" alt="Logout"></a>
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
        
        <div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
            
            <?php if ($profile) { ?>
            <form class="p-5 rounded shadow" style="max-width: 30rem; width: 100%" action="profile.php" method="POST">
                <h1 class="text-center display-4 pb-5">My Profile</h1>
                
                <div class="mb-3">
                    <label for="f_name" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="f_name" name="f_name" value="<?= htmlspecialchars($profile['f_name']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="l_name" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="l_name" name="l_name" value="<?= htmlspecialchars($profile['l_name']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($profile['email']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="ph_no" class="form-label">Phone</label>
                    <input type="text" class="form-control" id="ph_no" name="ph_no" value="<?= htmlspecialchars($profile['ph_no']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="full_address" class="form-label">Full Address</label>
                    <textarea class="form-control" id="full_address" name="full_address" rows="3" required><?= htmlspecialchars($profile['full_address']) ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Update Profile</button>
            </form>
            <?php } else { ?>
                <p class="alert alert-warning">Profile not found.</p>
            <?php } ?>
        </div>
    </div>
</body>
</html>
