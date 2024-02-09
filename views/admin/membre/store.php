<?php if(!empty($params['errors'])) : ?>
    <?php foreach ($params['errors'] as $key => $value) : ?>
        <div class="col-8 offset-2">
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="icon fas fa-exclamation-triangle"></i> Erreur!</h5>
                <p class="text-center"><?= $value; ?></p>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Ajouter Membre</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/admin">Accueil</a></li>
                    <li class="breadcrumb-item"><a href="/admin/membre">membres</a></li>
                    <li class="breadcrumb-item active">Ajouter</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
    <!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <!-- jquery validation -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h5 class="text-center">Informations Personnelles</h5>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form method="POST" action="/admin/membre/ajouter" id="quickForm">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="nom">Nom</label>
                                    <input type="text" name="nom" class="form-control" id="nom" placeholder="Saisir le nom">
                                </div>
                                <div class="form-group col-6">
                                    <label for="prenom">Prénom(s)</label>
                                    <input type="text" name="prenom" class="form-control" id="prenom" placeholder="Saisir le prenom">
                                </div>
                            </div>


                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="sexe">Genre</label>
                                    <select name="sexe" id="sexe" class="form-control">
                                        <option value="homme">Homme</option>
                                        <option value="femme">Femme</option>
                                        <option value="autre">Autre</option>
                                    </select>
                                </div>
                                <div class="form-group col-6">
                                    <label for="dateNaissance">Date de naissance</label>
                                    <input type="date" name="dateNaissance" class="form-control" id="dateNaissance" placeholder="Saisir le nom">
                                </div>
                            </div>


                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="telephone">Telephone</label>
                                    <input type="text" name="telephone" class="form-control" id="telephone" placeholder="exemple: +224 6xxxxxxxx">
                                </div>
                                <div class="form-group col-6">
                                    <label for="email">Adresse Email</label>
                                    <input type="email" name="email" class="form-control" id="email" placeholder="Saisir votre email">
                                </div>
                            </div>


                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="sexe">Fonction</label>
                                    <select name="fonction" id="fonction" class="form-control">
                                        <option value="">--CHOIX--</option>
                                        <?php foreach($params["fonctions"] as $fonction): ?>
                                            <option value="<?= $fonction->idfonction; ?>"><?= $fonction->fonction; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="card-header bg-gray shadow-lg">
                                <h5 class="text-center">Informations de connexion</h5>
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="motdepasse">Mot de passe</label>
                                    <input type="password" name="motdepasse" class="form-control" id="motdepasse" placeholder="Saisir mot de passe">
                                </div>
                                <div class="form-group col-6">
                                    <label for="confirmermotdepasse">Confirmer mot de passe</label>
                                    <input type="password" name="confirmermotdepasse" class="form-control" id="confirmermotdepasse" placeholder="Confirmer mot de passe">
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                        <button type="submit" name="submit" class="btn btn-lg btn-primary offset-10">Enregistrer</button>
                        </div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->














<script src="<?= SCRIPTS ?>assets/js/pages/dashboard.js"></script>
<script src="<?= SCRIPTS ?>plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="<?= SCRIPTS ?>plugins/jquery-validation/additional-methods.min.js"></script>
<script>
  $('#quickForm').validate({
    rules: {
      email: {
        required: true,
        email: true,
      },
      password: {
        required: true,
        minlength: 5
      },
      terms: {
        required: true
      },
    },
    messages: {
      email: {
        required: "Please enter a email address",
        email: "Please enter a valid email address"
      },
      password: {
        required: "Please provide a password",
        minlength: "Your password must be at least 5 characters long"
      },
      terms: "Please accept our terms"
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.form-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    }
  });
});
</script>