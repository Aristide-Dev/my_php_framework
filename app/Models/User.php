<?php

namespace App\Models;

class User extends Model
{




    public function redirectUser(int $idrole)
    {
        switch ($idrole) {
            case 10:
                header("location: /admin");
                break;
            case 50:
                header("location: /professeur");
                break;

            default:
                echo 'dommage';
                break;
                header("location: /login");
                break;
        }
    }
}
