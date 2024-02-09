<?php
namespace App\Controllers\Admin;

use App\Controllers\Admin\AdminController;
use App\Models\groupe;

class AdminGroupeController extends AdminController
{
    public function index()
    {
        $groupes = (new Groupe())->all();
        return $this->view("admin.groupe.index", compact("groupes"));
    }


    

    public function show($id)
    {
        $groupe = new Groupe();
        $id = $groupe->decode($id);
        $groupe = $groupe->findById($id);
        if(!$groupe)
        {
            header("location: /admin/groupe"); exit();
        }

        return $this->view("admin.groupe.show", compact("groupe"));
    }
}
