<?php

class Pdfgenerator {
    
    public function generateRaccPdf($p, $id, $a) {
        
        $tabBxlPc = [1000,1020,1030,1040,1050,1060,1070,1080,1081,1082,1083,1090,
            1120,1130,1140,1150,1160,1170,180,1190,1200,1210];
        
        //var_dump(explode('|', $p['locality'])[1]);
        //die;
        
/*
        var_dump([$p, $id, $a]);
        die();
*/
        if(in_array($p['locality_pc'], $tabBxlPc)) {
            $this->bxlPdf($p, $id, $a);
        } else {
            $this->walonniePdf($p, $id, $a);
        }        
    }
    
    
    public function bxlPdf($p, $id, $a) {
        $pdf = new Fpdf();
        $pdf->AddPage();
        //HEADER
        $pdf->SetTextColor(35, 35, 35);
        $pdf->SetFont('Arial','',28);
        $pdf->Cell(60,10,'R.A.C.C. Bruxelles', 0, 1);
        $pdf->SetFont('Arial','B',26);
        $pdf->SetTextColor(120, 120, 120);
        $pdf->Cell(145,10,utf8_decode('Déclaration de créance'), 0, 0);
        $pdf->SetTextColor(90, 90, 90);
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(50,10, utf8_decode('Déclaration n°: ' . $id), 0, 1);
        $pdf->Image(IMGPATH . 'logo_franco.jpg',112,10,30);//ADMIN
        $pdf->SetDrawColor(90, 90, 90);
        $pdf->Rect(10, 39, 190, 22, 'D');
        $pdf->SetTextColor(90, 90, 90);
        $pdf->SetFont('Arial','',14);
        $pdf->Cell(40,13, utf8_decode('Réservé à l\'administration:'), 0, 1);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(40,8, utf8_decode('     Conformément à l\'arrêté du collège du : _______/_______/_______     n°:_____'), 0, 1);
        $pdf->Cell(40,8, utf8_decode('     Montant prévisionel de l\'intervention du R.A.C.C. : ' . $p['refund_amount']) . ' euros.', 0, 1);
        //espace
        $pdf->Cell(40,5, utf8_decode(''), 0, 1);
        //FILM
        //$pdf->SetDrawColor(55, 55, 55);
        $pdf->Rect(10, 72, 190, 22, 'D');
        $pdf->SetTextColor(90, 90, 90);
        $pdf->SetFont('Arial','',14);
        $pdf->Cell(40,10, utf8_decode('Le film:'), 0, 1);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(40,6, utf8_decode('     Titre: '. $p['title']), 0, 1);
        $pdf->Cell(40,6, utf8_decode('     Réalisateur: '. $p['director']), 0, 1);
        $pdf->Cell(50,6, utf8_decode('     Pays: '. $p['country']), 0);
        $pdf->Cell(45,6, utf8_decode('Durée: '. $p['duration'] . " minutes"), 0);
        if($p['helped_by_cfwb'] === '0') {
            $pdf->Cell(40,6, utf8_decode('Film non aidé par la fédération Wallonie Bruxelles'), 0);      
        } else {
            $pdf->Cell(40,6, utf8_decode('Film aidé par la fédération Wallonie Bruxelles'), 0);
        }
        //ESPACE
        $pdf->Cell(40,10, utf8_decode(''), 0, 1);
        //ASSOCIATION
        //$pdf->SetFillColor(225, 225, 241);
        $pdf->Rect(10, 104, 190, 35, 'D');
        $pdf->SetTextColor(90, 90, 90);
        $pdf->SetFont('Arial','',14);
        $pdf->Cell(40,10, utf8_decode('L\'association:'), 0, 1);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(100,6, utf8_decode('     Nom du demandeur: ' . $a->last_name), 0);
        $pdf->Cell(40,6, utf8_decode('     Prénom du demandeur: ' . $a->first_name), 0, 1);
        $pdf->Cell(100,6, utf8_decode('     Nom de l\'association: ' . $a->association_name), 0, 1);
        $pdf->Cell(100,6, utf8_decode('     Adresse: ' . $a->address . ', ' . $a->locality_name . ' ' . $a->postal_code), 0);
        $pdf->Cell(40,6, utf8_decode('     GSM: ' . $a->gsm), 0, 1);
        $pdf->Cell(100,6, utf8_decode('     E-mail: ' . $a->email), 0);   
        $pdf->Cell(40,6, utf8_decode('     Téléphone: ' . $a->phone_nb), 0, 1);
        if($a->association_type === 'A.S.B.L') {
            $pdf->Cell(100,6, utf8_decode('     Type d\'association: A.S.B.L'), 0);    
        } else {
            $pdf->Cell(100,6, utf8_decode('     Type d\'association: Association de fait'), 0);
        }
        if($a->business_nb === 'nc.') {
            $pdf->Cell(40,6, utf8_decode('     N° de registre national: ' . $a->national_nb), 0, 1);      
        } else {
            $pdf->Cell(40,6, utf8_decode('     N° d\'entreprise: ' . $a->business_nb), 0, 1);
        }
        //ESPACE
        $pdf->Cell(40,6, utf8_decode(''), 0, 1);
        //COORDONEE BANCAIRE
        $pdf->Rect(10, 150, 190, 10, 'D');
        $pdf->SetTextColor(90, 90, 90);
        $pdf->SetFont('Arial','',14);
        $pdf->Cell(40,10, utf8_decode('Coordonnées bancaires:'), 0, 1);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(100,6, utf8_decode('     Numéro de compte IBAN: ' . $a->account_nb), 0, 1);
        //espace
        $pdf->Cell(40,8, utf8_decode(''), 0, 1);
        //LA PROJECTION
        //$pdf->SetFillColor(255, 246, 208);
        $pdf->Rect(10, 174, 190, 29, 'D');
        $pdf->SetTextColor(90, 90, 90);
        $pdf->SetFont('Arial','',14);
        $pdf->Cell(40,11, utf8_decode('La projection:'), 0, 1); 
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(100,6, utf8_decode('     Format: ' . $p['f_name']), 0, 1);
        $pdf->Cell(40,6, utf8_decode('     Adresse: ' . $p['address'] . ', ' . $p['locality_pc'] . ' ' . $p['locality_name']), 0, 1);
        $pdf->Cell(100,6, utf8_decode('     Date de la projection: ' . $p['date']), 0); 
        $pdf->Cell(40,6, utf8_decode('     Type de manifestation: ' . $p['type']), 0, 1);
        $pdf->Cell(100,6, utf8_decode('     Nombre de spectateurs: ' . $p['spec_nb']), 0);
        $pdf->Cell(100,6, utf8_decode('     Prix de la location (HTVA): ' . $p['rental_cost'] . ' euros.'), 0);
        //ESPACE
        $pdf->Cell(40,11, utf8_decode(''), 0, 1);
        //FOOTER
        $pdf->SetFont('Arial','B',12);
        $pdf->SetFillColor(254, 241, 230);
        $pdf->Cell(40,9, utf8_decode('Ce formulaire est à renvoyer à la commission communautaire française:'), 0, 1); 
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(100,6, utf8_decode('SERVICE AUDIOVISUEL - à l\'attention de Patrick MATTHYS - 42, rue des Palais à 1030 Bruxelles '), 0, 1); 
        $pdf->Cell(100,6, utf8_decode('Tel: 02/800.83.55 | e-mail : pmatthys@spfb.brussels'), 0, 1);
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(100,6, utf8_decode('NB.: Ce formulaire doit obligatoirement être accompagné de la copie de la facture, et doit être, si possible,'), 0, 1);
        $pdf->Cell(100,6, utf8_decode('envoyé directement après la projection du film.'), 0, 1);
        $pdf->SetFont('Arial','',10);
        //ESPACE       
        $pdf->Cell(40,6, utf8_decode(''), 0, 1);
        $pdf->SetFillColor(254, 241, 230);
        $pdf->Rect(10, 252, 190, 35, 'F');        
        $pdf->Cell(100,6, utf8_decode('Certifié sincère et véritable'), 0, 0); 
        $pdf->Cell(100,6, utf8_decode('Lieu et date: ..........................................'), 0, 1); 
        $pdf->Cell(100,6, utf8_decode('Signature du créancier: '), 0);
        $pdf->Cell(100,6, utf8_decode('Monica Glineur, directrice d\'administration: '), 0);
        $pdf->Output('F', 'pdf/' . $id . '.pdf');
        $pdf->Output();
    }
    
    public function walonniePdf($p, $id, $a) {
        $pdf = new Fpdf();
        $pdf->AddPage();
        //HEADER
        $pdf->SetTextColor(35, 35, 35);
        $pdf->SetFont('Arial','',28);
        $pdf->Cell(60,10,'R.A.C.C.', 0, 2);
        $pdf->SetFont('Arial','',18);
        $pdf->Cell(40,10, 'Wallonie', 0, 1); 
        $pdf->SetFont('Arial','B',26);
        $pdf->SetTextColor(120, 120, 120);
        $pdf->Cell(130,10,utf8_decode('Déclaration de créance'), 0, 0);
        $pdf->SetTextColor(90, 90, 90);
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(40,10, utf8_decode('Déclaration n°: ' . $id), 0, 1);
        $pdf->Image(IMGPATH . 'logo_cfwb.jpg',60,10,20);
        $pdf->Cell(40,8, utf8_decode('Montant prévisionel de l\'intervention du R.A.C.C. : ' . $p['refund_amount']) . ' euros.', 0, 1);
        //FILM
        //$pdf->SetDrawColor(55, 55, 55);
        $pdf->Rect(10, 57, 190, 22, 'D');
        $pdf->SetTextColor(90, 90, 90);
        $pdf->SetFont('Arial','',14);
        $pdf->Cell(40,10, utf8_decode('Le film:'), 0, 1);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(40,6, utf8_decode('     Titre: '. $p['title']), 0, 1);
        $pdf->Cell(40,6, utf8_decode('     Réalisateur: '. $p['director']), 0, 1);
        $pdf->Cell(50,6, utf8_decode('     Pays: '. $p['country']), 0);
        $pdf->Cell(45,6, utf8_decode('Durée: '. $p['duration'] . " minutes"), 0);
        if($p['helped_by_cfwb'] === '0') {
            $pdf->Cell(40,6, utf8_decode('Film non aidé par la fédération Wallonie Bruxelles'), 0);      
        } else {
            $pdf->Cell(40,6, utf8_decode('Film aidé par la fédération Wallonie Bruxelles'), 0);
        }
        //ESPACE
        $pdf->Cell(40,10, utf8_decode(''), 0, 1);
        //ASSOCIATION
        //$pdf->SetFillColor(225, 225, 241);
        $pdf->Rect(10, 89, 190, 35, 'D');
        $pdf->SetTextColor(90, 90, 90);
        $pdf->SetFont('Arial','',14);
        $pdf->Cell(40,10, utf8_decode('L\'association:'), 0, 1);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(100,6, utf8_decode('     Nom du demandeur: ' . $a->last_name), 0);
        $pdf->Cell(40,6, utf8_decode('     Prénom du demandeur: ' . $a->first_name), 0, 1);
        $pdf->Cell(100,6, utf8_decode('     Nom de l\'association: ' . $a->association_name), 0, 1);
        $pdf->Cell(100,6, utf8_decode('     Adresse: ' . $a->address . ', ' . $a->locality_name . ' ' . $a->postal_code), 0);
        $pdf->Cell(100,6, utf8_decode('     GSM: ' . $a->gsm), 0, 1);
        $pdf->Cell(100,6, utf8_decode('     E-mail: ' . $a->email), 0);   
        $pdf->Cell(40,6, utf8_decode('     Téléphone: ' . $a->phone_nb), 0, 1);
        if($a->association_type === 'A.S.B.L') {
            $pdf->Cell(100,6, utf8_decode('     Type d\'association: A.S.B.L'), 0);    
        } else {
            $pdf->Cell(100,6, utf8_decode('     Type d\'association: Association de fait'), 0);
        }
        if($a->business_nb === 'nc.') {
            $pdf->Cell(40,6, utf8_decode('     N° de registre national: ' . $a->national_nb), 0, 1);      
        } else {
            $pdf->Cell(40,6, utf8_decode('     N° d\'entreprise: ' . $a->business_nb), 0, 1);
        }
        //ESPACE
        $pdf->Cell(40,6, utf8_decode(''), 0, 1);
        //COORDONEE BANCAIRE
        $pdf->Rect(10, 135, 190, 10, 'D');
        $pdf->SetTextColor(90, 90, 90);
        $pdf->SetFont('Arial','',14);
        $pdf->Cell(40,10, utf8_decode('Coordonnées bancaires:'), 0, 1);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(100,6, utf8_decode('     Numéro de compte IBAN: ' . $a->account_nb), 0, 1);
        //espace
        $pdf->Cell(40,8, utf8_decode(''), 0, 1);
        //LA PROJECTION
        //$pdf->SetFillColor(255, 246, 208);
        $pdf->Rect(10, 160, 190, 29, 'D');
        $pdf->SetTextColor(90, 90, 90);
        $pdf->SetFont('Arial','',14);
        $pdf->Cell(40,11, utf8_decode('La projection:'), 0, 1); 
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(100,6, utf8_decode('     Format: ' . $p['f_name']), 0, 1);
        $pdf->Cell(40,6, utf8_decode('     Adresse: ' . $p['address'] . ', ' . $p['locality_pc'] . ' ' . $p['locality_name']), 0, 1);
        $pdf->Cell(100,6, utf8_decode('     Date de la projection: ' . $p['date']), 0); 
        $pdf->Cell(40,6, utf8_decode('     Type de manifestation: ' . $p['type']), 0, 1);
        $pdf->Cell(100,6, utf8_decode('     Nombre de spectateurs: ' . $p['spec_nb']), 0);
        $pdf->Cell(100,6, utf8_decode('     Prix de la location (HTVA): ' . $p['rental_cost'] . ' euros.'), 0);
        //ESPACE
        $pdf->Cell(40,13, utf8_decode(''), 0, 1);
        //FOOTER
        $pdf->SetFont('Arial','B',12);
        $pdf->SetFillColor(254, 241, 230);
        $pdf->Cell(40,9, utf8_decode('Ce formulaire est à renvoyer à: '), 0, 1);
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(100,6, utf8_decode('Fédération Wallonie-Bruxelles Service Général de l’Audiovisuel et des Médias'), 0, 1); 
        $pdf->Cell(100,6, utf8_decode('A l\'attention de Monsieur Roch TRAN'), 0, 1); 
        $pdf->Cell(100,6, utf8_decode('Boulevard Léopold II, 44 - B-1080 Bruxelles'), 0, 1); 
        $pdf->Cell(100,6, utf8_decode('Tél : 02-413 28 67 / Fax : 02-413 20 68 / Email : roch.tran@cfwb.be'), 0, 1); 
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(100,6, utf8_decode('NB.: Ce formulaire doit obligatoirement être accompagné de la copie de la facture, '), 0, 1);
        $pdf->Cell(100,6, utf8_decode('et doit être, si possible, envoyé directement après la projection du film.'), 0, 1);
        $pdf->SetFont('Arial','',10);
        //ESPACE
        $pdf->Cell(40,8, utf8_decode(''), 0, 1);
        //ESPACE SIGNATURE:
        $pdf->SetFillColor(254, 241, 230);
        $pdf->Rect(10, 250, 190, 38, 'F');
        $pdf->Cell(100,6, utf8_decode('Certifié sincère et véritable'), 0, 0); 
        $pdf->Cell(100,6, utf8_decode('Lieu et date: ..........................................'), 0, 1); 
        $pdf->Cell(100,6, utf8_decode('Signature du créancier: '), 0);
        $pdf->Output('F', 'pdf/' . $id . '.pdf');
        $pdf->Output();         
    }  
}