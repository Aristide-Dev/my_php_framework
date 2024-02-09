<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;

class AdminController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        parent::allow(10);
    }


    public function index()
    {
        return $this->view("admin.index");
    }

}
