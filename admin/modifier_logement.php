<?php
include('../outils/template_inc.php');
include('admin_header.html');

$logement=array('HIDDEN'=>'hidden;');
$template=template_inc('./admin','modifier_logement','admin_modifier_logement.html');

$template->assign_vars(array('INFO'=>'Les champs * sont obligatoires<br/>Entrer un ID entre 1 et 30'));
$template->assign_vars(array('ACTION'=>'modifier_logement_ok.php'));

$template->assign_vars(array(
'IDEN'=>'""',
'IMG'=>'""',
'ADR'=>'""',
'LOC'=>'""',
'CODEP'=>'""',
'PRI'=>'""',
'CAU'=>'""',
'LIT2'=>'',
'LIT3'=>'',
'LIT4'=>'',
'NBRLIT2'=>'"nbrlit2"',
'NBRLIT3'=>'"nbrlit3"',
'NBRLIT4'=>'"nbrlit4"',
'READONLY'=>'')
);


include('admin_menu_membre_cooperateur.html');
include('admin_menu_gestion_logement.html');
include('admin_menu_produit_service.html');
$template->pparse('modifier_logement');

?>