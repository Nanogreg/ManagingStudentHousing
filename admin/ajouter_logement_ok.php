<?php
include('../outils/db_existe.php');
include('../outils/template_inc.php');
include('../outils/connect_database.php');
include('admin_header.html');
include('../outils/requetes.php');
include('../outils/validation_champ.php');

$champ=array($_POST['img'],$_POST['adresse'],$_POST['localite'],$_POST['codepostal'],$_POST['prix'],$_POST['caution']);
$alias=array('IM','AD','LO','CP','PR','CA','NL');

////////////////////////////////////////////
/*validation des champs qui sont vides   */
//////////////////////////////////////////

$template=template_inc('./admin','ajouter_logement','admin_ajouter_logement.html');
for($i=0; $i<count($champ); $i++) {
//attention les boutons radions ne doivent pas être traités comme des types text
$valide=champ_obligatoire($template,$champ[$i],$alias[$i],'<strong style="color:red;"><-Erreur champ vide</strong>',"ajouter_logement");
}

////////////////////////////////////////////
/*validation des inputs radio            */
//////////////////////////////////////////
  if(!isset($_POST['nbrlit'])) {
    $valide=1;
    $template->assign_vars(array('NL'=>'<strong style="color:red;"><-Erreur champ vide</strong>'));
    }

//////////////////////////////////////////////////////
/*validation des champs prix > 0 et caution > 0    */
////////////////////////////////////////////////////
if($_POST['prix'] < 0){
$valide=1;
$template->assign_vars(array('PR'=>'<strong style="color:red;"><-champ négatif</strong'));
}

if($_POST['caution'] < 0){
$valide=1;
$template->assign_vars(array('CA'=>'<strong style="color:red;"><-champ négatif</strong'));
}

if($_POST['codepostal'] < 0){
$valide=1;
$template->assign_vars(array('CP'=>'<strong style="color:red;"><-champ négatif</strong'));
}

//////////////////////////////////////////////
/*validation des champs qui sont numeriques*/
////////////////////////////////////////////
$valide_code=champ_numeric($template,$_POST['codepostal'],'CP','<strong style="color:red;"><-Erreur le champ doit  &ecirc;tre numerique</strong>',"ajouter_logement");  

$valide_prix=champ_numeric($template,$_POST['prix'],'PR','<strong style="color:red;"><-Erreur le champ doit  &ecirc;tre numerique</strong>',"ajouter_logement");  

$valide_caut=champ_numeric($template,$_POST['caution'],'CA','<strong style="color:red;"><-Erreur le champ doit  &ecirc;tre numerique</strong>',"ajouter_logement");  

//////////////////////////////////////////////////
/*validation des champs qui sont des caracteres*/
////////////////////////////////////////////////
$valide_loc=champ_caractere($template,$_POST['localite'],'LO','<strong style="color:red;"><-Erreur le champ doit  &ecirc;tre des lettres</strong>',"ajouter_logement");


if($valide==1 || $valide_code==1 || $valide_prix==1 || $valide_caut==1 || $valide_loc==1) {
include('admin_menu_membre_cooperateur.html');
include('admin_menu_gestion_logement.html');
include('admin_menu_produit_service.html');
$template->assign_vars(array('INFO'=>'Les champs * sont obligatoires'));
$template->pparse('ajouter_logement');
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
    ajout_db($db,"Logement",array('adr_adr_rue','adr_adr_localite','adr_adr_cp','prix_mens_log','caution_log','nbr_lits_log','img_log'),array($_POST['adresse'],$_POST['localite'],$_POST['codepostal'],$_POST['prix'],$_POST['caution'],$_POST['nbrlit'],$_POST['img']));

if($valide==0){
$template->assign_vars(array('INFO'=>'<strong style="color:green;">Logement ajouté</strong>'));
$template->pparse('ajouter_logement');
}

include('admin_menu_membre_cooperateur.html');
include('admin_menu_gestion_logement.html');
include('admin_menu_produit_service.html');

?>