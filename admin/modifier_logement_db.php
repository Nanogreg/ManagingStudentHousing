<?php
include('../outils/db_existe.php');
include('../outils/template_inc.php');
include('../outils/connect_database.php');
include('admin_header.html');
include('../outils/requetes.php');
include('../outils/validation_champ.php');

$template=template_inc('./admin','modifier_logement','admin_modifier_logement.html');

$tab_donnees=array($_POST['img'],$_POST['adresse'],$_POST['localite'],$_POST['codepostal'],$_POST['prix'], $_POST['caution']);
$tab_alias=array('IM','AD','LO','CP','PR','CA');
$valide_champ=array();
$verif=0;

 for($i=0; $i<count($tab_donnees); $i++) {
   $valide_champ[$i]=champ_obligatoire($template,$tab_donnees[$i],$tab_alias[$i],'<strong style="color:red;"><-Erreur   champ vide</strong>',"modifier_logement");
   }
   
   for($i=0; $i<count($valide_champ); $i++) {
   if($valide_champ[$i]==1) {
       $verif=1;
  }
  
//////////////////////////////////////////////////////
/*validation des champs prix > 0 et caution > 0    */
////////////////////////////////////////////////////
if($_POST['prix'] < 0){
$valide=1;
$template->assign_vars(array('PR'=>'<strong style="color:red;"><-champ n&eacute;gatif</strong'));
}

if($_POST['caution'] < 0){
$valide=1;
$template->assign_vars(array('CA'=>'<strong style="color:red;"><-champ n&eacute;gatif</strong'));
}

if($_POST['codepostal'] < 0){
$valide=1;
$template->assign_vars(array('CP'=>'<strong style="color:red;"><-champ n&eacute;gatif</strong'));
}
  
//////////////////////////////////////////////
/*validation des champs qui sont numeriques*/
////////////////////////////////////////////
if(isset($valide)!=1)
$valide_code=champ_numeric($template,$_POST['codepostal'],'CP','<strong style="color:red;"><-Erreur le champ doit  &ecirc;tre numerique</strong>',"modifier_logement");  
if(isset($valide)!=1)
$valide_prix=champ_numeric($template,$_POST['prix'],'PR','<strong style="color:red;"><-Erreur le champ doit  &ecirc;tre numerique</strong>',"modifier_logement");  
if(isset($valide)!=1)
$valide_caut=champ_numeric($template,$_POST['caution'],'CA','<strong style="color:red;"><-Erreur le champ doit  &ecirc;tre numerique</strong>',"modifier_logement");  

//////////////////////////////////////////////////
/*validation des champs qui sont des caracteres*/
////////////////////////////////////////////////
$valide_loc=champ_caractere($template,$_POST['localite'],'LO','<strong style="color:red;"><-Erreur le champ doit  &ecirc;tre des lettres</strong>',"modifier_logement");


   if(isset($donnees['nbrlit4'])==4) {
   $template->assign_vars(array('LIT4'=>'checked="checked"'));
	$template->assign_vars(array('NBRLIT2'=>'nbrlit4'));
	$template->assign_vars(array('NBRLIT3'=>'nbrlit4'));
	$template->assign_vars(array('NBRLIT4'=>'nbrlit4'));
	
 	}
else if(isset($donnees['nbrlit3'])==3) {
	$template->assign_vars(array('LIT3'=>'checked="checked"'));
    $template->assign_vars(array('NBRLIT4'=>'nbrlit3'));
	$template->assign_vars(array('NBRLIT2'=>'nbrlit3'));
	$template->assign_vars(array('NBRLIT3'=>'nbrlit3'));

 	}
 	
else {
	$template->assign_vars(array('LIT2'=>'checked="checked"'));
	$template->assign_vars(array('NBRLIT3'=>'nbrlit2'));
    $template->assign_vars(array('NBRLIT4'=>'nbrlit2'));
	$template->assign_vars(array('NBRLIT2'=>'nbrlit2'));

	 
	 }
	 
 }
   
  if($verif==1 || isset($valide)==1 || $valide_code==1 || $valide_prix==1 || $valide_caut==1 || $valide_loc==1) {
  	
    $template->assign_vars(array('READONLY'=>'READONLY'));
    $template->assign_vars(array(
         'IDEN'=>$_POST['id'],
         'IMG'=>$_POST['img'],
         'ADR'=>$_POST['adresse'],
         'LOC'=>$_POST['localite'],
         'CODEP'=>$_POST['codepostal'],
         'PRI'=>$_POST['prix'],
         'CAU'=>$_POST['caution'])
);
    include('admin_menu_membre_cooperateur.html');
    include('admin_menu_gestion_logement.html');
    include('admin_menu_produit_service.html');
    $template->assign_vars(array('INFO'=>'Les champs * sont obligatoires'));
    $template->pparse('modifier_logement');
   }
   
   else {
      
///////////////////////////////////////////////////////////////
/* lecture des infos de connexion db du fichier dico.co     */
/////////////////////////////////////////////////////////////
    $tab_db=read_file_db();
///////////////////////////////////////////////////////////////
/* connexion                                                */
/////////////////////////////////////////////////////////////
    $db=connexionDatabase($tab_db[0],$tab_db[1],$tab_db[2],$tab_db[3]);
    update_id_logement($db);
    $template->assign_vars(array('INFO'=>'<strong style="color:green;">Logement modifi&eacute;</strong>'));
    
    include('admin_menu_membre_cooperateur.html');
    include('admin_menu_gestion_logement.html');
    include('admin_menu_produit_service.html');
    $template->assign_vars(array('ACTION'=>'modifier_logement.php'));
    $template->pparse('modifier_logement');
   }
?>