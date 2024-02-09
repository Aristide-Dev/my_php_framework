<?php

namespace App\Models\Admin;

use App\Models\Model;

class AdminModel extends Model
{
    public function getButton(): string
    {
        return <<<HTML
        <a href="/admin/cycle/$this->idcycle" class="btn btn-lg btn-primary">Voir plus</a>
HTML;
    }
}
