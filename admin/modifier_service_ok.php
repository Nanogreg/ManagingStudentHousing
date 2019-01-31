<?php
include('../outils/db_existe.php');
include('../outils/template_inc.php');
include('../outils/connect_database.php');
include('admin_header.html');
include('../outils/requetes.php');
include('../outils/validation_champ.php');

$template=template_inc('./admin','modifier_service','admin_modifier_service.html');
$template->assign_vars(array('ACTION'=>'modifier_service_ok.php'));
////////////////////////////////////////////
/*validation si champ vide               */
//////////////////////////////////////////
$valide=champ_obligatoire($template,$_POST['nom'],'NO','<strong style="color:red;"><-Erreur champ vide</strong>',"modifier_service");
////////////////////////////////////////////////////////
/*validation de l'identifiant logement entre 1 et 30 */
//////////////////////////////////////////////////////
if($_POST['nom']!="") {
///////////////////////////////////////////////////////////////
/* lecture des infos de connexion db du fichier dico.co     */
/////////////////////////////////////////////////////////////
    $tab_db=read_file_db();
///////////////////////////////////////////////////////////////
/* connexion                                                */
/////////////////////////////////////////////////////////////
    $db=connexionDatabase($tab_db[0],$tab_db[1],$tab_db[2],$tab_db[3]);
    $donnees=select_id_service($db);
    
   if($donnees!=1) {
 //////////////////////////////////////////////////////////////
/* affichage des infos de la table logement pour modifier   */
/////////////////////////////////////////////////////////////
	$template->assign_vars(array(
	'NOM'=>$donnees['nom_serv'],
	'PRI'=>$donnees['prix_serv'],
	'DES'=>$donnees['descript_serv'],
	'DUR'=>$donnees['duree_serv'],
	'DAT'=>$donnees['date_achat_serv'])
	);
	 
	$template->assign_vars(array('READONLY'=>'READONLY'));
	$template->assign_vars(array('INFO'=>'Les champs * sont obligatoires'));
	$template->assign_vars(array('ACTION'=>'modifier_service_db.php'));
 	$template->pparse('modifier_service');
 	
 	}
 	
 	else {
 	    $template->assign_vars(array('NO'=>'<strong style="color:red;"><-Ce produit n\'existe pas</strong>'));
 	    $template->assign_vars(array('INFO'=>'Les champs * sont obligatoires'));
 	    $template->pparse('modifier_service');
 	}
    
}

else if($_POST['nom']==""){
       $valide=1;
}

else {
     $valide=1;
     $template->assign_vars(array('NO'=>'<strong style="color:red;"><-champ vide</strong>'));
}

if($valide==1){
include('admin_menu_membre_cooperateur.html');
include('admin_menu_gestion_logement.html');
include('admin_menu_produit_service.html');
 $template->assign_vars(array('INFO'=>'Les champs * sont obligatoires'));
 $template->assign_vars(array(
'NOM'=>'""',
'PRI'=>'""',
'DES'=>'""',
'DUR'=>'""',
'DAT'=>'""')
);
 $template->pparse('modifier_service');
 exit; // on arrête l'excution du script
}

include('admin_menu_membre_cooperateur.html');
include('admin_menu_gestion_logement.html');
include('admin_menu_produit_service.html');

?>