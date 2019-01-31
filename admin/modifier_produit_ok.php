<?php
include('../outils/db_existe.php');
include('../outils/template_inc.php');
include('../outils/connect_database.php');
include('admin_header.html');
include('../outils/requetes.php');
include('../outils/validation_champ.php');

$template=template_inc('./admin','modifier_produit','admin_modifier_produit.html');
$template->assign_vars(array('ACTION'=>'modifier_produit_ok.php'));
////////////////////////////////////////////
/*validation si champ vide               */
//////////////////////////////////////////
$valide=champ_obligatoire($template,$_POST['id'],'ID','<strong style="color:red;"><-Erreur champ vide</strong>',"modifier_produit");
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
    $donnees=select_id_produit($db);
    
   if($donnees!=1) {
 //////////////////////////////////////////////////////////////
/* affichage des infos de la table logement pour modifier   */
/////////////////////////////////////////////////////////////
	$template->assign_vars(array(
	'IDEN'=>$donnees['id_prod'],
	'NOM'=>$donnees['nom_prod'],
	'DES'=>$donnees['description_prod'],
	'PRI'=>$donnees['prix_vente_ttc_prod'],
	'IMG'=>$donnees['img_prod'])
	);
	 
	$template->assign_vars(array('READONLY'=>'READONLY'));
	$template->assign_vars(array('INFO'=>'Les champs * sont obligatoires'));
	$template->assign_vars(array('ACTION'=>'modifier_produit_db.php'));
 	$template->pparse('modifier_produit');
 	
 	}
 	
 	else {
 	    $template->assign_vars(array('ID'=>'<strong style="color:red;"><-Ce produit n\'existe pas</strong>'));
 	    $template->assign_vars(array('INFO'=>'Les champs * sont obligatoires'));
 	    $template->pparse('modifier_produit');
 	}
    
}

else if($_POST['id']==""){
       $valide=1;
}

else {
     $valide=1;
     $template->assign_vars(array('ID'=>'<strong style="color:red;"><-champ vide</strong>'));
}

//////////////////////////////////////////////////////////////
/*validation du champ id qui ne peut être de type caractère*/
////////////////////////////////////////////////////////////
$valide_id=champ_numeric($template,$_POST['id'],'ID','<strong style="color:red;">Erreur le champ doit  &ecirc;tre numerique</strong>',"modifier_produit");


if($valide==1 || $valide_id==1){
include('admin_menu_membre_cooperateur.html');
include('admin_menu_gestion_logement.html');
include('admin_menu_produit_service.html');
 $template->assign_vars(array('INFO'=>'Les champs * sont obligatoires'));
 $template->assign_vars(array(
'IDEN'=>'""',
'NOM'=>'""',
'DES'=>'""',
'PRI'=>'""',
'IMG'=>'""')
);
 $template->pparse('modifier_produit');
 exit; // on arrête l'excution du script
}

include('admin_menu_membre_cooperateur.html');
include('admin_menu_gestion_logement.html');
include('admin_menu_produit_service.html');

?>