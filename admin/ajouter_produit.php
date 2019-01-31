<?php
include('../outils/template_inc.php');
include('admin_header.html');

$logement=array('HIDDEN'=>'hidden;');
$template=template_inc('./admin','ajouter_produit','admin_ajouter_produit.html');

$template->assign_vars(array('INFO'=>'Les champs * sont obligatoires'));
include('admin_menu_membre_cooperateur.html');
include('admin_menu_gestion_logement.html');
include('admin_menu_produit_service.html');
$template->pparse('ajouter_produit');

?>