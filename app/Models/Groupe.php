<?php
namespace App\Models;

class Groupe extends Model
{
    public $table = "groupe";
    public $idgroupe;
    public $groupe;
    public $level;
    public $statut;




    public function getIdGroupe()
    {
        return $this->idgroupe;
    }

    public function setIdGroupe($idgroupe)
    {
        $this->idgroupe = $idgroupe;
    }
    

    public function getGroupe()
    {
        return $this->groupe;
    }

    public function setGroupe($groupe)
    {
        $this->groupe = $groupe;
    }
    
    public function getLevel()
    {
        return $this->level;
    }

    public function setLevel($level)
    {
        $this->level = $level;
    }

    public function getStatut()
    {
        return $this->statut;
    }

    public function setStatut($statut)
    {
        $this->statut = $statut;
    }

    public function statut()
    {
        return $this->getStatut() == 1 ? "Activé" : "Désactivé";
    }


    public function initialiseItem($arg)
    {
        if(isset($args['idgroupe'])){ $this->setidGroupe(strip_tags(trim($args['idgroupe']))); }
        if(isset($args['groupe'])){ $this->setGroupe(strip_tags(trim($args['groupe']))); }
        if(isset($args['level'])){ $this->setLevel(strip_tags(trim($args['level']))); }
        if(isset($args['statut'])){ $this->setStatut(strip_tags(trim($args['statut']))); }
    }


    public function getGroupePermission($idgroupe = null)
    {
        if(is_null($idgroupe))
        {
            $permissions = $this->find("*", 'groupe_permission', 'idgroupe', $this->getIdGroupe());
        }else{
            $permissions = $this->find("*", 'groupe_permission', 'idgroupe', $idgroupe);
        }
        if($permissions)
        {
            $this->permissions["table"] = $permissions->table;
            $this->permissions["view"] = $permissions->view;
            $this->permissions["add"] = $permissions->add;
            $this->permissions["update"] = $permissions->update;
            $this->permissions["delete"] = $permissions->delete;
        }
        return $permissions;
        
    }


    public function MemberCount()
    {
        $req = $this->query("SELECT count(*) as count FROM membre
                                            INNER JOIN groupe
                                            WHERE membre.idgroupe = groupe.idgroupe
                                            AND groupe.idgroupe = ?",[$this->idgroupe], false);

        return $req->count;
    }
}