<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/style.css')?>">
    <title>Login!</title>
  </head>
  <body class="loginpage">
    <div class="login-form shadow">
      <form action="<?= base_url('login/validation')?>" method="post">
          <h3 class="text-center">UPT PUSKESMAS SEMANU 1</h3>   
          <div class="mt-3">
            <input type="text" class="form-control" name="username" id="username" placeholder="Username" required="required">
        </div>
        <div class="mt-3">
            <input type="password" class="form-control" name="password" id="password" placeholder="Password" required="required">
        </div>
        <div class="d-grid gap-2 mt-3 mb-3">
            <button class="btn btn-primary" type="submit">Login</button>
          </div>
      </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
  </body>
</html>