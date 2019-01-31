<?php
include('../outils/db_existe.php');
include('../outils/template_inc.php');
include('admin_header.html');
include('../outils/validation_champ.php');
include('../outils/requetes.php');
include('../outils/connect_database.php');

$logement=array('HIDDEN'=>'hidden;');
$template=template_inc('./admin','supprimer_service','admin_supprimer_service.html');
$template->assign_vars(array('AFFICHER'=>'style="display:none"'));

if(!isset($_POST['delete_service'])){
$template->assign_vars(array('INFO'=>'Nom du service<br />Le champ Nom est obligatoire'));
///////////////////////////////////////////////////////////////
/* lecture des infos de connexion db du fichier db.co     */
/////////////////////////////////////////////////////////////
    	$tab_db=read_file_db();
///////////////////////////////////////////////////////////////
/* connexion                                                */
/////////////////////////////////////////////////////////////
$db=connexionDatabase($tab_db[0],$tab_db[1],$tab_db[2],$tab_db[3]);
$tab_service=select_nom_service($db);
 foreach($tab_service as $tab){
    	        $template->assign_block_vars('AFFSERV',array(	 
    	        										     'NOM'=>$tab[0],
    	        										     'NOM_DISPLAY'=>$tab[0]));
    	   }
include('admin_menu_membre_cooperateur.html');
include('admin_menu_gestion_logement.html');
include('admin_menu_produit_service.html');
$template->pparse('supprimer_service');
}

else {
 ////////////////////////////////////////////////////////////////////
/*        traitement                                               /
/        de la requête supprimer service avec vérification      /
/attention si service existe déjà dans table demande ou autre */
/////////////////////////////////////////////////////////////////
  if($_POST['nom']!=""){
  
		///////////////////////////////////////////////////////////////
		/* lecture des infos de connexion db du fichier db.co     */
		/////////////////////////////////////////////////////////////
    	$tab_db=read_file_db();
		///////////////////////////////////////////////////////////////
		/* connexion                                                */
		/////////////////////////////////////////////////////////////
    	$db=connexionDatabase($tab_db[0],$tab_db[1],$tab_db[2],$tab_db[3]);
    	$tab_demande=select_pour_del_service_dans_demande($db);
    	
    	if($tab_demande==0) {
    	  $nom_serv=delete_nom_service($db);
    	    if($nom_serv==1){
    	     $template->assign_vars(array('INFO'=>'<strong style="color:green;">Service '.$_POST['nom'].' supprim&eacute;</strong><br/>Nom du service<br />Le champ nom est obligatoire'));
    	     $verif=1;
    	    }
    	}
    	
    	else {
    	   foreach($tab_demande as $tab){
    	        $template->assign_block_vars('LIGNE',array(	 
    	        										     'mat_etud'=>$tab[0],
    	        										     'nom_serv'=>$tab[1]));
    	   }
    	  $template->assign_vars(array('AFFICHER'=>'style="display:bloc"'));
    	  $template->assign_vars(array('INFO'=>'<strong style="color:red;">Ce service est en cours d\'utilisation chez des l\'&eacute;tudiants</strong></br>Nom du service<br />Le champ nom est obligatoire'));
          $verif=1;
    	}
  $tab_service=select_nom_service($db);
 foreach($tab_service as $tab){
    	        $template->assign_block_vars('AFFSERV',array(	 
    	        										     'NOM'=>$tab[0],
    	        										     'NOM_DISPLAY'=>$tab[0]));
     }
  }
  
 if(isset($verif)!=1) 
             $template->assign_vars(array('INFO'=>'Nom du service<br />Le champ Nom est obligatoire'));
include('admin_menu_membre_cooperateur.html');
include('admin_menu_gestion_logement.html');
include('admin_menu_produit_service.html');
$template->pparse('supprimer_service');

  }
?>