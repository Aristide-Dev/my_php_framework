
  <?php $titre = "GROUPE"; 
  ?>
  <link rel="stylesheet" href="<?= SCRIPTS ?>plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= SCRIPTS ?>plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= SCRIPTS ?>plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Groupes</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/admin">Accueil</a></li>
                    <li class="breadcrumb-item"><a href="/admin/groupe">Groupes</a></li>
                    <li class="breadcrumb-item active">Details</li>
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

        </div>
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->


<div class="modal fade" id="modal-lg">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Ajouter nouveau groupe</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        
        <form method="POST" encytype="multipart/form-data" id="quickForm">
        <div class="modal-body">
            <div class="card-header bg-lightblue shadow-lg">
                <h5 class="text-center">Informations Personnelles</h5>
            </div>
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
                        <label for="idgroupe">Groupe</label>
                        <select name="idgroupe" id="idgroupe" class="form-control">
                            <option value="">--CHOIX--</option>
                            <?php foreach($params["groupes"] as $groupe): ?>
                                <option value="<?= $groupe->idgroupe; ?>"><?= $groupe->groupe; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-12">
                        <label for="photo">Photo</label>
                        <input type="file" name="photo" class="form-control" id="photo">
                    </div>
                </div>

                <div class="card-header bg-tile shadow-lg">
                    <h5 class="text-center">Informations de connexion</h5>
                </div>
                <div class="row">
                    <div class="form-group col-6">
                        <label for="motdepasse">Mot de passe</label>
                        <input type="password" name="motdepasse" class="form-control" id="motdepasse" placeholder="Saisir mot de passe">
                    </div>
                    <div class="form-group col-6">
                        <label for="confirmermotdepasse">Confirmer</label>
                        <input type="password" name="confirmermotdepasse" class="form-control" id="confirmermotdepasse" placeholder="Confirmer mot de passe">
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
            
            </div>
            
            <div class="modal-footer justify-content-between">
                <button type="reset" class="btn btn-danger">Annuler</button>
                <span id="resultat"></span>
                <button type="submit" name="valider" class="btn btn-primary">Save changes</button>
            </div>
        
        </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>



<script src="<?= AJAX ?>groupe/add.js"></script>