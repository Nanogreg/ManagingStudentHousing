<?php
include('../outils/db_existe.php');
include('../outils/template_inc.php');
include('../outils/connect_database.php');
include('admin_header.html');
include('../outils/requetes.php');
include('../outils/validation_champ.php');

$template=template_inc('./admin','modifier_produit','admin_modifier_produit.html');

$tab_donnees=array($_POST['nom'],$_POST['description'],$_POST['prix'],$_POST['img']);
$tab_alias=array('NO','DE','PR','IM');
$valide_champ=array();
$verif=0;

 for($i=0; $i<count($tab_donnees); $i++) {
   $valide_champ[$i]=champ_obligatoire($template,$tab_donnees[$i],$tab_alias[$i],'<strong style="color:red;"><-Erreur champ vide</strong>',"modifier_produit");
   }
   
   for($i=0; $i<count($valide_champ); $i++) {
   if($valide_champ[$i]==1) {
       $verif=1;
  }
  
//////////////////////////////////////////////////////
/*validation des champs prix > 0                   */
////////////////////////////////////////////////////
if($_POST['prix'] < 0){
$valide=1;
$template->assign_vars(array('PR'=>'<strong style="color:red;"><-champ n&eacute;gatif</strong'));
}
	 
 }
   
  if($verif==1 || isset($valide)==1) {
  	
    $template->assign_vars(array('READONLY'=>'READONLY'));
    $template->assign_vars(array(
         'IDEN'=>$_POST['id'],
         'NOM'=>$_POST['nom'],
         'DES'=>$_POST['description'],
         'PRI'=>$_POST['prix'],
         'IMG'=>$_POST['img'])
);
    include('admin_menu_membre_cooperateur.html');
    include('admin_menu_gestion_logement.html');
    include('admin_menu_produit_service.html');
    $template->assign_vars(array('INFO'=>'Les champs * sont obligatoires'));
    $template->pparse('modifier_produit');
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
    update_id_produit($db);
    $template->assign_vars(array('INFO'=>'<strong style="color:green;">Produit modifi&eacute;</strong>'));
    
    include('admin_menu_membre_cooperateur.html');
    include('admin_menu_gestion_logement.html');
    include('admin_menu_produit_service.html');
    $template->assign_vars(array('ACTION'=>'modifier_produit.php'));
    $template->pparse('modifier_produit');
   }
?>