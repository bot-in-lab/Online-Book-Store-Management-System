<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

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
        <form class="p-5 rounded shadow" style="max-width: 30rem; width: 100%" method="POST" action="auth.php">

            <h1 class="text-center display-4 pb-5">LOGIN</h1>
            
            <?php if (isset($_GET['error'])) { ?>
            <div class="alert alert-danger" role="alert">
                <?php echo htmlspecialchars($_GET['error']); ?>
            </div>
            <?php } ?>

            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email*</label>
                <input type="text" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp" required>
            </div>

            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password*</label>
                <input type="password" class="form-control" name="password" id="exampleInputPassword1" required>
            </div>

            <button type="submit" class="btn btn-primary">Login</button>
            <br><br>
            <p>Don't have an account? <a href="registration.php">SIGN UP</a></p>
        </form>
    </div>

    </body>
</html>
