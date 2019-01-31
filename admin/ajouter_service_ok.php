<?php
include('../outils/db_existe.php');
include('../outils/template_inc.php');
include('../outils/connect_database.php');
include('admin_header.html');
include('../outils/requetes.php');
include('../outils/validation_champ.php');

$champ=array($_POST['nom'],$_POST['prix'],$_POST['description'],$_POST['duree'],$_POST['dat_achat']);
$alias=array('NO','PR','DE','DU','DA');

////////////////////////////////////////////
/*validation des champs qui sont vides   */
//////////////////////////////////////////

$template=template_inc('./admin','ajouter_service','admin_ajouter_service.html');
for($i=0; $i<count($champ); $i++) {
//attention les boutons radions ne doivent pas être traités comme des types text
$valide=champ_obligatoire($template,$champ[$i],$alias[$i],'<strong style="color:red;"><-Erreur champ vide</strong>',"ajouter_service");
}

//////////////////////////////////////////////////////
/*validation des champs prix > 0 et caution > 0    */
////////////////////////////////////////////////////
if($_POST['prix'] < 0){
$valide=1;
$template->assign_vars(array('PR'=>'<strong style="color:red;"><-champ négatif</strong'));
}

if($_POST['duree'] < 0){
$valide=1;
$template->assign_vars(array('DU'=>'<strong style="color:red;"><-champ négatif</strong'));
}

//////////////////////////////////////////////
/*validation des champs qui sont numeriques*/
////////////////////////////////////////////
$valide_prix=champ_numeric($template,$_POST['prix'],'PR','<strong style="color:red;"><-Erreur le champ doit  &ecirc;tre numerique</strong>',"ajouter_service");  
$valide_duree=champ_numeric($template,$_POST['duree'],'DU','<strong style="color:red;"><-Erreur le champ doit  &ecirc;tre numerique</strong>',"ajouter_service");  


//////////////////////////////////////////////////
/*validation des champs qui sont des caracteres*/
////////////////////////////////////////////////
$valide_nom=champ_caractere($template,$_POST['nom'],'NO','<strong style="color:red;"><-Erreur le champ doit  &ecirc;tre des lettres</strong>',"ajouter_service");


if($valide==1 || $valide_prix==1 || $valide_duree==1 || $valide_nom==1) {
include('admin_menu_membre_cooperateur.html');
include('admin_menu_gestion_logement.html');
include('admin_menu_produit_service.html');
$template->assign_vars(array('INFO'=>'Les champs * sont obligatoires'));
$template->pparse('ajouter_service');
exit; // on arrête l'excution du script          
}

///////////////////////////////////////////////////////////////
/* lecture des infos de connexion db du fichier dico.co     */
/////////////////////////////////////////////////////////////
    $tab_db=read_file_db();
///////////////////////////////////////////////////////////////
/* connexion                                                */
/////////////////////////////////////////////////////////////
    $db=connexionDatabase($tab_db[0],$tab_db[1],$tab_db[2],$tab_db[3]);
//////////////////////////////////////////////////////////////////////////////
/*   inversion du format de la date MYSQL veut                              /
du aaaa-mm-jj et si jj-mm-aaaa il initialise à 0000-00-00                 */
///////////////////////////////////////////////////////////////////////////
$date=$_POST['dat_achat'];
$dateTime=new DateTime($date);
$formatted_date=date_format($dateTime,'Y-m-d');

ajout_db($db,"Service",array('nom_serv','prix_serv','descript_serv','duree_serv','date_achat_serv'),array($_POST['nom'],$_POST['prix'],$_POST['description'],$_POST['duree'],$formatted_date));

if($valide==0){
$template->assign_vars(array('INFO'=>'<strong style="color:green;">Service ajout&eacute;</strong>'));
$template->pparse('ajouter_service');
}

include('admin_menu_membre_cooperateur.html');
include('admin_menu_gestion_logement.html');
include('admin_menu_produit_service.html');

?>