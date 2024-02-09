<?php
namespace App\Models;

class Membre extends Model
{
    public $table = "membre";
    public $idmembre;
    public $nom;
    public $prenom;
    public $email;
    public $telephone;
    public $statut;
    public $idgroupe;
    public $groupe;
    public $photo;
    public $groupepermissions = [];
    public $permissions = [];


    public function getIdMembre()
    {
        return $this->idmembre;
    }

    public function setIdMembre(int $idmembre)
    {
        $this->idmembre = $idmembre;
    }



    public function getNom()
    {
        return $this->nom;
    }  

    public function setNom(string $nom)
    {
        $this->nom = $nom;
    }


    public function getPrenom()
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom)
    {
        $this->prenom = $prenom;
    }





    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
    }


    public function getTelephone()
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone)
    {
        $this->telephone = $telephone;
    }


    public function getStatut()
    {
        return $this->statut;
    }

    public function setStatut(int $statut)
    {
        if($statut == 0)
        {
            $this->statut = "désactivé";
        }elseif($statut == 1)
        {
            $this->statut = "activé";
        }elseif($statut == 2)
        {
            $this->statut = "Ne travail plus";
        }else{
            $this->statut = "inconnu";
        }
        
    }


    public function getIdgroupe()
    {
        return $this->idgroupe;
    }

    public function setIdgroupe(int $idgroupe)
    {
        $this->idgroupe = $idgroupe;
    }


    public function getGroupe()
    {
        return $this->groupe;
    }

    public function setGroupe(int $idgroupe)
    {
        $this->fonction = $this->findGroupe($idgroupe);
    }

    public function groupe()
    {
        $req = $this->query("SELECT groupe FROM groupe WHERE idgroupe = ?", [$this->getIdgroupe()], true);
        return $req->groupe;
    }

    public function statut()
    {
        if($this->getStatut() == 0)
        {
            return "<span class='badge badge-danger'>Bloqué</span>";
        }

        if($this->getStatut() == 1)
        {
            return "<span class='badge badge-success'>Activé</span>";
        }

        if($this->getStatut() == 2)
        {
            return "<span class='badge badge-warning'>Désactivé</span>";
        }
    }


    public function getPhoto()
    {
        return $this->photo;
    }

    public function setPhoto($file)
    {
        if(!is_null($file))
        {
            $file = SCRIPTS.'assets\\photo\\'.$_FILES['photo']["name"];
            $file = str_replace("\\", '/', $file);

        }
        $this->photo = $file;
    }



    /**
     * Initialiser les propriétés du membre
     *
     * @param [array] $args
     * @return void
     */
    public function initialiseItem($args){
        if(isset($args['idmembre'])){ $this->setIdMembre(strip_tags(trim($args['idmembre']))); }
        if(isset($args['nom'])){ $this->setNom(strip_tags(trim($args['nom']))); }
        if(isset($args['prenom'])){ $this->setPrenom(strip_tags(trim($args['prenom']))); }
        if(isset($args['email'])){ $this->setEmail(strip_tags(trim($args['email']))); }
        if(isset($args['telephone'])){ $this->setTelephone(strip_tags(trim($args['telephone']))); }
        if(isset($args['statut'])){ $this->setstatut(strip_tags(trim($args['statut']))); }
        if(isset($args['idgroupe'])){ $this->setIdgroupe((int) strip_tags(trim($args['idgroupe']))); }
        if(isset($args['photo'])){ $this->setPhoto((trim($args['photo']))); }
    }




    

    /**
     * Retrouver le groupedans la bd
     *
     * @param integer $idgroupe
     * @return void
     */
    public function findGroupe(int $idgroupe)
    {
        $statement = self::$db->getPDO()->prepare("SELECT groupe FROM groupe WHERE idgroupe = ?");
        $statement->execute([$idgroupe]);
        $data = $statement->fetch();
        return $data->groupe ?? "Aucune fonction";
    }


    /**
     * Enregistrer un nouveau membre
     *
     * @param Membre $membre
     * @param [string] $motdepasse
     * @param [string] $salt
     * @return void
     */
    public function register(Membre $membre, $motdepasse, $salt)
    {
        $db = self::$db->getPDO();
        $db->beginTransaction();

        if(empty($membre->getNom()))
        {
             return $membre->error("Veuillez saisir un nom.");
        }
        
        if(empty($membre->getPrenom()))
        {
             return $membre->error("Veuillez saisir un prenom.");
        }
        
        
        if(empty($membre->getTelephone()))
        {
             return $membre->error("Veuillez saisir un numero de telephone.");
        }
        
        if(empty($membre->getEmail()))
        {
             return $membre->error("Veuillez saisir une adresse email.");
        }
        
        if(empty($membre->getIdgroupe()))
        {
             return $membre->error("Veuillez choisir un role.");
        }
        
        $motdepasse = strip_tags(trim($motdepasse));

        $salt = strip_tags(trim($salt));

        
        $member = $db->prepare("INSERT INTO membre(nom,prenom,telephone,email,idgroupe,statut,photo) VALUES(?,?,?,?,?,?,?)");
                
        $image_link = SCRIPTS.'assets\\photo\\'.$_FILES['photo']["name"];
        $image_link = str_replace("\\", '/', $image_link);

        $member_exe = $member->execute([$membre->getNom(), $membre->getPrenom(), $membre->getTelephone(),$membre->getEmail(), $membre->getIdgroupe(), 1, $membre->getPhoto()]);

        $last_id_user = $db->lastInsertId();
        if($member_exe){
            if(!is_null($membre->getPhoto()))
            {
                if($this->traiteImage($_FILES, 'photo')  == TRUE)
                    {
                        if($this->moveFile(str_replace('\\', '/', PHOTO), $_FILES, 'photo') == TRUE)
                        {
                            // login: statut
                            // 0 => first connextion after add
                            // 1 => actif (WORKED WELL - CAN LOGIN)
                            $login = $db->prepare("INSERT INTO login(email,password,salt,statut) VALUES(?,?,?,?)");
                
                            if($login->execute([$membre->getEmail(),$motdepasse,$salt,0])){
                                
                                $db->commit();
                                return $this->succes("Nouveau membre ajouté avec succès.");

                            }else{
                                $db->rollback();
                                return $this->error("Impossible d'ajouter nouveau membre. Veuillez reessayer ou contacter l'administrateur.");
                            }
                        }
                    }
                    
                $db->rollback();
                return $this->error("Impossible d'ajouter la photo de profile.");
            }else{
                // login: statut
                // 0 => first connextion after add
                // 1 => actif (WORKED WELL - CAN LOGIN)
                $login = $db->prepare("INSERT INTO login(email,password,salt,statut) VALUES(?,?,?,?)");
    
                if($login->execute([$membre->getEmail(),$motdepasse,$salt,0])){
                    
                    $db->commit();
                    return $this->succes("Nouveau membre ajouté avec succès.");

                }else{
                    $db->rollback();
                    return $this->error("Impossible d'ajouter nouveau membre. Veuillez reessayer ou contacter l'administrateur.");
                }
            }
            
            
        }
        return $this->error("Une erreur inatendue c'est prooduite");
    }


    /**
     * Modifier quelques informations  du membre
     *
     * @param Membre $membre
     * @return void
     */
    public function updateInformations(Membre $membre)
    {
        $find = $this->find("*", null, 'idmembre', $membre->getIdMembre());

        if(is_null($find))
        {
            return $this->error("ID membre n'existe pas");
        }

        if($find->telephone != $membre->getTelephone())
        {
            $find2 = $this->find("telephone", null,'telephone', $membre->getTelephone());

            if($find2)
            {
                return $this->error("Ce numero de telephone est deja attribué");
            }
        }

        $data = [];

        $data["nom"] = $membre->getNom();
        $data["prenom"] = $membre->getPrenom();
        $data["telephone"] = $membre->getTelephone();
        $update = $this->update($membre->getIdMembre(), $data, null, null);

        if($update)
        {
            return $this->succes("Informations modifiées avec succes");
        }
        return $this->error("Impossible de modifier");
    }


    /**
     * Modifier le mot de passe d'un membre
     * puis rediriger
     *
     * @param [type] $idmembre
     * @param [type] $password
     * @return void
     */
    public function updatePassword($idmembre, $password, $statut = 0)
    {
        $find = $this->findById($idmembre);
        
        if(is_null($find))
        {
            return $this->error("id utilisateur incorrecte");
        }

        $email = $find->email;
        $db = self::_getPDO();
        $find2 = $this->query("SELECT login.email, salt FROM login INNER JOIN membre WHERE login.email = membre.email AND membre.email = ?",[$email], true);


        if(!isset($find2->email) || empty($find2->email) || !isset($find2->salt) || empty($find2->salt))
        {
            return $this->error("email utilisateur incorrecte");
        }


        $salt = $find2->salt;
        $password = $this->pass($password,$salt);

        $data["password"] = $password;
        $update = $this->query("UPDATE login SET password = ?, statut = ? WHERE email = ?", [$password,$statut,$email], true);

        if($update)
        {
            return $this->succes("Mot de passe modifié avec succes");
        }
        return $this->error("Impossible de modifier");
    }


    public function getGroupePermission($idgroupe = null)
    {
        if(is_null($idgroupe))
        {
            $idgroupe =  $this->getIdGroupe();
        }
        $permissions = $this->query("SELECT * FROM groupe_permission WHERE idgroupe = ?",[$idgroupe],true);
        if($permissions)
        {
            $this->groupepermissions["table"] = $permissions->table;
            $this->groupepermissions["view"] = $permissions->view;
            $this->groupepermissions["add"] = $permissions->add;
            $this->groupepermissions["update"] = $permissions->update;
            $this->groupepermissions["delete"] = $permissions->delete;
        }
        
    }

    public function membre($idgroupe)
    {
        $permissions = self::$db->getPDO()->prepare("SELECT * FROM groupe_permission WHERE groupe_permission.idgroupe = ?");
        $permissions->execute([$idgroupe]);
        $datas = $permissions->fetchAll();
        return $datas;
    }


    
    /**
     * if first login(modify password of member)
     *
     * @param [type] $password
     * @param [type] $confirm_pwp
     * @return Void
     */
    public function first_login($password, $confirm_pwp)
    {
        if(!isset($_SESSION["auth"]['email']) || empty($_SESSION["auth"]['email']) || empty($_SESSION["auth"]['user_id']))
        {
            return $this->error("Impossible de changer le mot de passe. Veuillez contacter l'administrateur.");
        }

        if($password != $confirm_pwp)
        {
            return $this->error("Les mots de passe doivent etre identiques");
        }
        
        if(strlen($password) < 8)
        {
            return $this->error("il faut 8 caracteres au minimum");
        }
        
        $email = $_SESSION["auth"]['email'];

        $result1 = $this->first($email,1);

        if($result1 == true)
        {
            return $this->updatePassword($_SESSION["auth"]['user_id'], $password, 1);
        }
        return $this->error("Une erreur c'est produite");
    }


    /**
     * update login statut from db
     * if statut = 0 -> first login
     * else -> not first login
     *
     * @param [string] $email
     * @param boolean $statut
     * @return void
     */
    public function first($email, $statut = false)
    {
        $req = $this->query("UPDATE login SET statut = ? WHERE email = ?", [$email,$statut], true);

        if($req == true)
        {
            return true;
        }
        return false;
    }



    public function MembrePermissions()
    {

        $permissions = self::$db->getPDO()->prepare("SELECT * FROM membre_permission WHERE membre_permission.idmembre = ?");
        $permissions->execute([$this->idmembre]);
        if($permissions)
        {
            $data = $permissions->fetchAll();
            if(!empty($data)){ return $data; }
        }
        $permissions = self::$db->getPDO()->prepare("SELECT * FROM groupe_permission WHERE groupe_permission.idgroupe = ?");
        $permissions->execute([$this->idgroupe]);
        {
            $data = $permissions->fetchAll();
            $datas = [];
            foreach($datas as $e)
            {
                $data[] = [
                    [
                        'table' =>$e->table,
                        'view' =>$e->view,
                        'add' =>$e->add,
                        'update' =>$e->update,
                        'delete' =>$e->delete,
                    ]
                ];
            }
            
            return $data;
            if(!empty($data)){ return $data; }
        }
        return null;



        $req = $this->query("SELECT * FROM membre_permission WHERE idmembre = ?",[$this->idmembre], true);
        if($req)
        {
            
            if(!empty($req))
            {
                $this->permissions = 
                [
                    'table' => $req->table,
                    'view' => $req->view,
                    'add' => $req->add,
                    'update' => $req->update,
                    'delete' => $req->delete
                ];exit();
            }
        }
        $req2 = $this->query("SELECT * FROM groupe_permission WHERE idgroupe = ?",[$this->idgroupe], true);

        if($req2)
        {
            if(!empty($req2))
            {
                return $req2;
            }
        }
    }


}