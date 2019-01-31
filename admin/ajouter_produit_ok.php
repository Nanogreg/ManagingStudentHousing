<?php
include('../outils/db_existe.php');
include('../outils/template_inc.php');
include('../outils/connect_database.php');
include('admin_header.html');
include('../outils/requetes.php');
include('../outils/validation_champ.php');

$champ=array($_POST['nom'],$_POST['description'],$_POST['prixttc'],$_POST['img_prod']);
$alias=array('NO','DE','PR','IM');

////////////////////////////////////////////
/*validation des champs qui sont vides   */
//////////////////////////////////////////

$template=template_inc('./admin','ajouter_produit','admin_ajouter_produit.html');
for($i=0; $i<count($champ); $i++) {
//attention les boutons radions ne doivent pas être traités comme des types text
$valide=champ_obligatoire($template,$champ[$i],$alias[$i],'<strong style="color:red;"><-Erreur champ vide</strong>',"ajouter_produit");
}

//////////////////////////////////////////////////////
/*validation des champs prix > 0 et caution > 0    */
////////////////////////////////////////////////////
if($_POST['prixttc'] < 0){
$valide=1;
$template->assign_vars(array('PR'=>'<strong style="color:red;"><-champ négatif</strong'));
}

//////////////////////////////////////////////
/*validation des champs qui sont numeriques*/
////////////////////////////////////////////

$valide_prix=champ_numeric($template,$_POST['prixttc'],'PR','<strong style="color:red;"><-Erreur le champ doit  &ecirc;tre numerique</strong>',"ajouter_produit");  

//////////////////////////////////////////////////
/*validation des champs qui sont des caracteres*/
////////////////////////////////////////////////
$valide_descr=champ_caractere($template,$_POST['description'],'DE','<strong style="color:red;"><-Erreur le champ doit  &ecirc;tre des lettres</strong>',"ajouter_produit");


if($valide==1 || $valide_prix==1 || $valide_descr==1) {
include('admin_menu_membre_cooperateur.html');
include('admin_menu_gestion_logement.html');
include('admin_menu_produit_service.html');
$template->assign_vars(array('INFO'=>'Les champs * sont obligatoires'));
$template->pparse('ajouter_produit');
exit; // on arrete l'excution du script          
}

///////////////////////////////////////////////////////////////
/* lecture des infos de connexion db du fichier dico.co     */
/////////////////////////////////////////////////////////////
    $tab_db=read_file_db();
///////////////////////////////////////////////////////////////
/* connexion                                                */
/////////////////////////////////////////////////////////////
    $db=connexionDatabase($tab_db[0],$tab_db[1],$tab_db[2],$tab_db[3]);
    ajout_db($db,"Produit",array('nom_prod','description_prod','prix_vente_ttc_prod','flag_prod','img_prod'),array($_POST['nom'],$_POST['description'],$_POST['prixttc'],'d',$_POST['img_prod']));

if($valide==0){
$template->assign_vars(array('INFO'=>'<strong style="color:green;">Le produit '.$_POST['nom'].' est ajouté</strong>'));
$template->pparse('ajouter_produit');
}

include('admin_menu_membre_cooperateur.html');
include('admin_menu_gestion_logement.html');
include('admin_menu_produit_service.html');

?>