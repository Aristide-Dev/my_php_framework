<?php 
namespace App\Controllers;

use App\Models\Membre;

class AuthController extends Controller
{
    protected $table = "membre";

    public function login()
    {
        return $this->view("auth.login");
    }

    public function loginAuth()
    {
        $user = new Membre();
        $user->login($_POST["email"],$_POST["password"]);
        // if($user::error == true){
        //     echo json_encode($user->getErrors());exit();
        // }
        echo json_encode($user->getErrors());exit();
    }

    public function logout()
    {
        session_destroy();
        return header("location: /login");
    }

    public function first_login()
    {
        echo json_encode((new Membre)->first_login($_POST["new_pwd"], $_POST["confirm_new_pwd"]));
    }

}