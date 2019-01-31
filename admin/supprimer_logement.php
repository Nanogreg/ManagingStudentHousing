<?php
include('../outils/db_existe.php');
include('../outils/template_inc.php');
include('admin_header.html');
include('../outils/validation_champ.php');
include('../outils/requetes.php');
include('../outils/connect_database.php');

$logement=array('HIDDEN'=>'hidden;');
$template=template_inc('./admin','supprimer_logement','admin_supprimer_logement.html');
$template->assign_vars(array('AFFICHER'=>'style="display:none"'));

if(!isset($_POST['id'])){
$template->assign_vars(array('INFO'=>'Identifiant du  logement entre 1 et 30<br />Le champ ID est obligatoire'));
include('admin_menu_membre_cooperateur.html');
include('admin_menu_gestion_logement.html');
include('admin_menu_produit_service.html');
$template->pparse('supprimer_logement');
}

else {
 ///////////////////////////////////////////////////////////////////
/*         validation du champ id et executer traitement          /
/        de la requête supprimer logement avec vérification      /
/attention si logement existe déjà dans table dossier ou autre */
////////////////////////////////////////////////////////////////
  if($_POST['id']>=1 && $_POST['id']<=30){
  
		///////////////////////////////////////////////////////////////
		/* lecture des infos de connexion db du fichier dico.co     */
		/////////////////////////////////////////////////////////////
    	$tab_db=read_file_db();
		///////////////////////////////////////////////////////////////
		/* connexion                                                */
		/////////////////////////////////////////////////////////////
    	$db=connexionDatabase($tab_db[0],$tab_db[1],$tab_db[2],$tab_db[3]);
    	$tab_dossier=select_pour_del_logement_dans_dossier($db);
    	
    	if($tab_dossier==0) {
    	  $id_log=delete_id_logement($db);
    	    if($id_log==1){
    	     $template->assign_vars(array('INFO'=>'<strong style="color:green;">Logement '.$_POST['id'].' supprim&eacute;</strong><br/>Identifiant du  logement entre 1 et 30<br />Le champ ID est obligatoire'));
    	    $verif=1;
    	    }
    	    else {
    	     $template->assign_vars(array('INFO'=>'<strong style="color:red;">Le logement '.$_POST['id'].' n\'existe pas</strong><br/>Identifiant du  logement entre 1 et 30<br />Le champ ID est obligatoire'));
    	     $verif=1;
    	    }
    	}
    	
    	else {
    	   foreach($tab_dossier as $tab){
    	        $template->assign_block_vars('LIGNE',array(
    	       												 'num_dossier'=>$tab[0],
    	        										     'mat_etud'=>$tab[1],
    	        										     'id_log'=>$tab[2]));
    	   }
    	  $template->assign_vars(array('AFFICHER'=>'style="display:bloc"'));
    	  $template->assign_vars(array('INFO'=>'<strong style="color:red;">Ce logement est en cours dans plusieurs dossiers</strong></br>Identifiant du  logement entre 1 et 30<br />Le champ ID est obligatoire'));
          $verif=1;
    	}
  }
  
 //////////////////////////////////////////////////////////////
/*validation du champ id qui ne peut etre de type caractere*/
////////////////////////////////////////////////////////////
  else if(champ_numeric($template,$_POST['id'],'ID','<strong style="color:red;"><-Erreur le champ doit  &ecirc;tre numerique</strong>',"supprimer_logement"))  {
  }
  
 //////////////////////////////////////////////////////////////
/*validation du champ id entre 1 et 30                      */
////////////////////////////////////////////////////////////
  else if($_POST['id'] < 1 || $_POST['id'] >30){
  $template->assign_vars(array('ID'=>'<strong style="color:red;"><-Champ invalide entre 1 et 30</strong>'));
  }
 if(isset($verif)!=1) 
             $template->assign_vars(array('INFO'=>'Identifiant du  logement entre 1 et 30<br />Le champ ID est obligatoire'));
include('admin_menu_membre_cooperateur.html');
include('admin_menu_gestion_logement.html');
include('admin_menu_produit_service.html');
$template->pparse('supprimer_logement');

  }
?>