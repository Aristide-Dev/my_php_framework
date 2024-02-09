
  <?php $titre = "Liste des Utilisateurs ".date('d-M-Y'); 
  ?>
  <link rel="stylesheet" href="<?= SCRIPTS ?>plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= SCRIPTS ?>plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= SCRIPTS ?>plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Membres</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/admin">Accueil</a></li>
                    <li class="breadcrumb-item active">Membres</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
    <!-- /.content-header -->

<div class="row">
    <div class="col-4 offset-9 pb-2">
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-lg">
            Ajouter un membre
        </button>
    </div>
</div>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="container">
            <?php 
            
                $membres = $params["membres"];  
                // $membres->haschBruteEncode('doss');
                // var_dump($membres);
            
                $var = "Augustin";
            ?>

        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Liste des membres</h3>
                    </div>
                    <!-- /.card-header -->
                    
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th><?php var_dump(explode('00', 'ar00is00ti00de')); ?></th>
                                    <th>n°</th>
                                    <th>Photo</th>
                                    <th>Nom et Prénoms</th>
                                    <th>Telephone</th>
                                    <th>Email</th>
                                    <th>Groupe</th>
                                    <th>statut</th>
                                    <th>Voir+</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1; foreach($membres as $membre): ?>
                                    <?php $papily = $membre->haschBruteEncode($var); ?>
                                    <tr>
                                        <td><?= $membre->haschBruteEncode($var); ?></td>
                                        <td><?= $membre->haschBrutedecode($papily); ?></td>
                                        <td><?= $i; ?></td>
                                        <td><img src="<?= $membre->photo ?? SCRIPTS."assets/img/avatar.png"; ?>" alt="user-image" width="50px"></td>
                                        <td><?= htmlentities(htmlspecialchars($membre->nom))." ".htmlentities(htmlspecialchars($membre->prenom)); ?></td>
                                        <td><?= htmlentities(htmlspecialchars($membre->telephone));?></td>
                                        <td><?= htmlentities(htmlspecialchars($membre->email));?></td>
                                        <td><?= htmlentities(htmlspecialchars($membre->groupe));?></td>
                                        <td><?= $membre->statut();?></td>
                                        <td>
                                            <a href="/admin/membre/details/<?= $membre->encode($membre->idmembre) ?>" class="btn btn-ligth"><i class="fas fa-eye"></i></a>
                                        </td>
                                    </tr>
                                <?php $i++; endforeach; ?>
                                
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>n°</th>
                                    <th>Nom et Prénoms</th>
                                    <th>Genre</th>
                                    <th>Telephone</th>
                                    <th>Email</th>
                                    <th>Fonction</th>
                                    <th>statut</th>
                                    <th>Voir+</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->


<div class="modal fade" id="modal-lg">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Ajouter nouveau membre</h4>
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

<!-- Page specific script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": false, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>


<script src="<?= AJAX ?>membre/add.js"></script>