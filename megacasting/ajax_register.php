<?php
session_start();
if($_POST){	
	//check if its an ajax request, exit if not
	if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest'){
		$output = json_encode(array( //create JSON data
		'type'=>'error', 
		'text' => 'Sorry Request must be Ajax POST'
		));
		die($output); //exit script outputting json data
	} 

	// connection database
	require_once "connexion.php";
		
	//Sanitize input data using PHP filter_var().
        $nom		= filter_var($_POST["nom"], FILTER_SANITIZE_STRING);
	$mail		= filter_var($_POST["mail"], FILTER_SANITIZE_EMAIL);
	$tel_fixe	= filter_var($_POST["tel_fixe"], FILTER_SANITIZE_NUMBER_INT);
	$tel_port	= filter_var($_POST["tel_port"], FILTER_SANITIZE_NUMBER_INT);
	$rue		= filter_var($_POST["rue"], FILTER_SANITIZE_STRING);
	$ville		= filter_var($_POST["ville"], FILTER_SANITIZE_STRING);
	$code		= filter_var($_POST["code"], FILTER_SANITIZE_NUMBER_INT);
	$pays		= filter_var($_POST["pays"], FILTER_SANITIZE_STRING);
	$password	= sha1($_POST["password"]);
	$password_verif	= sha1($_POST["password_verif"]);
	$level		= filter_var($_POST["level"], FILTER_SANITIZE_NUMBER_INT);
	$token          = sha1(uniqid(rand()));

	//additional php validation
    if(!filter_var($nom, FILTER_SANITIZE_STRING)){ //nom validation
		$output = json_encode(array('type'=>'error', 'text' => 'Entrer un nom valide !'));
		die($output);
	}
	if(!filter_var($mail, FILTER_VALIDATE_EMAIL)){ //email validation
		$output = json_encode(array('type'=>'error', 'text' => 'Entrer un email valide !'));
		die($output);
	}
        $req =$bdd->query("SELECT mail_information FROM information WHERE mail_information ='" . $mail  ."'"); 
        $req->setFetchMode(PDO::FETCH_OBJ);
        if($req->rowCount() > 0){
            $output = json_encode(array('type'=>'error', 'text' => 'Email déjà utilisé !'));
            die($output);
        }
	if(!filter_var($tel_fixe, FILTER_SANITIZE_NUMBER_FLOAT)){ //check for valid numbers in phone number field
		$output = json_encode(array('type'=>'error', 'text' => 'Numéro de téléphone invalide !'));
		die($output);
	}
	if(!filter_var($tel_port, FILTER_SANITIZE_NUMBER_FLOAT)){ //check for valid numbers in phone number field
		$output = json_encode(array('type'=>'error', 'text' => 'Numéro de téléphone invalide !'));
		die($output);
	}
	if(strlen($rue)<1){ //check emtpy message
		$output = json_encode(array('type'=>'error', 'text' => 'Nom de rue invalide !'));
		die($output);
	}
	if(strlen($ville)<1){ //check emtpy message
		$output = json_encode(array('type'=>'error', 'text' => 'Nom de ville invalide !'));
		die($output);
	}
	if(!filter_var($code, FILTER_SANITIZE_NUMBER_FLOAT)==5){ //check for valid numbers in phone number field
		$output = json_encode(array('type'=>'error', 'text' => 'Code postal invalide !'));
		die($output);
	}
	if(strlen($pays)<1){ //check emtpy message
		$output = json_encode(array('type'=>'error', 'text' => 'Pays invalide !'));
		die($output);
	}
	if($_POST["password"] == null){ //check emtpy message
		$output = json_encode(array('type'=>'error', 'text' => 'Le mot de passe doit contenir 6 caractères au minimum !'));
		die($output);
	}
	if($password_verif != $password){ //check emtpy message
		$output = json_encode(array('type'=>'error', 'text' => 'La confirmation de mot de passe est invalide !'));
		die($output);
	}
	if(!filter_var($level, FILTER_SANITIZE_NUMBER_FLOAT)){ //check for valid numbers in phone number field
		$output = json_encode(array('type'=>'error', 'text' => 'Type de compte invalide !'));
		die($output);
	}
        
        if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn|gmail).[a-z]{2,4}$#", $mail)) // On filtre les serveurs qui rencontrent des bogues.
        {
            $passage_ligne = "\r\n";
        }
        else
        {
            $passage_ligne = "\n";
        }
 
        //=====Déclaration des messages au format HTML.
                 
        $message_html = "<html><head></head><body>Bienvenu " . $nom . ",</br></br></body></html>";
        $message_html .= "Votre inscription à bien été reçu et confirmer par notre site internet. Nous résumons toutes les données que vous avez renseignez et nous vous invitons à cliquer sur le lien de confirmation ci-dessous pour utilisez votre compte.</br></br>";
        $message_html .= "Email : <b>". $mail . "</b></br>";
        $message_html .= "Téléphone fixe : <b>". $tel_fixe . "</b></br>";
        $message_html .= "Téléphone portable : <b>". $tel_port . "</b></br>";
        $message_html .= "Rue : <b>". $rue . "</b></br>";
        $message_html .= "Ville : <b>". $ville . "</b>(" . $code . ")" . "</br>"; 
        $message_html .= "Pays : <b>". $pays . "</b></br>";
        $message_html .= "Mot de passe <b>". $password . "</b></br></br>";
        $message_html .= "Vous devez absolument sauvegarder ce mot de passe et ne le dévoiler sous <b>aucun</b> prétexte. Il vous servira nottament pour modifier ou supprimer vos annonces postés</br></br>";
        $message_html .= "Lien de confirmation : <a href='http://megacasting.local/activate.php?token=".$token."&mail=".$mail."'>Activation du compte</a></br></br>";
        $message_html .= " Ce mail est envoyer automatiquement à chaque inscription, merci de ne pas y répondre.</br></br>";
        $message_html .= "Cordialement, l'équipe MegaCasting.";                                   
        
        //==========

        //=====Création de la boundary
        $boundary = "-----=".md5(rand());
        //==========

        //=====Définition du sujet.
        $sujet = "Inscription Megacasting";
        //=========

        //=====Création du header de l'e-mail.
        $header = "From: \"" . $nom ."\"" . $mail .$passage_ligne;
        $header .= "Reply-to: \"MegaCasting\" <megacasting.pro@gmail.com>".$passage_ligne;
        $header .= "MIME-Version: 1.0".$passage_ligne;
        $header .= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
        //==========

        //=====Création du message.
        $message = $passage_ligne."--".$boundary.$passage_ligne;

        //==========
        $message.= $passage_ligne."--".$boundary.$passage_ligne;
        //=====Ajout du message au format HTML
        $message.= "Content-Type: text/html; charset= utf8".$passage_ligne;
        $message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
        $message.= $passage_ligne.$message_html.$passage_ligne;
        //==========
        $message.= $passage_ligne."--".$boundary."--".$passage_ligne;
        $message.= $passage_ligne."--".$boundary."--".$passage_ligne;
        //==========

        //=====Envoi de l'e-mail.
        mail($mail,$sujet,$message,$header);
        //==========     
           
	// requete sql insertion information 
	$req = $bdd->prepare('INSERT INTO information(mail_information, tel_fixe_information, tel_port_information, rue_information, ville_information, cp_information, pays_information, password_information, level_information, token_information)
	VALUES(:mail_information,:tel_fixe_information,:tel_port_information,:rue_information,:ville_information,:cp_information,:pays_information,:password_information,:level_information,:token_information)')
	or exit(print_r($bdd->errorInfo()));
	
	$req->execute(array('mail_information' => $mail,'tel_fixe_information' => $tel_fixe,'tel_port_information' => $tel_port,'rue_information' => $rue,'ville_information' => $ville,'cp_information' => $code,'pays_information' => $pays,'password_information' => $password,'level_information' => $level, 'token_information' => $token));
    $req_connection = $bdd->query("SELECT id_information FROM information WHERE mail_information ='" . $mail . "'");
    $req_connection->setFetchMode(PDO::FETCH_OBJ);
    while( $resultat = $req_connection->fetch()){     
        $id_information = $resultat->id_information;
    }
	$req->closeCursor();
             
        // requete sql insertion annonceur 
        if ($level == 1 ){
            $req_insert_annonceur = $bdd->prepare('INSERT INTO annonceur(nom_annonceur, id_information)VALUES(:nom_annonceur,:id_information)')
            or exit(print_r($bdd->errorInfo()));
            $req_insert_annonceur->execute(array('nom_annonceur' => $nom, 'id_information' => $id_information));
        }
        // requete sql insertion diffuseur 
        if ($level == 2 ){
            $req_insert_diffuseur = $bdd->prepare('INSERT INTO diffuseur(nom_diffuseur, id_information)VALUES(:nom_diffuseur,:id_information)')
            or exit(print_r($bdd->errorInfo()));
            $req_insert_diffuseur->execute(array('nom_diffuseur' => $nom, 'id_information' => $id_information));
        }
        // requete sql insertion artiste  
        if ($level == 3 ){
            $req_insert_artiste = $bdd->prepare('INSERT INTO artiste(nom_artiste, id_information)VALUES(:nom_artiste,:id_information)')
            or exit(print_r($bdd->errorInfo()));
            $req_insert_artiste->execute(array('nom_artiste' => $nom, 'id_information' => $id_information));
        }
       
	if(!$req){
		//requete echoue
		$output = json_encode(array('type'=>'error', 'text' => 'La création a échoué ! S\'il vous plaît vérifiez les valeurs saisies !'));
		die($output);
	}else{
		$output = json_encode(array('type'=>'message', 'text' => 'Votre compte a bien été créer, vous allez recevoir une confirmation par mail !'));
		die($output);
	}
}
?>