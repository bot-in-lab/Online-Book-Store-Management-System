<?php
include "../db_conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $f_name = $_POST['f_name'];
    $l_name = $_POST['l_name'];
    $email = $_POST['email'];
    $ph_no = $_POST['phone'];
    $full_address = $_POST['address'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password != $confirm_password) {
        echo "<script>alert('Passwords do not match!');</script>";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        try {
            $sql = "INSERT INTO customer (f_name, l_name, email, ph_no, full_address, password) 
                    VALUES (:f_name, :l_name, :email, :ph_no, :full_address, :password)";
            $stmt = $conn->prepare($sql);

            $stmt->bindParam(':f_name', $f_name);
            $stmt->bindParam(':l_name', $l_name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':ph_no', $ph_no);
            $stmt->bindParam(':full_address', $full_address);
            $stmt->bindParam(':password', $hashed_password);

            $stmt->execute();

            header("Location: login.php");
            exit();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>

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
                        <a href="login.php"><img src="../image/rent.png" alt="Rent"></a>
                        <a href="login.php"><img src="../image/login.png" alt ="Log in"></a>
                    </div>
                </div>
            </div>
        </nav>
    </div>

    <div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">      
        <form class="p-5 rounded shadow" style="max-width: 30rem; width: 100%" method="POST" action="registration.php" onsubmit="return validatePassword()">
            <h1 class="text-center display-4 pb-5">SIGN UP</h1>

            <div class="mb-3">
                <label for="f_name" class="form-label">First Name*</label>
                <input type="text" class="form-control" name="f_name" id="f_name" required>
            </div>

            <div class="mb-3">
                <label for="l_name" class="form-label">Last Name*</label>
                <input type="text" class="form-control" name="l_name" id="l_name" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email*</label>
                <input type="email" class="form-control" name="email" id="email" required>
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">Phone Number*</label>
                <input type="tel" class="form-control" name="phone" id="phone" required>
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Full Address*</label>
                <input type="text" class="form-control" name="address" id="address" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password*</label>
                <input type="password" class="form-control" name="password" id="password" required>
            </div>

            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirm Password*</label>
                <input type="password" class="form-control" name="confirm_password" id="confirm_password" required>
            </div>

            <button type="submit" class="btn btn-primary">Register</button>
            <br><br>
            <p>Already have an account? <a href="login.php">Login Now</a></p>
        </form>
    </div>

    <script>
        function validatePassword() {
            var password = document.getElementById("password").value;
            var confirm_password = document.getElementById("confirm_password").value;

            if (password != confirm_password) {
                alert("Passwords do not match. Please try again.");
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
