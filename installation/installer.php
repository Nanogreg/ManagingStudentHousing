<?php
 ///////////////////////INSTALLATION MSH///////////////////////
 //                                                         //
 //         Script d'installation                          //
//          Auteur:Giovanni Puzzo                         //
///////////////////////////////////////////////////////////
include('./outils/template_inc.php');
$template=template_inc('./installation','installation','installation.html');
$install=array('CHEMIN'=>'"./outils/formValidation.php"','MATRICULE'=>'Matricule','HOTE'=>'Votre h&ocirc;te ex:localhost','DBNAME'=>'Nom DB','UTILISATEUR'=>'utilisateur','MOTDEPASSE'=>'Votre mot de passe','NOM'=>'Votre nom','PRENOM'=>'votre pr&eacute;nom','EMAIL'=>'Votre Email','ADRESSE'=>'Votre adresse','LOCALITE'=>'Votre localit&eacute;','CP'=>'Votre code postal','SECTION'=>'ex:2IG,3SMS','TELEPHONE'=>'T&eacute;l&eacute;phone ou GSM','DATE'=>'Au format AAAA-MM-JJ','MOTDEPASSE'=>'Votre mot de passe','MOTDEPASSE2'=>'Re&eacute;crire le mot de passe');

foreach($install as $cle=>$valeur)
$template->assign_vars(array($cle=>$valeur));

$template->pparse('installation');

?>