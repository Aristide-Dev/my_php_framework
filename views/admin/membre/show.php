<?php
$title = "UTILISATEUR";
$membre = $params["one_membre"];
$permissions = $params["permissions"];

?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Profile</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">User Profile</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>



<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">

                <!-- Profile Image -->
                <div class="card card-primary card-outline shadow-lg">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle" src="<?= $membre->photo ?>" alt="User profile picture">
                        </div>

                        <h3 class="profile-username text-center"><?= htmlentities(htmlspecialchars($membre->nom)) . "<br>" . htmlentities(htmlspecialchars($membre->prenom)); ?></h3>

                        <p class="text-muted text-center"><?= htmlentities(htmlspecialchars($membre->groupe())); ?></p>

                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Email</b> <a class="float-right"><?= htmlentities(htmlspecialchars($membre->email)); ?></a>
                            </li>
                            <li class="list-group-item">
                                <b>Telephone</b> <a class="float-right"><?= htmlentities(htmlspecialchars($membre->telephone)); ?></a>
                            </li>
                            <li class="list-group-item text-center">
                                <b>STATUT</b>
                            </li>
                        </ul>

                        <a href="#" class="btn btn-<?php if ($membre->statut == 0) {
                                                        echo "danger";
                                                    }
                                                    if ($membre->statut == 1) {
                                                        echo "success";
                                                    }
                                                    if ($membre->statut == 2) {
                                                        echo "warning";
                                                    } ?> btn-block"><b><?= $membre->statut(); ?></b></a>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->

                <!-- About Me Box -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Groupe & Permissions (<?= $membre->findGroupe($membre->idgroupe) ?>)</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <table id="example1" class="table table-bordered table-striped col-md-4">
                            <thead>
                                <tr>
                                    <th>table</th>
                                    <th>View</th>
                                    <th>Add</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!$permissions) : ?>
                                    <tr>
                                        <h3 class="text-danger">Aucune donnée</h3>
                                    </tr>
                                <?php else : ?>
                                    <?php foreach ($permissions as $permission) : ?>
                                        <tr>
                                            <th><?= $permission->table; ?></th>
                                            <th><?= App\App::toIcon($permission->view); ?></th>
                                            <th><?= App\App::toIcon($permission->add); ?></th>
                                            <th><?= App\App::toIcon($permission->update); ?></th>
                                            <th><?= App\App::toIcon($permission->delete); ?></th>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>


            <!-- /.col -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Activity</a></li>
                            <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Timeline</a></li>
                            <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Parametres</a></li>
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="active tab-pane" id="activity">
                                <h3 class="text-center">Roles et Permissions</h3>
                                <div class="col-12">
                                    <form method="post" id="setPermissions">
                                        <div class="col-4 form-group">
                                            <label for="table">Table</label>
                                            <input type="text" name="table" id="table" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-switch custom-switch-on-success">
                                                <input type="checkbox" class="custom-control-input" name="view" id="view">
                                                <label class="custom-control-label" for="view">VUE</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-switch custom-switch-on-success">
                                                <input type="checkbox" class="custom-control-input" name="add" id="add">
                                                <label class="custom-control-label" for="add">AJOUT</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-switch custom-switch-on-success">
                                                <input type="checkbox" class="custom-control-input" name="update" id="update">
                                                <label class="custom-control-label" for="update">MODIFICATION</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-switch custom-switch-on-success">
                                                <input type="checkbox" class="custom-control-input" id="delete" name="delete">
                                                <label class="custom-control-label" for="delete">SUPPRESSION</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input type="hidden" name="membre" value="<?= $membre->encode($membre->idmembre); ?>">
                                            <button type="submit" class="btn btn-lg btn-primary">Valider</button>
                                        </div>
                                    </form>
                                </div>
                                <?php var_dump($membre->MembrePermissions()); ?>
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="timeline">
                                <!-- The timeline -->
                                <div class="timeline timeline-inverse">
                                    <!-- timeline time label -->
                                    <div class="time-label">
                                        <span class="bg-danger">
                                            10 Feb. 2014
                                        </span>
                                    </div>
                                    <!-- /.timeline-label -->
                                    <!-- timeline item -->
                                    <div>
                                        <i class="fas fa-envelope bg-primary"></i>

                                        <div class="timeline-item">
                                            <span class="time"><i class="far fa-clock"></i> 12:05</span>

                                            <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>

                                            <div class="timeline-body">
                                                Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                                                weebly ning heekya handango imeem plugg dopplr jibjab, movity
                                                jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                                                quora plaxo ideeli hulu weebly balihoo...
                                            </div>
                                            <div class="timeline-footer">
                                                <a href="#" class="btn btn-primary btn-sm">Read more</a>
                                                <a href="#" class="btn btn-danger btn-sm">Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END timeline item -->
                                    <!-- timeline item -->
                                    <div>
                                        <i class="fas fa-user bg-info"></i>

                                        <div class="timeline-item">
                                            <span class="time"><i class="far fa-clock"></i> 5 mins ago</span>

                                            <h3 class="timeline-header border-0"><a href="#">Sarah Young</a> accepted your friend request
                                            </h3>
                                        </div>
                                    </div>
                                    <!-- END timeline item -->
                                    <!-- timeline item -->
                                    <div>
                                        <i class="fas fa-comments bg-warning"></i>

                                        <div class="timeline-item">
                                            <span class="time"><i class="far fa-clock"></i> 27 mins ago</span>

                                            <h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>

                                            <div class="timeline-body">
                                                Take me to your leader!
                                                Switzerland is small and neutral!
                                                We are more like Germany, ambitious and misunderstood!
                                            </div>
                                            <div class="timeline-footer">
                                                <a href="#" class="btn btn-warning btn-flat btn-sm">View comment</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END timeline item -->
                                    <!-- timeline time label -->
                                    <div class="time-label">
                                        <span class="bg-success">
                                            3 Jan. 2014
                                        </span>
                                    </div>
                                    <!-- /.timeline-label -->
                                    <!-- timeline item -->
                                    <div>
                                        <i class="fas fa-camera bg-purple"></i>

                                        <div class="timeline-item">
                                            <span class="time"><i class="far fa-clock"></i> 2 days ago</span>

                                            <h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos</h3>

                                            <div class="timeline-body">
                                                <img src="https://placehold.it/150x100" alt="...">
                                                <img src="https://placehold.it/150x100" alt="...">
                                                <img src="https://placehold.it/150x100" alt="...">
                                                <img src="https://placehold.it/150x100" alt="...">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END timeline item -->
                                    <div>
                                        <i class="far fa-clock bg-gray"></i>
                                    </div>
                                </div>
                            </div>
                            <!-- /.tab-pane -->

                            <div class="tab-pane" id="settings">
                                <div class="shadow-lg p-4">
                                    <h4 class="text-center col-12 bg-primary mb-3 p-2">informations Personnelles</h4>
                                    <form method="POST" id="updatepi" class="form-horizontal">
                                        <div class="form-group row">
                                            <label for="nom" class="col-sm-2 col-form-label">Nom</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="nom" id="nom" value="<?= htmlentities(htmlspecialchars($membre->nom)); ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="prenom" class="col-sm-2 col-form-label">Prénom(s)</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="prenom" id="prenom" value="<?= htmlentities(htmlspecialchars($membre->prenom)); ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                            <div class="col-sm-10">
                                                <input type="email" class="form-control" name="email" id="inputEmail" value="<?= htmlentities(htmlspecialchars($membre->email)); ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="telephone" class="col-sm-2 col-form-label">Telephone</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="telephone" id="telephone" value="<?= htmlentities(htmlspecialchars($membre->telephone)); ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="offset-sm-2 col-sm-10">
                                                <input type="hidden" name="id" id="id" value="<?= $membre->encode($membre->idmembre); ?>">
                                                <button type="submit" name="submit" class="btn btn-primary">Sauvegarger</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <hr>
                                <hr>



                                <div class="shadow-lg p-4">
                                    <h4 class="text-center col-12 bg-danger mb-3 p-2">informations de connexion</h4>
                                    <form method="POST" id="updatepw" class="form-horizontal">

                                        <div class="form-group row">
                                            <label for="inputEmail" class="col-sm-4 col-form-label">Login</label>
                                            <div class="col-sm-8">
                                                <input type="email" class="form-control" name="email" id="inputEmail" value="<?= htmlentities(htmlspecialchars($membre->email)); ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="password" class="col-sm-4 col-form-label">Nouveau mot de passe</label>
                                            <div class="col-sm-8">
                                                <input type="password" class="form-control" name="password" id="password" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="confirmePassword" class="col-sm-4 col-form-label">Confirmer nouveau mot de passe</label>
                                            <div class="col-sm-8">
                                                <input type="password" class="form-control" name="confirmePassword" id="confirmePassword" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="offset-sm-4 col-sm-10">
                                                <button type="submit" name="submit" class="btn btn-danger">Modifier</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <hr>
                                <hr>

                            </div>
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->


<script src="/<?= AJAX ?>membre/updatepi.js"></script>
<script src="/<?= AJAX ?>membre/updatepw.js"></script>
<script src="/<?= AJAX ?>membre/setMembrePermission.js"></script>