<?php

namespace App\Controllers;

use Database\DBconnection;

abstract class Controller
{
    protected $db;

    public function __construct()
    {
        $this->db =  new DBconnection('assurance', '127.0.0.1', 'root', '');
    }

    protected function view(string $path, array $params = null)
    {
        $side_path = explode('.', $path);
        $side_path1 = $side_path[0];
        $path = str_replace('.', DIRECTORY_SEPARATOR, $path);
        if ($side_path1 == "auth" || $path == "welcome") {
            require(VIEWS . DIRECTORY_SEPARATOR . "{$path}.php");
            exit();
        }else{
            ob_start();
            $side = VIEWS . DIRECTORY_SEPARATOR . "sidebar/{$side_path1}.php";
            $path = str_replace('.', DIRECTORY_SEPARATOR, $path);
            require(VIEWS . DIRECTORY_SEPARATOR . $path . ".php");
            if ($params) {
                $params = extract($params);
            }

            $content = ob_get_clean();
            require(VIEWS . DIRECTORY_SEPARATOR . "layout.php");
        }
    }

    protected function getDB()
    {
        return $this->db;
    }


    public function allow($idfonction,?string $msg="Vous n'etes pas autorisé a acéder à cette page. Veillez vous connecter...")
    {
        if(isset($_SESSION["auth"]["idfonction"])){
            if($_SESSION["auth"]["idfonction"] != $idfonction){
                $_SESSION["error"] = $msg;
                return header("location: /login");
            }
            
        }else{
            $_SESSION["error"] = "veuillez vous connecter pour acceder à cette page";
            return header("location: /login");
        }
    
    }


    public function login()
    {
        return $this->view("auth.login");
    }
}
