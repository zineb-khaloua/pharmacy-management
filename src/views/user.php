<?php
use Helpers\SessionHelper;
SessionHelper::startSession();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Form</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome for Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>

<body class="bg-success d-flex justify-content-center align-items-center vh-100">
  <div class="card shadow-lg" style="max-width: 500px; width: 100%;">
    <div class="card-header bg-teal text-success text-center py-4">
      <h2 class="mb-0">Login Form</h2>
    </div>
    <div class="card-body p-4">

  <?php if(isset($_SESSION['alert'])) : ?>
        <div class="alert alert-<?= $_SESSION['alert']['type']; ?> text-center" role="alert">

              <?= $_SESSION['alert']['message']; ?>

      </div>
              <?php unset($_SESSION['alert']); ?>
              <?php endif; ?>

             

      <form action="" method="post">
        <div class="mb-3">

          <label for="username" class="form-label"><i class="fas fa-user"></i> Username</label>
          <input type="text" id="username" name="username" class="form-control" placeholder="username" >
        </div>
        <div class="mb-3">
          <label for="password" class="form-label"><i class="fas fa-lock"></i> Password</label>
          <input type="password" id="password" name="password" class="form-control" placeholder="password" >
        </div>
        <div class="d-flex justify-content-between align-items-center mb-3">
          <a href="#" class="text-decoration-none text-teal">Forgot password?</a>
        </div>
        <div class="d-grid">
          <button type="submit" name="submit" value="login" class="btn btn-success">Login</button>
        </div>
      </form>
    
    </div>
  </div>

  <!-- Bootstrap JS (optional) -->                                          
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
