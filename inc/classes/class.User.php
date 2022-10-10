<?php

class User {

    private $acronyme;
    private $identite;            // données personnelles

    // --------------------------------------------
    // fonction constructeur
    public function __construct($acronyme = null)
    {
        if (isset($acronyme)) {
            $this->acronyme = $acronyme;
            $this->applicationName = APPLICATION;
            $this->identite = $this->getIdentite();
        }
    }
    /**
     * retourne toutes les informations de la table des utilisateurs pour l'utilisateur actif.
     *
     * @param void
     *
     * @return array
     */
    public function getIdentite() {
        $connexion = Application::connectPDO(SERVEUR, BASE, NOM, MDP);
        $sql = 'SELECT acronyme, nom, prenom, mail, statut, adresse, cpostal, commune, telephone ';
        $sql .= 'FROM '.PFX.'users ';
        $sql .= 'WHERE acronyme = :acronyme ';
        $requete = $connexion->prepare($sql);

        $requete->bindParam(':acronyme', $this->acronyme, PDO::PARAM_STR, 7);

        $this->identite = array();
        $resultat = $requete->execute();
        if ($resultat) {
            $requete->setFetchMode(PDO::FETCH_ASSOC);
            $this->identite = $requete->fetch();
        }
        Application::DeconnexionPDO($connexion);

        return $this->identite;
    }

    /**
     * renvoie les informations d'identification réseau de l'utilisateur courant.
     *
     * @param void
     *
     * @return array ip, hostname, date, heure
     */
    public static function getIdentification() {
        $data = array();
        $data['ip'] = $_SERVER['REMOTE_ADDR'];
        $data['hostname'] = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        $data['date'] = date('d/m/Y');
        $data['heure'] = date('H:i');

        return $data;
    }

    /**
     * une fonction qui retourne l'acronyme de l'utilisateur.
     *
     * @param void
     *
     * @return string
     */
    public function getAcronyme() {
        return $this->acronyme;
    }

    /**
     * renvoie le passwd md5 de l'utilisateur dont on fournit l'acronyme
     *
     * @param string $acronyme
     *
     * @return string
     */
    public function getPasswd($acronyme){
        $connexion = Application::connectPDO(SERVEUR, BASE, NOM, MDP);
        $sql = 'SELECT acronyme, passwd ';
        $sql .= 'FROM '.PFX.'passwd ';
        $sql .= 'WHERE acronyme = :acronyme ';
        $requete = $connexion->prepare($sql);

        $requete->bindParam(':acronyme', $acronyme, PDO::PARAM_STR, 7);

        $resultat = $requete->execute();
        $passwd = Null;
        if ($resultat){
            $requete->setFetchMode(PDO::FETCH_ASSOC);
            $ligne = $requete->fetch();
            $passwd = $ligne['passwd'];
        }

        Application::deconnexionPDO($connexion);

        return $passwd;
    }

    /**
     * vérifie que l'utilisateur dont on fournit l'acronyme et le mail
     * existe dans la table des utilisateurs
     *
     * @param string $acronyme
     *
     * @return bool : l'acronyme a été trouvé dans la BD
     */
    public static function userExists($acronyme) {
        $connexion = Application::connectPDO(SERVEUR, BASE, NOM, MDP);
        $sql = 'SELECT acronyme FROM '.PFX.'users ';
        $sql .= 'WHERE acronyme = :acronyme ';
        $requete = $connexion->prepare($sql);

        $requete->bindParam(':acronyme', $acronyme, PDO::PARAM_STR, 7);

        $ligne = Null;
        $resultat = $requete->execute();
        if ($resultat) {
            $requete->setFetchMode(PDO::FETCH_ASSOC);
            $ligne = $requete->fetch();
        }
        Application::DeconnexionPDO($connexion);

        $acronyme = isset($ligne['acronyme']) ? $ligne['acronyme'] : Null;

        return ($acronyme != Null);
    }

    /**
     * ajout de l'utilisateur dans le journal des logs.
     *
     * @param string $acronyme	: acronyme de l'utilisateur
     *
     * @return int: le nombre d'insertions
     */
    public function logger($acronyme) {
        $ip = $_SERVER['REMOTE_ADDR'];
        $hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        $user = $acronyme;

        $connexion = Application::connectPDO(SERVEUR, BASE, NOM, MDP);
        $sql = 'INSERT INTO '.PFX.'logins ';
        $sql .= 'SET acronyme = :acronyme, date = CURRENT_TIMESTAMP, ip = :ip, hostname = :hostname ';
        $requete = $connexion->prepare($sql);

        $requete->bindParam(':acronyme', $acronyme, PDO::PARAM_STR, 7);
        $requete->bindParam(':ip', $ip, PDO::PARAM_STR, 45);
        $requete->bindParam(':hostname', $hostname, PDO::PARAM_STR, 60);

        $resultat = $requete->execute();

        $nb = $requete->rowCount();

        Application::DeconnexionPDO($connexion);

        return $nb;
    }

    /**
     * enregistrement des données provenant d'un utilisateur lambda.
     *
     * @param array $post : données provenant d'un formulaire
     *
     * @return int : nombre d'enregistrements réussis dans la BD (en principe, 1 ou 0)
     */
    public function saveUserdata($post) {
        $acronyme = isset($post['acronyme']) ? $post['acronyme'] : Null;
        $mail = isset($post['mail']) ? $post['mail'] : Null;
        $nom = isset($post['nom']) ? $post['nom'] : Null;
        $prenom = isset($post['prenom']) ? $post['prenom'] : Null;
        $statut = isset($post['statut']) ? $post['statut'] : 'user';
        $adresse = isset($post['adresse']) ? $post['adresse'] : Null;
        $cpostal = isset($post['cpostal']) ? $post['cpostal'] : Null;
        $commune = isset($post['commune']) ? $post['commune'] : Null;
        $telephone = isset($post['telephone']) ? $post['telephone'] : Null;

        $connexion = Application::connectPDO(SERVEUR, BASE, NOM, MDP);
        $sql = 'INSERT INTO '.PFX.'users ';
        $sql .= 'SET acronyme = :acronyme, nom = :nom, prenom = :prenom, mail = :mail, adresse = :adresse, ';
        $sql .= 'cpostal = :cpostal, commune = :commune, telephone = :telephone, statut = :statut ';
        $sql .= 'ON DUPLICATE KEY UPDATE ';
        $sql .= 'nom = :nom, prenom = :prenom, mail = :mail, adresse = :adresse, ';
        $sql .= 'cpostal = :cpostal, commune = :commune, telephone = :telephone, statut = :statut ';
        $requete = $connexion->prepare($sql);

        $requete->bindParam(':acronyme', $acronyme, PDO::PARAM_STR, 7);
        $requete->bindParam(':nom', $nom, PDO::PARAM_STR, 40);
        $requete->bindParam(':prenom', $prenom, PDO::PARAM_STR, 40);
        $requete->bindParam(':mail', $mail, PDO::PARAM_STR, 60);
        $requete->bindParam(':adresse', $adresse, PDO::PARAM_STR, 60);
        $requete->bindParam(':cpostal', $cpostal, PDO::PARAM_STR, 5);
        $requete->bindParam(':commune', $commune, PDO::PARAM_STR, 40);
        $requete->bindParam(':telephone', $telephone, PDO::PARAM_STR, 15);
        $requete->bindParam(':statut', $statut, PDO::PARAM_STR, 5);

        $resultat = $requete->execute();

        Application::DeconnexionPDO($connexion);

        $nb = $requete->rowCount();

        return $nb;
    }

    /**
     * Enregistrement du mot de passe de l'utilisateur
     *
     * @param string $acronyme
     * @param string $passwd : le mot de passe en clair
     *
     * @return int : le nombre d'enregistrements
     */
    public function savePasswd ($acronyme, $passwd){
        $connexion = Application::connectPDO(SERVEUR, BASE, NOM, MDP);
        $sql = 'INSERT INTO '.PFX.'passwd ';
        $sql .= 'SET acronyme = :acronyme, passwd = :passwd ';
        $sql .= 'ON DUPLICATE KEY UPDATE ';
        $sql .= 'passwd = :passwd ';
        $requete = $connexion->prepare($sql);

        $passwd = md5($passwd);
        $requete->bindParam(':acronyme', $acronyme, PDO::PARAM_STR, 7);
        $requete->bindParam(':passwd', $passwd, PDO::PARAM_STR, 40);

        $resultat = $requete->execute();

        Application::DeconnexionPDO($connexion);

        $nb = $requete->rowCount();
        $nb = ($nb == 2) ? 1 : $nb;

        return $nb;
    }

    /**
     * renvoie l'adresse mail de l'utilisateur courant.
     */
    public function getMail() {
        return $this->identite['mail'];
    }

    /**
     * renvoie le nom et le prénom de l'utilisateur.
     *
     * @param void
     *
     * @return array : 'nom'=>$nom, 'prenom'=>$prenom
     */
    public function getNom() {
        $nom = $this->identite['nom'];
        $prenom = $this->identite['prenom'];

        return array('nom' => $nom, 'prenom' => $prenom);
    }

    /**
     * renvoie les informations d'identification réseau de l'utilisateur courant.
     *
     * @param
     *
     * @return array ip, hostname, date, heure
     */
    public static function identiteReseau() {
        $data = array();
        $data['ip'] = $_SERVER['REMOTE_ADDR'];
        $data['hostname'] = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        $data['date'] = date('d/m/Y');
        $data['heure'] = date('H:i');

        return $data;
    }

    /**
     * renvoie l'adresse IP de connexion de l'utilisateur actuel.
     *
     * @param
     *
     * @return string
     */
    public function getIP() {
        $data = $this->identiteReseau();
        return $data['ip'];
    }

    /**
     * renvoie le nom de l'hôte correspondant à l'IP de l'utilisateur en cours.
     *
     * @param
     *
     * @return string
     */
    public function getHostname() {
        $data = $this->identiteReseau();

        return $data['hostname'];
    }

    /**
     * renvoie la liste des logs de l'utilisateur en cours.
     *
     * @param string $acronyme
     *
     * @return array
     */
    public function getLogins() {
        $connexion = Application::connectPDO(SERVEUR, BASE, NOM, MDP);
        $sql = 'SELECT * FROM '.PFX.'logins ';
        $sql .= 'WHERE acronyme = :acronyme ';
        $sql .= 'ORDER BY date ASC ';
        $requete = $connexion->prepare($sql);

        $acronyme = $this->getAcronyme();

        $requete->bindParam(':acronyme', $acronyme, PDO::PARAM_STR, 7);

        $resultat = $requete->execute();
        $logins = array();
        if ($resultat) {
            $requete->setFetchMode(PDO::FETCH_ASSOC);
            $logins = $requete->fetchall();
        }

        Application::DeconnexionPDO($connexion);

        return $logins;
    }

    /**
     * retourne toutes les informations d'identité d'un utilisateur
     * quelconque dont on fournit l'acronyme.
     *
     * @param string $acronyme
     *
     * @return array
     */
    public function getIdentiteUser($acronyme) {
        $connexion = Application::connectPDO(SERVEUR, BASE, NOM, MDP);
        $sql = 'SELECT acronyme, nom, prenom, statut, mail, adresse, cpostal, commune, telephone ';
        $sql .= 'FROM '.PFX.'users ';
        $sql .= 'WHERE acronyme = :acronyme ';
        $requete = $connexion->prepare($sql);

        $requete->bindParam(':acronyme', $acronyme, PDO::PARAM_STR, 7);

        $ligne = array();
        $resultat = $requete->execute();
        if ($resultat) {
            $requete->setFetchMode(PDO::FETCH_ASSOC);
            $requete->bindParam(':acronyme', $acronyme, PDO::PARAM_STR, 7);
            $ligne = $requete->fetch();
        }
        Application::DeconnexionPDO($connexion);

        return $ligne;
    }


    /**
     * retourne $acronyme et $mail de l'utilisateur dont le mail est $mail
     * 
     * @param string $mail
     * 
     * @return bool
     */
    public function getIdentite4mail($mail) {
        $connexion = Application::connectPDO(SERVEUR, BASE, NOM, MDP);
        $sql = 'SELECT mail, acronyme ';
        $sql .= 'FROM '.PFX.'users ';
        $sql .= 'WHERE mail = :mail LIMIT 1';
        $requete = $connexion->prepare($sql);

        $requete->bindParam(':mail', $mail, PDO::PARAM_STR, 60);

        $resultat = $requete->execute();
        $requete->setFetchMode(PDO::FETCH_ASSOC);
        $ligne = $requete->fetch();

        Application::DeconnexionPDO($connexion);

        return $ligne;
    }

    /**
     * retourne $acronyme et $mail de l'utilisateur dont le mail est $mail
     * 
     * @param string $mail
     * 
     * @return bool
     */
    public function getIdentite4acronyme($acronyme) {
        $connexion = Application::connectPDO(SERVEUR, BASE, NOM, MDP);
        $sql = 'SELECT mail, acronyme ';
        $sql .= 'FROM '.PFX.'users ';
        $sql .= 'WHERE acronyme = :acronyme LIMIT 1';
        $requete = $connexion->prepare($sql);

        $requete->bindParam(':acronyme', $acronyme, PDO::PARAM_STR, 7);

        $resultat = $requete->execute();
        $requete->setFetchMode(PDO::FETCH_ASSOC);
        $ligne = $requete->fetch();

        Application::DeconnexionPDO($connexion);

        return $ligne;
    }



    /**
     * nettoie tous les tokens plus anciens que 24 heures dans la table lostPasswd
     *
     * @param void
     *
     * @return int : nombre de suppressions
     */
    public function clearTokens(){
        $connexion = Application::connectPDO(SERVEUR, BASE, NOM, MDP);
        $sql = 'DELETE FROM '.PFX.'lostPasswd ';
        $sql .= 'WHERE date < DATE_SUB(NOW(), INTERVAL 24 HOUR) ';
        $requete = $connexion->prepare($sql);

        $resultat = $requete->execute();

        $nb = $requete->rowCount();

        Application::deconnexionPDO($connexion);

        return $nb;
        }

    /**
     * supprime les tokens de l'utilisateur $acronyme
     *
     * @param string $acronyme
     *
     * @return int
     */
    public function clearToken($acronyme){
        $connexion = Application::connectPDO(SERVEUR, BASE, NOM, MDP);
        $sql = 'DELETE FROM '.PFX.'lostPasswd ';
        $sql .= 'WHERE acronyme = :acronyme ';
        $requete = $connexion->prepare($sql);

        $requete->bindParam(':acronyme', $acronyme, PDO::PARAM_STR, 7);

        $resultat = $requete->execute();

        $nb = $requete->rowCount();

        Application::deconnexionPDO($connexion);

        return $nb;
    }

    /**
     * Création d'un lien enregistré dans la base de données pour la récupération du mdp
     *
     * @param void
     *
     * @return string
     */
    public function createPasswdLink($acronyme) {
        $connexion = Application::connectPDO(SERVEUR, BASE, NOM, MDP);
        $sql = 'INSERT INTO '.PFX.'lostPasswd ';
        $sql .= 'SET acronyme = :acronyme, token = :link, date = NOW() + INTERVAL 2 DAY ';
        $sql .= 'ON DUPLICATE KEY UPDATE token = :link, date = NOW() + INTERVAL 2 DAY ';
        $requete = $connexion->prepare($sql);

        $link = md5(microtime());
        $requete->bindParam(':link', $link, PDO::PARAM_STR, 40);
        $requete->bindParam(':acronyme', $acronyme, PDO::PARAM_STR, 7);

        $resultat = $requete->execute();

        Application::DeconnexionPDO($connexion);

        return $link;
    }

    /**
     * retrouve l'utilisateur correspondant à un token dans la table des lostPasswd
     *
     * @param string $token
     *
     * @return array
     */
    public function getUser4token($acronyme, $token){
        $connexion = Application::connectPDO(SERVEUR, BASE, NOM, MDP);
        $sql = 'SELECT lost.acronyme, nom, prenom, statut, mail ';
        $sql .= 'FROM '.PFX.'lostPasswd AS lost ';
        $sql .= 'LEFT JOIN '.PFX.'users AS users ON users.acronyme = lost.acronyme ';
        $sql .= 'WHERE token = :token AND lost.acronyme = :acronyme ';
        $requete = $connexion->prepare($sql);

        $requete->bindParam(':token', $token, PDO::PARAM_STR, 40);
        $requete->bindParam(':acronyme', $acronyme, PDO::PARAM_STR, 7);

        $identite = Null;
        $resultat = $requete->execute();
        if ($resultat){
            $requete->setFetchMode(PDO::FETCH_ASSOC);
            $identite = $requete->fetch();
        }

        Application::deconnexionPDO($connexion);

        return $identite;
    }


        /**
         * Envoie un mail d'alerte à l'utilisateur et aux admins.
         *
         * @param string $acronyme : identifiant de l'utilisateur
         * @param object $user	: l'objet "utilisateur"
         * @param string $type	: type d'alerte
         * @param array $data : données supplémentaires sous forme d'array
         *
         * @return bool
         */
        public function mailAlerte($acronyme, $User, $type, $data = null) {
            // liste des mails des administrateurs
            $listeMailing = $this->getUsersByStatus('admin');
            // infos réseau
            $identification = $this->getIdentification();
            $ip = $identification['ip'];
            $hostname = $identification['hostname'];
            // info perso
            $userMail = $User->getMail();

            setlocale(LC_TIME, 'fra_fra');
            $jSemaine = strftime('%A');
            $date = date('d/m/Y');
            $heure = date('H:i');

            switch ($type) {
                case 'mdp':
                    $sujet = sprintf(ERREURLOGIN, TITRECOURT);
                    $texteAdmin = sprintf(ERREURLOGINADMIN, $acronyme, $data, $jSemaine, $date, $heure, $ip, $hostname, $userMail);
                    if ($User->userExists($acronyme)) {
                        $texteUser = sprintf(ERREURLOGINUSER, $acronyme, $data, $jSemaine, $date, $heure, TITRECOURT, $ip, $hostname);
                    }
                    break;
                case 'newIP':
                    $sujet = sprintf(NOUVELLEIP, TITRECOURT);
                    $texteAdmin = sprintf(NOUVELLEIPADMIN, $ip, $hostname, $acronyme, $jSemaine, $date, $heure, $userMail);
                    if ($User->userExists($acronyme)) {
                        $texteUser = sprintf(NOUVELLEIPUSER, $ip, $hostname, $jSemaine, $date, $heure, TITRECOURT);
                    }
                    break;
                default:
                    //don't care
                    break;
                }
            $mail = new PHPmailer();
            $mail->IsHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->From = MAILADMIN;
            $mail->FromName = ADMINNAME;
            $envoiMail = true;
            // avertir les administrateurs
            foreach ($listeMailing as $admin) {
                $mail->AddAddress($admin['mail']);
                $mail->Subject = $sujet;
                $mail->Body = $texteAdmin;
            }
            $envoiMail = !$mail->Send();

            // prévenir l'utilisateur
                if ($userMail) {
                    $mail->ClearAddresses();
                    $mail->AddAddress($userMail);
                    $mail->Body = $texteUser;
                    $envoiMail = $mail->Send();
                }

            return $envoiMail;
        }

        /**
         * renvoie la liste des utilisateurs pour un statut donné (admin ou user)
         *
         * @param string $statut
         *
         * @return array
         */
        public function getUsersByStatus($statut) {
            $connexion = Application::connectPDO(SERVEUR, BASE, NOM, MDP);
            $sql = 'SELECT acronyme, nom, prenom, mail, statut ';
            $sql .= 'FROM '.PFX.'users ';
            $sql .= 'WHERE statut = :statut ';
            $sql .= 'ORDER BY acronyme ';
            $requete = $connexion->prepare($sql);

            $requete->bindParam(':statut', $statut, PDO::PARAM_STR, 5);

            $liste = Null;
            $resultat = $requete->execute();
            if ($resultat){
                $requete->setFetchMode(PDO::FETCH_ASSOC);
                while ($ligne = $requete->fetch()){
                    $acronyme = $ligne['acronyme'];
                    $liste[$acronyme] = $ligne;
                }
            }

            Application::deconnexionPDO($connexion);

            return $liste;
        }

 
    /**
     * Vérifie la force d'un mot de passe
     * 
     * @param string $passwd
     * 
     * @return bool
     */
    public function verifPasswdStrength($passwd) {
        preg_match_all('/[A-Za-z]/', $passwd, $letters);
        preg_match_all('/[0-9]/', $passwd, $numbers);

        return ((count($letters[0]) >= 2) && (count($numbers[0]) >= 2));
            // return 1;
            // else return 0;
        }
}
