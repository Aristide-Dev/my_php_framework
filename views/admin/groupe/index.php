<p class="p1">Aristide</p>
<input type="text" name="cc" id="cc" class="form-control">
<p class="p2 text-danger">Aristide 2</p>
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
                    <li class="breadcrumb-item active">Groupes</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<div class="row">
    <div class="col-4 offset-9 pb-2">
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-lg">
            Ajouter un groupe
        </button>
    </div>
</div>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Liste des groupes</h3>
                    </div>
                    <!-- /.card-header -->
                    <?php $groupes = $params["groupes"]; ?>
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>n°</th>
                                    <th>Groupe</th>
                                    <th>Level</th>
                                    <th>Utilisateurs</th>
                                    <th>Statut</th>
                                    <th>Voir+</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                                foreach ($groupes as $groupe) : ?>
                                    <tr>
                                        <td><?= $i; ?></td>
                                        <td><?= htmlentities(htmlspecialchars($groupe->groupe)); ?></td>
                                        <td><?= htmlentities(htmlspecialchars($groupe->level)); ?></td>
                                        <td><?= htmlentities(htmlspecialchars($groupe->MemberCount())); ?></td>
                                        <td><?= App\App::statutHTML($groupe->statut); ?></td>
                                        <td>
                                            <a href="/admin/groupe/details/<?= $groupe->encode($groupe->idgroupe) ?>" class="btn btn-ligth"><i class="fas fa-eye"></i></a>
                                        </td>
                                    </tr>
                                <?php $i++;
                                endforeach; ?>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>n°</th>
                                    <th>Groupe</th>
                                    <th>Level</th>
                                    <th>Utilisateurs</th>
                                    <th>Statut</th>
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
                                    <?php foreach ($params["groupes"] as $groupe) : ?>
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
    $(function() {
        $("#example1").DataTable({
            "responsive": false,
            "lengthChange": false,
            "autoWidth": false,
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


<script src="<?= AJAX ?>groupe/add.js"></script>

<script>
    $(document).ready(function() {
        $(".p2").hide();

        $(".p1").hover(
            function(e) {
                $(".p2").show();

            },

            function() {
                $(".p2").hide();
            }
        );

        $("#cc").keypress(function(z) {
            var keyp = String.fromCharCode(z.which);
            $(".p2").html(keyp);
        });




    });
</script>