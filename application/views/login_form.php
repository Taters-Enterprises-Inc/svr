<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Taters Enterprises, Inc.</title>
  <!-- Bootstrap 4 CDN -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f7f9fc;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .login-container {
      max-width: 400px;
      padding: 30px;
      background: white;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .login-container h3 {
      text-align: center;
      margin-bottom: 5px;
      font-weight: 600;
      color: #333;
    }
    .login-container small {
      display: block;
      text-align: center;
      margin-bottom: 20px;
      color: #777;
    }
    .form-control {
      border-radius: 50px;
      padding: 10px 20px;
    }
    .btn-custom {
      background-color: #a21013;
      color: white;
      border-radius: 50px;
      padding: 10px 20px;
    }
    .btn-custom:hover {
      background-color: #910e11;
    }
    .forgot-password {
      text-align: right;
      display: block;
      margin-top: 10px;
    }
  </style>
</head>
<body>

  <div class="login-container">
    <h3>SVR Portal</h3>
    <small class="mt-4">Enter your email & password to login</small>
    <form method="post" action="<?php echo base_url('login/submit'); ?>">
      <div class="form-group">
        <input type="email" class="form-control" name="email" placeholder="Email">
      </div>
      <div class="form-group">
        <input type="password" class="form-control" name="password" placeholder="Password">
      </div>
      <button type="submit" class="btn btn-custom btn-block">Login</button>
    </form>
  </div>

  <!-- Bootstrap 4 JS, Popper.js, and jQuery -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>