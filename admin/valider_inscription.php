<?php
include('../outils/db_existe.php');
include('../outils/template_inc.php');
include('admin_header.html');
include('../outils/validation_champ.php');
include('../outils/requetes.php');
include('../outils/connect_database.php');

                 ///////////////////////////////////////////////////////////////
		/* lecture des infos de connexion db du fichier db.co        */
		//////////////////////////////////////////////////////////////
    	$tab_db=read_file_db();
		///////////////////////////////////////////////////////////////
		/* connexion                                                */
		/////////////////////////////////////////////////////////////
    	$db=connexionDatabase($tab_db[0],$tab_db[1],$tab_db[2],$tab_db[3]);
        $template=template_inc('./admin','valider_inscription','admin_valider_inscription.html');
    	$template->assign_vars(array('ACTION'=>'valider_inscription.php'));
        $tab_matricule=array();
        $i=0;

if(!isset($_POST['valider']) || isset($_POST['valider'])) {

$tab=select_pour_valide_inscript($db);

   if($tab!=0) {
       foreach($tab as $tab_donnees) {
         $template->assign_block_vars('INSCRIPTION',array('MATETUD'=>$tab_donnees[0],
       'MATETUD_CHECKBOX'=>$tab_donnees[0],'MATETUD_NAME'=>$tab_donnees[0],'NOM'=>$tab_donnees[1],'PRENOM'=>$tab_donnees[2],'INSCRIPT'=>$tab_donnees[3]));
       $tab_matricule[$i++]=$tab_donnees[0];
      }
}

  if(isset($_POST['valider'])) {
    foreach($tab_matricule as $tab_value) {
     if(isset($_POST[$tab_value])){
       update_inscription($db,$tab_value);
     }
    }
      $template->assign_vars(array('INFO'=>'<strong style="color:green;">Le(s) Inscription(s) sont Valid&eacute;e(s)</strong>'));

     header('location:valider_inscription.php');
    }   

} 

include('admin_menu_membre_cooperateur.html');
include('admin_menu_gestion_logement.html');
include('admin_menu_produit_service.html');

$template->pparse('valider_inscription');

?>