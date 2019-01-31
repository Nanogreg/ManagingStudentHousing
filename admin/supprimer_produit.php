<?php
include('../outils/db_existe.php');
include('../outils/template_inc.php');
include('admin_header.html');
include('../outils/validation_champ.php');
include('../outils/requetes.php');
include('../outils/connect_database.php');

$logement=array('HIDDEN'=>'hidden;');
$template=template_inc('./admin','supprimer_produit','admin_supprimer_produit.html');

if(!isset($_POST['id']) && !isset($_POST['fl'])){
$template->assign_vars(array('INFO'=>'Identifiant du  produit <br />Le champ ID est obligatoire d=disponible i=indisponible'));
include('admin_menu_membre_cooperateur.html');
include('admin_menu_gestion_logement.html');
include('admin_menu_produit_service.html');
$template->pparse('supprimer_produit');
exit;
}
	
else {	
//////////////////////////////////////////////////////////////
/*validation du champ id qui ne peut etre de type caractere*/
////////////////////////////////////////////////////////////

  $verif_numeric=champ_numeric($template,$_POST['id'],'ID','<strong style="color:red;"><-Erreur le champ doit &ecirc;tre numerique</strong>',"supprimer_produit");
     
  if(isset($_POST['fl'])!="i" && isset($_POST['fl'])!="d"){
     $template->assign_vars(array('FL'=>'<strong style="color:red;"><-Erreur champ vide</strong>'));
     $verif_numeric=1;
  }
  
 ////////////////////////////////////////////////////////////////////
/*         validation du champ id et executer traitement           /
/        de la requête supprimer logement avec vérification       /
/attention si logement existe déjà dans table dossier ou autre  */
/////////////////////////////////////////////////////////////////
  
		///////////////////////////////////////////////////////////////
		/* lecture des infos de connexion db du fichier dico.co     */
		/////////////////////////////////////////////////////////////
    	$tab_db=read_file_db();
		///////////////////////////////////////////////////////////////
		/* connexion                                                */
		/////////////////////////////////////////////////////////////
    	$db=connexionDatabase($tab_db[0],$tab_db[1],$tab_db[2],$tab_db[3]); 
    	////////////////////////////////////////////////////////////////
		/* il supprime pas le produit mais flag_prod � i=indisponible*/
		////////////////////////////////////////////////////////////// 
		if(@$_POST['fl']!="" && @$_POST['id']!="")  	
                	$id_prod=@delete_id_produit($db);
    	
    	    if(@$id_prod==1){
    	     if(@$_POST['fl']=='i')
    	     $template->assign_vars(array('INFO'=>'<strong style="color:green;">Le produit '.$_POST['id'].' est supprim&eacute; artificiellement</strong><br/>Le champ ID est obligatoire d=disponible i=indisponible'));
    	    
    	     else if(@$_POST['fl']=='d'){
    	      $template->assign_vars(array('INFO'=>'<strong style="color:green;">Le produit '.$_POST['id'].' est de nouveau disponible</strong><br/>Le champ ID est obligatoire d=disponible i=indisponible'));
    	     }
    	    }
    	    
    	    else if($verif_numeric!=1) {
    	     $template->assign_vars(array('INFO'=>'<strong style="color:red;">Le produit '.$_POST['id'].' n\'existe pas</strong><br/>Le champ ID est obligatoire d=disponible i=indisponible'));
    	     $verif=1;
    	     include('admin_menu_membre_cooperateur.html');
			 include('admin_menu_gestion_logement.html');
			 include('admin_menu_produit_service.html');
			 $template->pparse('supprimer_produit');
			 exit;
    	    }

 if(@$id_prod!=1)
             $template->assign_vars(array('INFO'=>'Identifiant du produit<br />Le champ ID est obligatoire d=disponible i=indisponible'));
include('admin_menu_membre_cooperateur.html');
include('admin_menu_gestion_logement.html');
include('admin_menu_produit_service.html');
$template->pparse('supprimer_produit');

}
?>