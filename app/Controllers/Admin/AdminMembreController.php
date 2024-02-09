<?php
namespace App\Controllers\Admin;
use App\models\Groupe;
use App\models\Membre;

class AdminMembreController extends AdminController
{
    public function index()
    {
        $membre = new Membre();
        $membres = $membre->all(true);
        foreach ($membres as $xyz) {
            $xyz->groupe = $membre->findGroupe((int) $xyz->idgroupe);
        }

        $membre = new Membre();

        $groupe = new Groupe();
        $groupes = $groupe->all();
        return $this->view("admin.membre.index", compact("membres","groupes", 'membre'));
    }

    public function store()
    {
        $membre = new Membre();

        if(isset($_POST)){
            $membre->initialiseItem($args = [        
                'nom'=>(isset($_POST['nom']))?strip_tags(trim($_POST['nom'])):'',
                'prenom'=> (isset($_POST['prenom']))?strip_tags(trim($_POST['prenom'])):'',     
                'email'=>(isset($_POST['email']))?strip_tags(trim($_POST['email'])):'',
                'telephone'=> (isset($_POST['telephone']))?strip_tags(trim($_POST['telephone'])):'',
                'idgroupe'=>(isset($_POST['idgroupe']))?strip_tags(trim($_POST['idgroupe'])):'', 
                'photo'=>(isset($_FILES['photo']["name"]))?strip_tags(trim($_FILES['photo']["name"])):null    
            ]);
            $this->control_items($membre);

            if(isset($_POST["motdepasse"]) && isset($_POST["confirmermotdepasse"]) && !empty($_POST["motdepasse"]) && !empty($_POST["confirmermotdepasse"]))
            {
                $motdepasse = strip_tags(trim($_POST["motdepasse"]));
                $confirmermotdepasse = strip_tags(trim($_POST["confirmermotdepasse"]));
            }else{
                echo json_encode($membre->error("Veuillez remplir tous les champs avant de valider."));exit();
            } 
            
            if($_POST["motdepasse"] != $_POST["confirmermotdepasse"]){
                echo json_encode($membre->error("Les mots de passe doivent etre identiques"));exit();
            }
            
            
            if($motdepasse == $confirmermotdepasse)
            {

                $salt =  $membre->salt();
                $motdepasse =  $membre->pass($motdepasse,$salt);
                echo json_encode($membre->register($membre, $motdepasse, $salt));
                
            }else{
                echo json_encode($membre->error("Les mots de passe ne sont pas identiques."));exit();
            }
        }else{
            echo json_encode($membre->error("Une erreur c'est produite1."));exit();
        }
        
    }



    public function show(String $id)
    {
        $membre = (new Membre());
        $idd = (int)$membre->decode($id);
        $one_membre = $membre->findChamById("*", $idd);
        $permissions = $membre->membre($one_membre->idgroupe);

        if(!$one_membre)
        {
            header("location: /admin");exit();
        }
        return $this->view("admin.membre.show", compact("one_membre", "permissions"));
    }



    /**
     * PARAMS: String $id
     * encoded id
     * return Array (model.error)
     */
    public function updatePersonalInformation(String $id)
    {
        $membre = new Membre();
        $id = (int) $membre->decode($id);

        if(!isset($_POST) || empty($_POST))
        {
            echo json_encode($membre->error("Une erreur c'est produite. Impossible de modifier les informations"));exit();
        }

        if(!isset($_POST["nom"]) || empty($_POST["nom"]))
        {
            echo json_encode($membre->error("Veuillez saisir le nom"));exit();
        }

        if(!isset($_POST["prenom"]) || empty($_POST["prenom"]))
        {
            echo json_encode($membre->error("Veuillez saisir le prenon"));exit();
        }

        if(!isset($_POST["telephone"]) || empty($_POST["telephone"]))
        {
            echo json_encode($membre->error("Veuillez saisir un numero de telephone"));exit();
        }

        $membre->initialiseItem([
            'idmembre'=> $id ?strip_tags(trim($id)):'',
            'nom'=>(isset($_POST['nom']))?strip_tags(trim($_POST['nom'])):'',
            'prenom'=> (isset($_POST['prenom']))?strip_tags(trim($_POST['prenom'])):'',  
            'telephone'=> (isset($_POST['telephone']))?strip_tags(trim($_POST['telephone'])):''
        ]);


        echo json_encode($membre->updateInformations($membre));exit();
    }



    public function setMembrePermission()
    {
        $membre = new Membre();
        if(!isset($_POST) || empty($_POST))
        {
            echo json_encode($membre->error('Une erreur c\'est produite....')); exit();
        }

        if(!isset($_POST["membre"]) || empty($_POST["membre"]))
        {
            echo json_encode($membre->error("Une erreur c'est produite....")); exit();
        }

        if(!isset($_POST["table"]) || empty($_POST["table"]))
        {
            echo json_encode($membre->error("Le nom de la table est obligatoire.....")); exit();
        }

        $user_id = $membre->decode(strip_tags($_POST["membre"]));
        $table = strip_tags(trim($_POST["table"]));

        if(isset($_POST["view"]) || !empty($_POST["view"]))
        {
            $view = 1;
        }else{
            $view = 0;
        }

        if(isset($_POST["add"]) || !empty($_POST["add"]))
        {
            $add = 1;
        }else{
            $add = 0;
        }

        if(isset($_POST["update"]) || !empty($_POST["update"]))
        {
            $update = 1;
        }else{
            $update = 0;
        }
    }


    public function updatePassword(String $id)
    {
        $membre = new Membre();
        $id = (int)$membre->decode($id);

        if(!isset($_POST) || empty($_POST))
        {
            echo json_encode($membre->error("Une erreur c'est produite. Impossible de modifier les informations"));exit();
        }

        if(!isset($_POST["password"]) || empty($_POST["password"]) || !isset($_POST["confirmePassword"]) || empty($_POST["confirmePassword"]))
        {
            echo json_encode($membre->error("Veuillez remplir tous les champs"));exit();
        }

        if($_POST["password"] != $_POST["confirmePassword"])
        {
            echo json_encode($membre->error("Les mots de passe doivent etre identiques"));exit();
        }

        $motdepasse = strip_tags(trim($_POST["password"]));

        echo json_encode($membre->updatePassword($id, $motdepasse)); exit();
    
    }
    


    //control items
    public function control_items(Membre $membre)
    {
        //    
        $db = $membre::_getPDO(); 

        if(empty($membre->getNom())){
          echo json_encode($membre->error("Veuillez entrer un nom."));exit();
        }
        if(empty($membre->getPrenom())){
            echo json_encode($membre->error("Veuillez entrer le(s) prénom(s)."));exit();
        }
        
        if(empty($membre->getTelephone())){
            echo json_encode($membre->error("Veuillez entrer le numero de telephone."));exit();
        }else{
            $telephone = $membre->getTelephone();
            $find_phone = $db->query("SELECT * FROM membre WHERE telephone = '$telephone'");
            $data_phone = $find_phone->rowCount();
            if( $data_phone != 0){
                echo json_encode($membre->error("Le numero de telephone est déjà utilisé."));exit();
            }
        }

        if(empty($membre->getEmail())){
            echo json_encode($membre->error("Veuillez entrer l'adresse Email."));exit();
        }else{ 
            $email = $membre->getEmail();
            $find_email = $db->query("SELECT * FROM membre WHERE email = '$email'");
            $data_email = $find_email->rowCount();
            if($data_email != 0 ){
                echo json_encode($membre->error("L'email est déjà utilisé."));exit();
            }
        }
        if(empty($membre->getStatut())){
            $membre->setStatut(0);
        }
        if(empty($membre->getIdgroupe())){
            echo json_encode($membre->error("Veuillez atribuer un groupe au nouveau membre."));exit();
        }
    }
}