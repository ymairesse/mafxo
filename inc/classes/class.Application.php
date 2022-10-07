<?php

require_once INSTALL_DIR.'/phpMailer/class.phpmailer.php';

class Application {

    public function __construct()
    {
        self::lireConstantes();
        // sorties PHP en français
        setlocale(LC_ALL, 'fr_FR.utf8');
    }

    /**
     * relire les constantes de l'application
     *
     * @param void
     *
     * @return array : constantes globales
     */
    public static function lireConstantes() {
        // lecture des paramètres généraux dans le fichier .ini, y compris la constante "PFX"
        $constantes = parse_ini_file(INSTALL_DIR.'/config.ini');
        foreach ($constantes as $key => $value) {
            define("$key", $value);
        }

        // lecture dans la table PFX."config" de la BD
        $connexion = self::connectPDO(SERVEUR, BASE, NOM, MDP);
        $sql = 'SELECT parametre, valeur ';
        $sql .= 'FROM '.PFX.'config ';
        $requete = $connexion->prepare($sql);

        $resultat = $requete->execute();
        if ($resultat) {
            while ($ligne = $requete->fetch()) {
                $key = $ligne['parametre'];
                $valeur = $ligne['valeur'];
                define("$key", $valeur);
            }
        } else {
            die('config table not present');
        }
        self::DeconnexionPDO($connexion);
    }

    /**
     * afficher proprement le contenu d'une variable précisée
     * le programme est éventuellement interrompu si demandé.
     *
     * @param :    $data n'importe quel tableau ou variable
     * @param bool $die  : si l'on souhaite interrompre le programme avec le dump
     *
     * @return string
     */
    public static function afficher($data, $die = false) {
        if (func_num_args() > 0) {
            $data = func_get_args();
        }

        foreach ($data as $wtf => $unData) {
            echo '<pre>';
            var_export($unData);
            echo '</pre>';
        }
        if ($die == true) {
            die();
        }
    }
    public static function afficherSilent($data, $die = false) {
        foreach ($data as $wtf => $unData) {
            echo '<!-- ';
            echo '<pre>';
            var_export($unData);
            echo '</pre>';
            echo ' -->';
        }
        if ($die == true) {
            die();
        }
    }

    /**
     * Connexion à la base de données précisée.
     *
     * @param string PARAM_HOST : serveur hôte
     * @param string PARAM_BD : nom de la base de données
     * @param string PARAM_USER : nom d'utilisateur
     * @param string PARAM_PWD : mot de passe
     *
     * @return connexion à la BD
     */
    public static function connectPDO($host, $bd, $user, $mdp)
    {
        try {
            // indiquer que les requêtes sont transmises en UTF8
            // INDISPENSABLE POUR EVITER LES PROBLEMES DE CARACTERES ACCENTUES
            $connexion = new PDO('mysql:host='.$host.';dbname='.$bd, $user, $mdp,
                                array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
        } catch (Exception $e) {
            $date = date('d/m/Y H:i:s');
            echo "<style type='text/css'>";
            echo '.erreurBD {width: 500px; margin-left: auto; margin-right: auto; border: 1px solid red; padding: 1em;}';
            echo '.erreurBD .erreur {color: green; font-weight: bold}';
            echo '</style>';

            echo "<div class='erreurBD'>";
            echo '<h3>A&iuml;e, a&iuml;e, a&iuml;e... Caramba...</h3>';
            echo "<p>Une erreur est survenue lors de l'ouverture de la base de donn&eacute;es.<br>";
            echo "Si vous &ecirc;tes l'administrateur et que vous tentez d'installer le logiciel, veuillez v&eacute;rifier le fichier config.inc.php </p>";
            echo "<p>Si le probl&egrave;me se produit durant l'utilisation r&eacute;guli&egrave;re du programme, essayez de rafra&icirc;chir la page (<span style='color: red;'>touche F5</span>)<br>";
            echo "Dans ce cas, <strong>vous n'&ecirc;tes pour rien dans l'apparition du souci</strong>: le serveur de base de donn&eacute;es est sans doute trop sollicit&eacute;...</p>";
            echo "<p>Veuillez rapporter le message d'erreur ci-dessous &agrave; l'administrateur du syst&egrave;me.</p>";
            echo "<p class='erreur'>Le $date, le serveur dit: ".$e->getMessage().'</p>';
            echo '</div>';
            die();
        }

        return $connexion;
    }

    /**
     * Déconnecte la base de données.
     *
     * @param $connexion
     */
    public static function DeconnexionPDO($connexion) {
        $connexion = null;
    }

    /**
     * renvoie les informations d'identification réseau
     *
     * @param void
     *
     * @return array ip, hostname, date, heure
     */
    public function getNetid() {
        $data = array();
        $data['ip'] = $_SERVER['REMOTE_ADDR'];
        $data['hostname'] = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        $data['date'] = date('d/m/Y');
        $data['heure'] = date('H:i');

        return $data;
    }

    /**
     * renvoie "true" si l'adresse IP est déjà connue dans la table des logins pour cet utilisateur.
     *
     * @param string $ip	: adresse IP
     * @param string $user	: nom de l'utilisateur
     *
     * @return int
     */
    public function checkIP($ip, $acronyme) {
        $connexion = self::connectPDO(SERVEUR, BASE, NOM, MDP);
        $sql = 'SELECT COUNT(*) AS nb ';
        $sql .= 'FROM '.PFX.'logins ';
        $sql .= 'WHERE ip = :ip AND UPPER(acronyme) = :acronyme ';
        $requete = $connexion->prepare($sql);

        $requete->bindParam(':ip', $ip, PDO::PARAM_STR, 45);
        $requete->bindParam(':acronyme', $acronyme, PDO::PARAM_STR, 7);

        $nb = 0;
        $resultat = $requete->execute();
        if ($resultat) {
            $ligne = $requete->fetch();
            $nb = $ligne['nb'];
        }
        self::deconnexionPDO($connexion);

        return $nb;
        }

    /**
     * calcule l'acronyme sur base du nom et du prénom
     * 
     * @param string $nom
     * @param string $prenom
     * 
     * @return string
     */
    public function acronyme4nomPrenom($nom, $prenom){
        $nom = mb_strtolower(str_replace(' ','', $nom), 'UTF-8');
        $prenom = mb_strtolower(str_replace(' ','', $prenom), 'UTF-8');

        $acronyme = mb_substr($nom, 0, 3).mb_substr($prenom, 0, 3);
        $acronyme = $acronyme.mb_substr('123456', 0, 6 - mb_strlen($acronyme));

        return $acronyme;
    }


    /**
     * renvoie le nom du mois en français depuis le numéro du mois
     * 
     * @param int $month
     * 
     * @return string
     */
    public function monthName ($month){
        $listeMois = [
            1 => 'Janvier', 
            2 => 'Février', 
            3 => 'Mars', 
            4 => 'Avril', 
            5 => 'Mai', 
            6 => 'Juin', 
            7 => 'Juillet', 
            8 => 'Août', 
            9 => 'Septembre', 
            10 => 'Octobre', 
            11 => 'Novembre', 
            12 => 'Décembre'];

        return $listeMois[$month];
    }

    /**
     * renvoie les noms des jours de la semaine en français
     * 
     * @param void
     * 
     * @return array
     */
    public function getDaysName (){
        $daysOfWeek = array(
            1 => 'Lundi',
            2 => 'Mardi',
            3 => 'Mercredi',
            4 => 'Jeudi',
            5 => 'Vendredi',
            6 => 'Samedi',
            7 => 'Dimanche'
        );
        return $daysOfWeek;
    }

    /**
     * recherche des inscriptions au calendrier pour le mois $month de l'année $year
     * 
     * @param int $month : numéro du mois
     * @param int $year : millésime
     * @param string $acronyme : limitation  éventuelle à l'utilisateur $acronyme
     * 
     * @return array
     */
    public function getInscriptions ($yearMonth, $acronyme=Null){
        $connexion = self::connectPDO(SERVEUR, BASE, NOM, MDP);
        $sql = 'SELECT date, periode, acronyme, multi, dateInscription, confirme ';
        $sql .= 'FROM '.PFX.'calendar as calendar ';
        $sql .= 'WHERE date LIKE :yearMonth ';
        if ($acronyme != Null)
            $sql .= 'AND acronyme = :acronyme ';
        $sql .= 'ORDER BY date, periode, dateInscription ';

        $requete = $connexion->prepare($sql);

        // mois sous la forme YYYYY-MM (avec deux signes pour le mois)
        $yearMonth = $yearMonth.'%';

        $requete->bindParam(':yearMonth', $yearMonth, PDO::PARAM_STR, 7);
        if ($acronyme != Null)
            $requete->bindParam(':acronyme', $acronyme, PDO::PARAM_STR, 7);

        $liste = array();
        $resultat = $requete->execute();
        $requete->setFetchMode(PDO::FETCH_ASSOC);
        while ($ligne = $requete->fetch()){
            $date = $ligne['date'];
            $periode = $ligne['periode'];
            $acronyme = $ligne['acronyme'];
            $liste[$date][$periode][$acronyme] = $ligne;
        }

        self::deconnexionPDO($connexion);

        return $liste;
    }

    /**
     * Efface une inscription à la permanence $periode (numérique) à la date $date (YYYY-mm-dd)
     * pour l'utilisateur $acronyme
     * 
     * @param string $date
     * @param int $periode
     * @param string $acronyme
     * 
     * 
     * @return int : nombre de suppressions (0 ou 1)
     */
    public function deletePeriode($date, $periode, $acronyme){
        $connexion = self::connectPDO(SERVEUR, BASE, NOM, MDP);
        $sql = 'DELETE FROM '.PFX.'calendar ';
        $sql .= 'WHERE date = :date AND periode = :periode AND acronyme = :acronyme ';
        $requete = $connexion->prepare($sql);

        $requete->bindParam(':date', $date, PDO::PARAM_STR, 10);
        $requete->bindParam(':periode', $periode, PDO::PARAM_INT);
        $requete->bindParam(':acronyme', $acronyme, PDO::PARAM_STR, 7);

        $resultat = $requete->execute();

        $nb = $requete->rowCount();

        self::deconnexionPDO($connexion);

        return $nb;
    }

    /**
     * Ajoute une inscription pour la permanence $periode ($numérique) à la date $date (YYYY-mm-dd)
     * pour l'utilisateur $acronyme
     * 
     * @param string $date
     * @param int $periode
     * @param string $acronyme
     * 
     * @return int
     */
    public function addPeriode($date, $periode, $acronyme){
        $connexion = self::connectPDO(SERVEUR, BASE, NOM, MDP);
        $sql = 'INSERT IGNORE INTO '.PFX.'calendar ';
        $sql .= 'SET date = :date, periode = :periode, acronyme = :acronyme ';
        $requete = $connexion->prepare($sql);

        $requete->bindParam(':date', $date, PDO::PARAM_STR, 10);
        $requete->bindParam(':periode', $periode, PDO::PARAM_INT);
        $requete->bindParam(':acronyme', $acronyme, PDO::PARAM_STR, 7);

        $resultat = $requete->execute();

        $nb = $requete->rowCount();

        self::deconnexionPDO($connexion);

        return $nb;
    }

    /**
     * renvoie la liste des utilisateurs indexée sur l'acronyme
     * 
     * @param void
     * 
     * @return array
     */
    public function getUsersList(){
        $connexion = self::connectPDO(SERVEUR, BASE, NOM, MDP);
        $sql = 'SELECT acronyme, nom, prenom, statut, telephone, mail, adresse, cpostal, commune ';
        $sql .= 'FROM '.PFX.'users ';
        $sql .= 'ORDER BY nom, prenom, acronyme ';

        $requete = $connexion->prepare($sql);

        $liste = array();
        $resultat = $requete->execute();
        $requete->setFetchMode(PDO::FETCH_ASSOC);
        while ($ligne = $requete->fetch()){
            $acronyme = $ligne['acronyme'];
            $liste[$acronyme] = $ligne;
        }

        self::DeconnexionPDO($connexion);

        return $liste;
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

        Application::DeconnexionPDO($connexion);

        return $identite;
    }

    /**
     * supprimer le token pour l'utilisateur $acronyme
     * 
     * @param string $acronyme
     * 
     * @return int
     */
    public function delToken4acronyme($acronyme){
        $connexion = Application::connectPDO(SERVEUR, BASE, NOM, MDP);
        $sql = 'DELETE FROM '.PFX.'lostPasswd ';
        $sql .= 'WHERE acronyme = :acronyme ';
        $requete = $connexion->prepare($sql);

        $requete->bindParam(':acronyme', $acronyme, PDO::PARAM_STR, 7);

        $resultat = $requete->execute();

        $nb = $requete->rowCount();

        self::DeconnexionPDO($connexion);

        return $nb;
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
        self::DeconnexionPDO($connexion);

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
        $sql = 'SELECT nom, prenom, statut, mail, acronyme, adresse, adresse, cpostal, commune ';
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
     * Récupère la liste des périodes journalières de permanences depuis la BD
     * 
     * @param void
     * 
     * @return array
    */
    public function getPeriodes(){
        $connexion = self::connectPDO(SERVEUR, BASE, NOM, MDP);
        $sql = 'SELECT id, debut, fin ';
        $sql .= 'FROM '.PFX.'periodes ';
        $requete = $connexion->prepare($sql);

        $liste = array();
        $resultat = $requete->execute();
        $requete->setFetchMode(PDO::FETCH_ASSOC);
        while ($ligne = $requete->fetch()){
            $liste[] = $ligne;
        }

        self::DeconnexionPDO($connexion);

        return $liste;

    }

    /**
     * Enregistrer les données de début et de fin des périodes de permanence
     * depuis le formulaire
     * 
     * @param array $listePeriodes
     * 
     * @return int
     */
    public function savePeriodes($listePeriodes) {
        $connexion = self::connectPDO(SERVEUR, BASE, NOM, MDP);
        // vider les périodes existantes
        $sql = 'TRUNCATE '.PFX.'periodes ';
        $requete = $connexion->prepare($sql);
        $requete->execute();

        $sql = 'INSERT INTO '.PFX.'periodes ';
        $sql .= 'SET id = :id, debut = :debut, fin = :fin ';
        $requete = $connexion->prepare($sql);

        $nb = 0;
        foreach ($listePeriodes as $unePeriode){
            $requete->bindParam(':id', $unePeriode['id'], PDO::PARAM_INT);
            $requete->bindParam(':debut', $unePeriode['debut'], PDO::PARAM_STR, 5);
            $requete->bindParam(':fin', $unePeriode['fin'], PDO::PARAM_STR, 5);

            $requete->execute();
            $nb += $requete->rowCount();
        }

        self::DeconnexionPDO($connexion);

        return $nb;
    }

    /**
     * filtrage des actions par utilisateur.
     *
     * @param $action : action envisagée
     * @param $statut : type d'utilisateur (admin || user)
     *
     * @return string : l'action permise ou Null
     */
    public function filtreAction($action, $statut)
    {
        switch ($statut) {
            case 'user':
                $permis = array('calendar', 'profile', 'passwd');
                if (!(in_array($action, $permis))) {
                    $action = null;
                }
                break;
            case 'admin':
                break;
            default:
                // wtf
                break;
        }

        return $action;
    }

    /**
     * Renvoie la liste des jours et périodes de congés récurents 
     * et spécifiques au mois $month et à l'année $year
     * 
     * @param int $month
     * @param int $year
     * 
     * @return array
     */
    public function getListeConges($month, $year, $mysql=false){
        $connexion = self::connectPDO(SERVEUR, BASE, NOM, MDP);
        $sql = 'SELECT jour, dateConge, periode ';
        $sql .= 'FROM '.PFX.'conges ';
        $sql .= 'WHERE (jour > 0 OR dateConge LIKE :leMois) ';
        $sql .= 'ORDER BY jour, dateConge ';
        $requete = $connexion->prepare($sql);

        $leMois = sprintf('%d-%02d-', $year, $month).'%';

        $requete->bindParam(':leMois', $leMois, PDO::PARAM_STR, 8);

        $listeConges = array('hebdo' => Null, 'feries' => Null);
        $resultat = $requete->execute();
        if ($resultat){
            $requete->setFetchMode(PDO::FETCH_ASSOC);
            while ($ligne = $requete->fetch()){
                if ($ligne['dateConge'] == ''){
                    $jour = $ligne['jour'];
                    $periode = $ligne['periode'];
                    $listeConges['hebdo'][$jour][$periode] = 1;
                    }
                    else {
                        if ($mysql == false)
                            $dateConge = $this->datePHP($ligne['dateConge']);
                            else $dateConge = $ligne['dateConge'];
                        $periode = $ligne['periode'];
                        $listeConges['feries'][$dateConge][$periode] = 1    ;
                    }
            }
        }

        self::DeconnexionPDO($connexion);

        return $listeConges;
    }

    /**
     * Reset des jours et périodes de congés hebdomadaires
     * 
     * @param void
     * 
     * @return int
     */
    public function resetCongesHebdo(){
        $connexion = self::connectPDO(SERVEUR, BASE, NOM, MDP);
        $sql = 'DELETE FROM '.PFX.'conges ';
        $sql .= 'WHERE jour > 0 ';
        $requete = $connexion->prepare($sql);

        $requete->execute();

        $nb = $requete->rowCount();

        self::DeconnexionPDO($connexion);

        return $nb;
    }

    /**
     * Reset des jours fériés pour le mois $month
     * 
     * @param int $month
     * 
     * @return int
     */
    public function resetFeries($month) {
        $connexion = self::connectPDO(SERVEUR, BASE, NOM, MDP);
        $sql = 'DELETE FROM '.PFX.'conges ';
        $sql .= 'WHERE jour = -1 AND dateConge LIKE :month ';
        $requete = $connexion->prepare($sql);

        if ($month < 10)
            $month = '0'.$month;
        
        $month = '%-'.$month.'-%';

        $requete->bindParam(':month', $month, PDO::PARAM_STR, 6);

        $requete->execute();

        $nb = $requete->rowCount();

        self::DeconnexionPDO($connexion);

        return $nb;
    }

    /**
     * Enregistre une période de congé hebdomadaire
     * 
     * @param int $jour
     * @param int $periode
     * 
     * @return int
     */
    public function saveCongeHebdo($jour, $periode){
        $connexion = self::connectPDO(SERVEUR, BASE, NOM, MDP);
        $sql = 'INSERT INTO '.PFX.'conges ';
        $sql .= 'SET jour = :jour, periode = :periode ';
        $requete = $connexion->prepare($sql);

        $requete->bindParam(':jour', $jour, PDO::PARAM_INT);
        $requete->bindParam(':periode', $periode, PDO::PARAM_INT);

        $requete->execute();

        $nb = $requete->rowCount();

        self::DeconnexionPDO($connexion);

        return $nb;
    }

    /**
     * Enregistre une période de fermeture pour jour férié
     * 
     * @param string $date
     * @param int $periode
     * 
     * @return int : 0 ou 1
     */
    public function saveJourFerie($uneDate, $periode){
        $connexion = self::connectPDO(SERVEUR, BASE, NOM, MDP);
        $sql = 'INSERT IGNORE INTO '.PFX.'conges ';
        $sql .= 'SET dateConge = :uneDate, periode = :periode ';
        $requete = $connexion->prepare($sql);

        $requete->bindParam(':uneDate', $uneDate, PDO::PARAM_STR, 10);
        $requete->bindParam(':periode', $periode, PDO::PARAM_INT);

        $requete->execute();

        $nb = $requete->rowCount();

        self::DeconnexionPDO($connexion);

        return $nb;
    }

    /**
     * Supprime toutes les périodes pour un jour férié $laDate donné
     * 
     * @param string $laDate
     * 
     * @return int
     */
    public function delJourFerie($laDate){
        $connexion = self::connectPDO(SERVEUR, BASE, NOM, MDP);
        $sql = 'DELETE FROM '.PFX.'conges ';
        $sql .= 'WHERE dateConge = :laDate ';

        $requete = $connexion->prepare($sql);

        $requete->bindParam(':laDate', $laDate, PDO::PARAM_STR, 10);

        $requete->execute();

        $nb = $requete->rowCount();

        self::DeconnexionPDO($connexion);

        return $nb;
    }


    /**
     * renvoie la date au format international yyyy-mm-dd vers la date en français dd/mm/yyyy
     * 
     * @param string $date
     * 
     * @return string
     */
    public function datePHP($date){
        $date = explode('-', $date);
        return sprintf('%s/%s/%s', $date[2], $date[1], $date[0]);
    }

    /**
     * renvoie la dae au format français dd/mm/yyyy  vers le format  MySQL YYYY-MM-DD
     * 
     * @param string $dateFr
     * 
     * @return string
     */
    public function dateMySQL($dateFr){
        $dateFr = explode ('/', $dateFr);
        return sprintf('%s-%s-%s', $dateFr[2], $dateFr[1], $dateFr[0]);
    }

   /**
     * Envoie un mail de rappel de mot de passe à l'utlisateur dont on a l'adresse.
     *
     * @param $link : le lien de l'adresse où changer le mdp
     * @param $identite	: toutes les informations d'identité de l'utilisateur
     * @param $identiteReseau : informations relatives à la connexion (IP,...)
     *
     * @return bool
     */
    public function mailPasswd($adresse, $texte) {
        $date = date('d/m/Y');
        $heure = date('H:i');
        
        $mail = new PHPmailer();
        $mail->IsHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->From = MAILADMIN;
        $mail->FromName = ADMINNAME;
        $mail->AddAddress($adresse);
        $mail->Subject = RESET;
        $mail->Body = $texte;

        return !$mail->Send();
    }

}
