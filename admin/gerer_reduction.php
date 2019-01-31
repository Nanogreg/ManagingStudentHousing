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
        $template=template_inc('./admin','gerer_reduction','admin_gerer_reduction.html');
    	$template->assign_vars(array('ACTION'=>'gerer_reduction.php'));
    	$template->assign_vars(array('READONLY'=>'readonly="readonly"'));

if(!isset($_POST['modif'])) {
$template->assign_vars(array('INFO'=>'Mettre à jour les réductions'));
$tab=select_responsable($db);

         $template->assign_block_vars('REDUCTION',array(
        'LIBECOOP'=>$tab[0]['libelle'],'REDPRODCOOP'=>$tab[0]['reduc_prod'],'REDLOGCOOP'=>$tab[0]['reduc_log'],
    	'LIBEGEST'=>$tab[1]['libelle'],'REDPRODGEST'=>$tab[1]['reduc_prod'],'REDLOGGEST'=>$tab[1]['reduc_log']));	
}

else {

    if($_POST['reduction_coop_prod']>=0 && $_POST['reduction_coop_prod'] <=100 &&       	$_POST['reduction_log_coop']>=0 && $_POST['reduction_log_coop'] <=100 &&
    $_POST['reduction_gest_prod']>=0 && $_POST['reduction_gest_prod'] <=100 &&
    $_POST['reduction_log_gest']>=0 && $_POST['reduction_log_gest'] <=100  ) {

     update_responsable($db);
     $tab=select_responsable($db);

     $template->assign_vars(array('INFO'=>'<strong style="color:green;">R&eacute;duction modifi&eacute;e</strong>'));

        $template->assign_block_vars('REDUCTION',array(
        'LIBECOOP'=>$tab[0]['libelle'],'REDPRODCOOP'=>$tab[0]['reduc_prod'],'REDLOGCOOP'=>$tab[0]['reduc_log'],
    	'LIBEGEST'=>$tab[1]['libelle'],'REDPRODGEST'=>$tab[1]['reduc_prod'],'REDLOGGEST'=>$tab[1]['reduc_log']));

      }

      else {
           
     $tab=select_responsable($db);

     $template->assign_vars(array('INFO'=>'<strong style="color:red;">Erreur champ n&eacute;gatif</strong>'));

        $template->assign_block_vars('REDUCTION',array(
        'LIBECOOP'=>$tab[0]['libelle'],'REDPRODCOOP'=>$tab[0]['reduc_prod'],'REDLOGCOOP'=>$tab[0]['reduc_log'],
    	'LIBEGEST'=>$tab[1]['libelle'],'REDPRODGEST'=>$tab[1]['reduc_prod'],'REDLOGGEST'=>$tab[1]['reduc_log']));

      }
}

include('admin_menu_membre_cooperateur.html');
include('admin_menu_gestion_logement.html');
include('admin_menu_produit_service.html');

$template->pparse('gerer_reduction');

?>