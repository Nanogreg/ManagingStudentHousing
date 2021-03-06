<?php
include('../outils/db_existe.php');
include('../outils/template_inc.php');
include('../outils/connect_database.php');
include('admin_header.html');
include('../outils/requetes.php');
include('../outils/validation_champ.php');

$template=template_inc('./admin','modifier_logement','admin_modifier_logement.html');
$template->assign_vars(array('ACTION'=>'modifier_logement_ok.php'));
////////////////////////////////////////////
/*validation si champ vide               */
//////////////////////////////////////////
$valide=champ_obligatoire($template,$_POST['id'],'ID','<strong style="color:red;"><-Erreur champ vide</strong>',"modifier_logement");
////////////////////////////////////////////////////////
/*validation de l'identifiant logement entre 1 et 30 */
//////////////////////////////////////////////////////
if($_POST['id'] >=1 && $_POST['id'] <=30) {
///////////////////////////////////////////////////////////////
/* lecture des infos de connexion db du fichier dico.co     */
/////////////////////////////////////////////////////////////
    $tab_db=read_file_db();
///////////////////////////////////////////////////////////////
/* connexion                                                */
/////////////////////////////////////////////////////////////
    $db=connexionDatabase($tab_db[0],$tab_db[1],$tab_db[2],$tab_db[3]);
    $donnees=select_id_logement($db);
    
   if($donnees!=1) {
 //////////////////////////////////////////////////////////////
/* affichage des infos de la table logement pour modifier   */
/////////////////////////////////////////////////////////////
	$template->assign_vars(array(
	'IDEN'=>$donnees['id_log'],
	'IMG'=>$donnees['img_log'],
	'ADR'=>$donnees['adr_adr_rue'],
	'LOC'=>$donnees['adr_adr_localite'],
	'CODEP'=>$donnees['adr_adr_cp'],
	'PRI'=>$donnees['prix_mens_log'],
	'CAU'=>$donnees['caution_log'])
	);
	
if($donnees['nbr_lits_log']==2) {
	$template->assign_vars(array('LIT2'=>'checked="checked"'));
	$template->assign_vars(array('NBRLIT3'=>'nbrlit2'));
    $template->assign_vars(array('NBRLIT4'=>'nbrlit2'));
	$template->assign_vars(array('NBRLIT2'=>'nbrlit2'));


 	}
else if($donnees['nbr_lits_log']==3) {
	$template->assign_vars(array('LIT3'=>'checked="checked"'));
    $template->assign_vars(array('NBRLIT4'=>'nbrlit3'));
	$template->assign_vars(array('NBRLIT2'=>'nbrlit3'));
	$template->assign_vars(array('NBRLIT3'=>'nbrlit3'));


 	}
else if($donnees['nbr_lits_log']==4) {
	$template->assign_vars(array('LIT4'=>'checked="checked"'));
	$template->assign_vars(array('NBRLIT2'=>'nbrlit4'));
	$template->assign_vars(array('NBRLIT3'=>'nbrlit4'));
	$template->assign_vars(array('NBRLIT4'=>'nbrlit4'));
	 
	 }
	 
	$template->assign_vars(array('READONLY'=>'READONLY'));
	$template->assign_vars(array('INFO'=>'Les champs * sont obligatoires'));
	$template->assign_vars(array('ACTION'=>'modifier_logement_db.php'));
 	$template->pparse('modifier_logement');
 	
 	}
 	
 	else {
 	    $template->assign_vars(array('ID'=>'<strong style="color:red;"><-Ce logement n\'existe pas</strong>'));
 	    $template->assign_vars(array('INFO'=>'Les champs * sont obligatoires<br/>Entrer un ID entre 1 et 30'));
 	    $template->pparse('modifier_logement');
 	}
    
}

else if($_POST['id']==""){
       $valide=1;
}

else {
     $valide=1;
     $template->assign_vars(array('ID'=>'<strong style="color:red;"><-champ invalide entre 1 et 30</strong>'));
}

//////////////////////////////////////////////////////////////
/*validation du champ id qui ne peut être de type caractère*/
////////////////////////////////////////////////////////////
$valide_id=champ_numeric($template,$_POST['id'],'ID','<strong style="color:red;">Erreur le champ doit  &ecirc;tre numerique</strong>',"modifier_logement");


if($valide==1 || $valide_id==1){
include('admin_menu_membre_cooperateur.html');
include('admin_menu_gestion_logement.html');
include('admin_menu_produit_service.html');
 $template->assign_vars(array('INFO'=>'Les champs * sont obligatoires<br/>Entrer un ID entre 1 et 30'));
 $template->assign_vars(array(
'IDEN'=>'""',
'IMG'=>'""',
'ADR'=>'""',
'LOC'=>'""',
'CODEP'=>'""',
'PRI'=>'""',
'CAU'=>'""',
'LIT'=>'')
);
 $template->pparse('modifier_logement');
 exit; // on arrête l'excution du script
}

include('admin_menu_membre_cooperateur.html');
include('admin_menu_gestion_logement.html');
include('admin_menu_produit_service.html');

?>