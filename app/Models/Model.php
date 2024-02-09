<?php

namespace App\Models;

use PDO;
use Database\DBconnection;

abstract class Model
{
    /**
     * varriable de connexion à la base de donnné pour le model
     *
     * @var [Database Object]
     */
    protected static $db;

    /**
     * Nom de la table en bd
     *
     * @var [string]
     */
    protected $table;

    /**
     * recupperer les erreurs en db
     *
     * @var array
     */
    public static $errors = 
                [
                    'error' => 0, 
                    'suc' => '0', 
                    'msg' => '', 
                    'redirect' => '', '
                    first_login' => '0'
                ];
    public static $error = false;

    /**
     * Largeur de l'image
     *
     * @var integer
     */
    const LARGEUR = 800;

    /**
     * Hauteur de l'image
     *
     * @var integer
     */
    const HAUTEUR =  533;


   
    


    /**
     * FIRST FUNCTION
     */
    public function __construct()
    {
        self::getModel();
        //self::$db =  new DBconnection('assurance', '127.0.0.1', 'root', '');
        // if (!isset($_SESSION['auth']) && !isset($_POST)) {
        //     $_SESSION['error'] = "Vous devez d'abord vous connecter";
        //     header("location: /login");
        // }
    }


    /**
     * Avoir une seule instance du model
     *
     * @return void
     */
    public static function getModel()
    {
        if(is_null(self::$db))
        {
            self::$db = new DBconnection('assurance', '127.0.0.1', 'root', '');
        }
        return self::$db;
    }


    public static function _getPDO()
    {
        return (self::$db)->getPDO();
    }


    /**
     * Retourn All elements on one table
     *
     * @param [boolean] $orderBy
     * @return Array|Model
     */
    public function all($orderBy = null)
    {
        if(is_null($orderBy))
        {
            return $this->query("SELECT * FROM {$this->table}");
        }else{
            return $this->query("SELECT * FROM {$this->table} ORDER BY id{$this->table} DESC");
        }
        
    }


    /**
     * Find one element in table by idtable 
     *
     * @param integer $id
     * @param [string] $table
     * @return Array|Model
     */
    public function findById($id, $table = null)
    {

        if (is_null($table)) {
            $champ = "id" . $this->table;
        } else {
            $champ = "id" . $table;
        }
        $req = $this->query("SELECT * FROM {$this->table} WHERE {$champ} = ?", [$id], true);

        return  $req ? $req : null;
    }


    /**
     * Find one element in table by idtable
     *
     * @param [type] $colums
     * @param integer $id
     * @return Array|Model
     */
    public function findChamById($colums, int $id)
    {
        $champ = "id" . $this->table;
        $req = $this->query("SELECT {$colums} FROM {$this->table} WHERE {$champ} = ?", [$id], TRUE);
        return $req ? $req : null;
    }


    /**
     * Find one element by colunms,table, colunm_sheared and value
     *
     * @param string $colums
     * @param String|null $table
     * @param String $search
     * @param String $value
     * @return Array|Model
     */
    public function find(string $colums, String $table=null,String $search, $value)
    {
        if(is_null($table)){
            $table = "{$this->table}";
        }
        $req = $this->query("SELECT {$colums} FROM {$table} WHERE {$search} = ?", [$value], 1);
        return $req ? $req : null;
    }




    /**
     * Get all error
     *
     * @return Array
     */
    public function getErrors()
    {
        return self::$errors;
    }

    // Initialyse success message
    public function setErrors($error, $success, $message, $redirect='', $first_login = 0)
    {
        self::$errors['error'] = $error;
        self::$errors['suc'] = $success;
        self::$errors['msg'] = $message;
        self::$errors['redirect'] = $redirect;
        self::$errors['first_login'] = $first_login;
    }




    // Initialyse error message
    public function  error($msg)
    {
        $this->setErrors('1', '0', $msg, '', '0');
        self::$error = true;
        return $this->getErrors();
    }




    // Initialyse success message
    public function succes($msg)
    {
        $this->setErrors('0', '1', $msg, '', '0');
        self::$error = false;
        return $this->getErrors();
    }



    /**
     * Initialyse success message and redirect url 
     *
     * @param [string] $msg
     * @param [string] $location
     * @param [boolean] $first_login
     * @return Array
     */
    public function redirect($msg, $location, $first_login = null)
    {
        if(is_null($first_login))
        {
            $this->setErrors('0', '1', $msg, $location, $first_login);
            self::$error = false;
            return $this->getErrors();
        }
            $this->setErrors('0', '2', $msg, $location, $first_login);
            self::$error = false;
            return $this->getErrors();
        
    }


    /**
     * Simplify sql requette
     *
     * @param string $requete
     * @param array|null $params
     * @param boolean|null $single
     * @return oject|Model
     */
    public function query(string $requete, array $params = null, bool $single = null)
    {
        $method = is_null($params) ? "query" : "prepare";

        if (
            strpos($requete, "DELETE") === 0 ||
            strpos($requete, "INSERT") === 0 ||
            strpos($requete, "UPDATE") === 0
        ) {
            $statement = self::$db->getPDO()->$method($requete);
            $statement->setFetchMode(PDO::FETCH_CLASS, get_class($this), [self::$db]);
            return $statement->execute($params);
        }

        $fetch = is_null($single) ? "fetchAll" : "fetch";

        $statement = self::$db->getPDO()->$method($requete);
        $statement->setFetchMode(PDO::FETCH_CLASS, get_class($this), [self::$db]);




        if ($method === "query") {
            return $statement->$fetch();
        } else {
            $statement->execute($params);
            return $statement->$fetch();
        }
    }


    /**
     * Delete delete one element on table
     *
     * @param integer $id
     * @return Boolean
     */
    public function destroy(int $id)
    {
        $champ = "id" . $this->table;
        return $this->query("DELETE FROM {$this->table} WHERE {$champ} = ?", [$id]);
    }



    /**
     * Update data on table
     *
     * @param string|int $id
     * @param array $data
     * @param String|null $table
     * @param String|null $champ
     * @return void
     */
    public function update($id, array $data, String $table=null, String $champ=null)
    {
        if($champ == null){
            $champ = "id" . $this->table;
        }
        $sqlRequestParts = "";
        $i = 1;

        foreach ($data as $key => $value) {
            $comma = $i === count($data) ? " " : ", ";
            $sqlRequestParts .= "{$key} = :{$key}{$comma}";
            $i++;
        }

        
        $data["{$champ}"] = $id;
        if($table == null){
            if($this->query("UPDATE {$this->table} SET {$sqlRequestParts} WHERE {$champ} = :{$champ}", $data, true) == true)
            {
                return true;
            }
            return false;
        }else{
            if($this->query("UPDATE {$table} SET {$sqlRequestParts} WHERE {$champ} = :{$champ}", $data, true) == true)
            {
                return true;
            }
            return false;
        }
        
    }



    /**
     * Multi Base_64 encoding
     *
     * @param [MIXTE] $v
     * @return string
     */
    public function encode($v)
    {
        return base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($v))))));
    }



    /**
     * Decode Multi Base_64 encoding
     *
     * @param [String] $v
     * @return mixte
     */
    public function decode($v)
    {
        return base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($v))))));
    }



    /**
     * Create unic token
     *
     * @return String
     */
    public function salt()
    {
        return $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
    }




    // Create salted password 
    public function pass($pass, $salt)
    {
        return $password = hash('sha512', $pass . $salt);
    }


    /**
     * User login systeme
     *
     * @param [string] $email
     * @param [string] $password
     * @return mixte
     */
    public function login($email, $password)
    { 
        $stmt = $this->query("SELECT 
                                membre.idmembre,
                                membre.statut statut_membre,
                                membre.telephone,
                                membre.photo,
                                login.email mail,
                                login.password pass, 
                                login.salt,
                                login.statut statut_login, 
                                groupe.idgroupe, 
                                groupe.groupe,
                                groupe.level
                                FROM membre
                                INNER JOIN login 
                                INNER JOIN groupe
                                WHERE login.email = ?
                                AND membre.idgroupe = groupe.idgroupe 
                                AND membre.email = login.email
                                LIMIT 1",
        [$email],
        true
        );

        if ($stmt) {
            // hash the password with the unique salt.
            $password = hash('sha512', $password . $stmt->salt);
            // Check if the password in the database matches
            // the password the user submitted.
            if ($stmt->pass == $password) {
                // Password is correct!
                // Verification son role
                if (!in_array($stmt->level, array(10, 11, 20, 30, 40, 50, 60, 70, 80, 90, 100))) {
                    return $this->error("Le rôle n'existe pas...");
                    exit();
                }
                // Si compte desactivé
                // Si compte bloqué
                if ($stmt->statut_membre == 0) {
                    return $this->error("Ce compte est bloqué. Veuillez contacter l'administrateur.");
                    exit();
                }
                // Get the user-agent string of the user.
                $user_browser = $_SERVER['HTTP_USER_AGENT'];
                // XSS protection as we might print this value
                $user_id = preg_replace("/[^0-9]+/", "", $stmt->idmembre);
                $_SESSION["auth"]['user_id'] = +$user_id;
                // XSS protection as we might print this value
                $email = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $stmt->mail);
                $idfonction = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $stmt->level);
                $_SESSION["auth"]['email'] = $email;
                $_SESSION["auth"]['idfonction'] = +$idfonction;

                $user = $this->findChamById("*",$user_id);
                $new_user = new Membre();

                $_SESSION["user"]["idmembre"] = $user->idmembre;
                $_SESSION["user"]["nom"] = $user->nom;
                $_SESSION["user"]["prenom"] = $user->prenom;
                $_SESSION["user"]["email"] = $user->email;
                $_SESSION["user"]["telephone"] = $user->telephone;
                $_SESSION["user"]["groupe"] = $new_user->findGroupe($stmt->idgroupe);
                $_SESSION["user"]["photo"] = $user->photo;
                // JETON 
                //$_SESSION['token'] = $token; // TOKEN existe dans la Securité.php
                $_SESSION["auth"]['token_time'] = time(); // Fin jeton
                $_SESSION["auth"]['login_string'] = hash('sha512', $password . $user_browser);

                if($stmt->statut_login == 1)
                {
                    $first_login = "0";
                }else{
                    $first_login = "1";
                }

                // Login successful.
                if($stmt->level == 10)
                {
                    return $this->redirect("succès",'/admin', $first_login);
                }

                if($stmt->level == 20)
                {
                    return $this->redirect("succès",'/manager', $first_login);
                }

                if($stmt->level == 30)
                {
                    return $this->redirect("succès",'/gestionnaire', $first_login);
                }

                if($stmt->level == 40)
                {
                    return $this->redirect("succès",'/comptable', $first_login);
                }
                exit();

            } else {
                // Password is not correct
                return $this->error("Mot de passe incorrecte");
                exit();
            }
        } else {
            return $this->error("Email ou mot de passe incorrecte");
            exit();
        }
    }


    public function haschBruteEncode($string)
    {
        $myHash = str_split($string);
        $hash = "";

        foreach ($myHash as $key => $value) {
            $hash .= '#$ '.base64_encode($value).' *#';
        }

        return $this->encode($hash);
    }

    public function haschBrutedecode($HashedString)
    {
        $HashedString =(string) $this->decode($HashedString);
        $HashedString = explode('#$',$HashedString);
        $str = "";

        foreach ($HashedString as $value) {
            $str .= base64_decode($value);
        }
        
        //var_dump($HashedString);
        return ($str);
    }

    public function MyHash($string)
    {
        $lower =
        [
            'a' => '6g51e',
            'b' => '1g6e4r',
            'c' => 'gerg46',
            'd' => 'vs78',
            'e' => 'uku564',
            'f' => 'F645GB6E',
            'g' => 'H46RT64H',
            'h' => '54G56GV',
            'i' => 'F54G165FE',
            'j' => 'FEBGE4',
            'k' => 'FD6GR4V',
            'l' => 'DS5F4G6Z',
            'm' => 'EZFG465',
            'n' => 'vd4q4XZ',
            'o' => '64fv6ef',
            'p' => 'Q65Q4SF',
            'q' => '654FSQ',
            'r' => '65SQ4FC',
            's' => '5FD+QC',
            't' => '654DSV',
            'u' => '+S64QDd',
            'v' => '464ger)àç=',
            'w' => 'uè(i_-k',
            'x' => 'f4gbv4789',
            'y' => 'rg65e6è',
            'z' => '*ùùa'
        ];


        $upper = 
        [
            'A' => '67544',
            'B' => '87964',
            'C' => '2189',
            'D' => '6545465',
            'E' => '65456132',
            'F' => '4654',
            'G' => '845654',
            'H' => '654564',
            'I' => '654665',
            'J' => '564564',
            'K' => '5642',
            'L' => '65131',
            'M' => '131',
            'N' => '6546',
            'O' => '97978',
            'P' => '5646',
            'Q' => '7464',
            'R' => '8789',
            'S' => '646',
            'T' => '56546',
            'U' => '564654',
            'V' => '5643',
            'W' => '6565465',
            'X' => '5343',
            'Y' => '3131',
            'Z' => '54354'
        ];

        $number = [
            
            '0' => 'tn,',
            '1' => '§:',
            '2' => 'rgt',
            '3' => 'g',
            '4' => 'awq',
            '5' => 'ytr',
            '6' => 'yutyu',
            '7' => 'berne',
            '8' => ':fqsù',
            '9' => 't-uli'
        ];
        $_string = str_split($string);
        $paswd = "";
        foreach ($_string as $key => $value) {
            if(array_key_exists($value,$lower)){
                var_dump($value."=>".$lower[$value]);
                if($key==0){
                    $paswd .=$lower[$value];
                }else{
                   $paswd .= '-'.$lower[$value]; 
                }
               
                

            }
        } 
        var_dump(strpos($paswd,'-',0));
        var_dump("My password: ".$paswd);
        //die('yes');
        for($i=0; $i<count($_string); $i++){
            for($j=0;$j<count($lower);$j++){
                if(in_array($key,$_string)){
                    var_dump($key."=>".$string[$i]);
                       
                }
            }
            
        }
         die('yes');
        
    }





    /**
     * Control image
     *
     * @param [file] $file
     * @param [string] $name
     * @return void
     */
    public function traiteImage($file,$name){
        //
        //var_dump($file);
        if(isset($file[$name]) && !empty($file[$name]['tmp_name'])){
                $chemin =$file[$name]['tmp_name'];  // chemin de l'image
                $infos_image = @getImageSize($chemin); // info sur la dimension de l'image
                // '@' est placé devant la fonction getImageSize()pour empêcher l'affichage
                // des erreurs si l'image est absente.         
                //dimension 
                $largeur = $infos_image[0]; // largeur de l'image
                $hauteur = $infos_image[1]; // hauteur de l'image
                $type    = $infos_image[2]; // Type de l'image
                $html    = $infos_image[3]; // info html de type width="468" height="60"
                //echo "Largeur: ".$largeur; // affiche la hauteur
                //echo "Hauteur ".$hauteur; // affiche la largeur
                //echo "Type ".$type; 
                // Type de l'image 1 = GIF, 2 = JPG,3 = PNG, 4 = SWF, 5 = PSD,
                            // 6 = BMP, 7 = TIFF, 8 = TIFF, 9 = JPC, 10 = JP2, 11 = JPX,
                            // 12 = JB2, 13 = SWC, 14 = IFF....
                              
                if($type!=2 && $type!=3){
                   return $this->error("Selectionner une image de type (<b>png ou jpg</b>)");
                }
                //
                 $_lar = self::LARGEUR;
                //
                if($largeur>$_lar){
                    return $this->error("Désolé, veuillez traiter votre image, la largeur doit être inférieur ou à ".$this->larg);
                }
                //
                $_haut = self::HAUTEUR;
                if($hauteur>>$_haut){
                    return $this->error("Désolé, veuillez traiter votre image, la hauteur doit être inférieur ou à ".$this->haut);
                } 
                //
                return true;
        
        
                
        }else{
            //veuillez selectionner une image
            return false;
        
        }
        //
    }



    /**
     * Move file to directory
     *
     * @param [directory] $content_dir
     * @param [file] $file
     * @param [string] $name
     * @return void
     */
    public function moveFile($content_dir,$file,$name){
        $tmp_file = $file[$name]['tmp_name'];
        $name_file = $file[$name]['name'];
    
        if(move_uploaded_file($tmp_file, $content_dir . $name_file) )
        {
            return true;
        }
    }


    // detecter le navigateur
    public function detect_browser()
    {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        $browser = "Inconnu";
        $browser_array = [
            "mobile" => 'Handheld Browser',
            "msie" => 'Internet Explorer',
            "trident" => 'Internet Explorer',
            "firefox" => 'Firefox',
            "safari" => 'Safari',
            "Chrome" => 'Chrome',
            "edg" => 'Edge',
            "opera" => 'Opera',
            "netscape" => 'Netscape',
            "maxthon" => 'Maxthon',
            "konqueror" => 'Konqueror'
        ];

        foreach ($browser_array as $regex => $value) {
            if(preg_match("/".$regex."/i", $user_agent))
            {
                $browser = $value;
            }

            
        }
        return $browser;
    }


    // recuperer l'adresse ip
    public function get_ip()
    {
        // si la connexion est partagé 
        if(isset($_SERVER["HTTP_CLIENT_IP"]))
        {
            return $_SERVER["HTTP_CLIENT_IP"];
        }
        
        // si est connecté avec proxy
        if(isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
        {
            return $_SERVER["HTTP_X_FORWARDED_FOR"];
        }

        // ip normal
        return $_SERVER["REMOTE_ADDR"] ?? false;
    }





}
