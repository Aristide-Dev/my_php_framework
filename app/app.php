<?php
namespace App;

class App
{
    public static function statutHTML(int $statut)
    {
        if($statut == 0)
        {
            return "<span class='badge badge-danger'>Bloqué</span>";
        }elseif($statut == 1)
        {
            return "<span class='badge badge-success'>Activé</span>";
        }elseif($statut == 2)
        {
            return "<span class='badge badge-warning'>Désactivé</span>";
        }else{
            return "<span class='badge badge-primary'>Inconnu</span>";
        }
    }


    //set active to sidebar memnu
    public static function setActive($page_name)
    {
        if(isset($_GET["url"]))
        {
            $partials = explode('/', $_GET["url"]);
            foreach ($partials as $partial) {
                if($partial == $page_name)
                {
                    return 'active';
                }
            }
        }
        
    }


    /**
     * ajouter des icones au niveau des autorisations V|X
     *
     * @param [int] $value
     * @return void
     */
    public static function toIcon($value)
    {
        if($value == 1)
        {
            return "<i class='far fa-eye text-success'></i>";
        }else{
            return "<i class='far fa-eye text-danger'></i>";
        }
    }
}