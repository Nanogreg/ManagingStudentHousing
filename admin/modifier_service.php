<?php
include('../outils/template_inc.php');
include('admin_header.html');

$logement=array('HIDDEN'=>'hidden;');
$template=template_inc('./admin','modifier_service','admin_modifier_service.html');

$template->assign_vars(array('INFO'=>'Les champs * sont obligatoires'));
$template->assign_vars(array('ACTION'=>'modifier_service_ok.php'));

$template->assign_vars(array(
'NOM'=>'""',
'PRI'=>'""',
'DES'=>'""',
'DUR'=>'""',
'DAT'=>'""',
'READONLY'=>'')
);


include('admin_menu_membre_cooperateur.html');
include('admin_menu_gestion_logement.html');
include('admin_menu_produit_service.html');
$template->pparse('modifier_service');

?>