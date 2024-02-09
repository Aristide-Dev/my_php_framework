<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Log in (v2)</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= SCRIPTS ?>plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?= SCRIPTS ?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= SCRIPTS ?>assets/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="<?= SCRIPTS ?>index2.html" class="h1"><b>ASSUR</b>ANCE</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">CONNEXION</p>
        <span id="resultat"></span>
      <form method="POST" id="log">
        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="Entrer votre email" value="<?= $_POST["email"] ?? ''; ?>">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Entrer votre mot de passe">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-7">
            <div class="icheck-primary">
              <input type="checkbox" name="remember" id="remember">
              <label for="remember">
                Se souvenir de moi
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-5">
            <button type="submit" class="btn btn-primary btn-block btn_connect">Se Connecter</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <!-- /.social-auth-links -->

      <p class="mb-1">
        <a href="forgot-password.html">Mot de passe oublié ?</a>
      </p>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->



<div class="modal fade" id="modal-lg">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ajout de nouveau client</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="new_pwd_modify">
                    <div class="row">
                        <div class="form-group col-12">
                            <label for="new_pwd">Nouveau mot de passe:</label>
                            <input type="password" name="new_pwd" id="new_pwd" class="form-control">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-12">
                            <label for="confirm_new_pwd">Confirmer nouveau mot depasse:</label>
                            <input type="password" name="confirm_new_pwd" id="confirm_new_pwd" class="form-control">
                        <!-- /.input group -->
                        </div>
                    </div>

                    
                    <div class="col-md-12" id="resultat_new_pwd"></div>
                    <div class="modal-footer justify-content-between">
                        <input type="reset" value="Annuler"  class="anuuler btn btn-danger">
                        <input type="submit" name="submit" value="Valider" class="valider btn btn-success">
                    </div>
                </form>
            </div>
           
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>




<!-- jQuery -->
<script src="<?= SCRIPTS ?>plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= SCRIPTS ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= SCRIPTS ?>assets/js/adminlte.min.js"></script>
<script src="<?= AJAX ?>auth\login.js"></script>
</body>
</html>
