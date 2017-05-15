<?php

class Mailer {   
    
    public function sendRegisterRequest($asso) {
        $message = "<h1>Demande d'inscription: </h1>"
                . "<h4>L'association suivante à effectuée une demande d'inscription: : </h4>"
                . "<h2>". $asso['association_name'] ."(". $asso['association_type'] .")</h2>";

        
        
        $subject = "R.A.C.C | Application en ligne: demande d'inscription"; 
        $to  = 'yannlaru@gmail.com' . ', '; 
        $to .= 'yannlaru@yahoo.com';
        $headers = "From: \"Ne pas répondre à cet email svp\"<noreply@noreply.com>\n";
        $headers .= "Reply-To: noreply@noreply.com\n";
        $headers .= "Content-Type: text/html; charset=\"ISO-8859-1\"";
        mail($to,$subject,$message,$headers);
    }
    
    public function sendRegisterValidate($email){
        $message = "<h1>Demande d'inscription: </h1>"
                . "<h4>Vore demande d'inscription à été validée.</h4>"
                . "<p>Vous pouvez désormais utiliser le formulaire en ligne en "
                . "vous <a href='http://www.declarationracc.be/index.php/user/login'>connectant</a>.</p>";
        
        
        $subject = "R.A.C.C | Application en ligne: demande d'inscription"; 
        $to  = $email;
        $headers = "From: \"Ne pas répondre à cet email svp\"<noreply@noreply.com>\n";
        $headers .= "Reply-To: noreply@noreply.com\n";
        $headers .= "Content-Type: text/html; charset=\"utf-8\"";
        mail($to,$subject,$message,$headers);        
    }

    public function send($data, $id) {
        $file = 'pdf/' . $id . '.pdf';

        $file_type = filetype($file);
        $mail = 'yannlaru@gmail.com'; // Déclaration de l'adresse de destination.
        if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) // On filtre les serveurs qui présentent des bogues.
        {
            $passage_ligne = "\r\n";
        }
        else
        {
            $passage_ligne = "\n";
        }
        //=====Déclaration des messages au format texte et au format HTML.
        $message_txt = "Salut à tous, voici un e-mail envoyé par un script PHP.";
        $message_html = "<html><head></head><body><b>Salut à tous</b>, voici un e-mail envoyé par un <i>script PHP</i>.</body></html>";
        //==========

        //=====Lecture et mise en forme de la pièce jointe.
        $fichier   = fopen($file, "r");
        $attachement = fread($fichier, filesize($file));
        $attachement = chunk_split(base64_encode($attachement));
        fclose($fichier);
        //==========

        //=====Création de la boundary.
        $boundary = "-----=".md5(rand());
        $boundary_alt = "-----=".md5(rand());
        //==========

        //=====Définition du sujet.
        $sujet = "Hey mon ami !";
        //=========

        //=====Création du header de l'e-mail.
        $header = "From: \"WeaponsB\"<weaponsb@mail.fr>".$passage_ligne;
        $header.= "Reply-to: \"WeaponsB\" <weaponsb@mail.fr>".$passage_ligne;
        $header.= "MIME-Version: 1.0".$passage_ligne;
        $header.= "Content-Type: multipart/mixed;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
        //==========

        //=====Création du message.
        $message = $passage_ligne."--".$boundary.$passage_ligne;
        $message.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary_alt\"".$passage_ligne;
        $message.= $passage_ligne."--".$boundary_alt.$passage_ligne;
        //=====Ajout du message au format texte.
        $message.= "Content-Type: text/plain; charset=\"ISO-8859-1\"".$passage_ligne;
        $message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
        $message.= $passage_ligne.$message_txt.$passage_ligne;
        //==========

        $message.= $passage_ligne."--".$boundary_alt.$passage_ligne;

        //=====Ajout du message au format HTML.
        $message.= "Content-Type: text/html; charset=\"ISO-8859-1\"".$passage_ligne;
        $message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
        $message.= $passage_ligne.$message_html.$passage_ligne;
        //==========

        //=====On ferme la boundary alternative.
        $message.= $passage_ligne."--".$boundary_alt."--".$passage_ligne;
        //==========



        $message.= $passage_ligne."--".$boundary.$passage_ligne;

        //=====Ajout de la pièce jointe.
        $message.= "Content-Type: '. $file_type .'; name=\"". $file ."\"".$passage_ligne;
        $message.= "Content-Transfer-Encoding: base64".$passage_ligne;
        $message.= "Content-Disposition: attachment; filename=\"". $file ."\"".$passage_ligne; 
        $message.= $passage_ligne.$attachement.$passage_ligne.$passage_ligne;
        $message.= $passage_ligne."--".$boundary."--".$passage_ligne; 
        //========== 
        //=====Envoi de l'e-mail.
        echo (mail($mail,$sujet,$message,$header)) ? 'Ok' : 'Pas Ok';        
    }
}
?>
