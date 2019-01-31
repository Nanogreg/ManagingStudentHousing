<?php
include('../outils/template_inc.php');
include('admin_header.html');

$logement=array('HIDDEN'=>'hidden;');
$template=template_inc('./admin','modifier_produit','admin_modifier_produit.html');

$template->assign_vars(array('INFO'=>'Les champs * sont obligatoires'));
$template->assign_vars(array('ACTION'=>'modifier_produit_ok.php'));

$template->assign_vars(array(
'IDEN'=>'""',
'NOM'=>'""',
'DES'=>'""',
'PRI'=>'""',
'IMG'=>'""',
'READONLY'=>'')
);


include('admin_menu_membre_cooperateur.html');
include('admin_menu_gestion_logement.html');
include('admin_menu_produit_service.html');
$template->pparse('modifier_produit');

?>