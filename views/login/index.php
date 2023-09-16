<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Sistema Reparaciones - Login</title>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="<?= URL ?>public/css/app.min.css">
  <link rel="stylesheet" href="<?= URL ?>public/bundles/bootstrap-social/bootstrap-social.css">
  <!-- Template CSS -->
  <link rel="stylesheet" href="<?= URL ?>public/css/style.css">

  <link rel='shortcut icon' type='image/x-icon' href='<?= URL ?>public/img/favicon.ico' />
</head>

<body>
  <div id="app">
    <section class="section">
      <div class="container mt-5 pt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="card card-primary">
              <div class="card-header">
                <h4>Login</h4>
              </div>
              <div class="card-body">
                <div class="mb-2"><?php $this->showMessages() ?></div>

                <form method="POST" action="login/auth" class="needs-validation" novalidate="">
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control" name="email" tabindex="1" required autofocus>
                    <div class="invalid-feedback">
                      Please fill in your email
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="password" class="control-label">Password</label>
                    <div class="d-none">
                      <div class="float-right">
                        <a href="auth-forgot-password.html" class="text-small">
                          Forgot Password?
                        </a>
                      </div>
                    </div>
                    <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                    <div class="invalid-feedback">
                      please fill in your password
                    </div>
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                      Login
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- General JS Scripts -->
  <script src="<?= URL ?>public/js/app.min.js"></script>

  <!-- Template JS File -->
  <script src="<?= URL ?>public/js/scripts.js"></script>
</body>

</html>