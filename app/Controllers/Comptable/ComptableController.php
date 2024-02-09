<?php

namespace App\Controllers\Comptable;

use App\Controllers\Controller;
// use App\Models\Admin\AdminCycle;
// use App\Models\Admin\AdminEleve;
// use App\Models\Admin\AdminClasse;
// use App\Models\Admin\AdminParent;
// use App\Models\Admin\AdminMatiere;
// use App\Models\Admin\AdminProfesseur;

class ComptableController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        parent::allow(40);
    }


    public function index()
    {
        return $this->view("comptable.index");
    }

}
