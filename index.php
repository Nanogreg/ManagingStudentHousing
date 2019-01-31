<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
<head>

<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=ISO-8859-1">
<meta name="description" content="Site de gestion de logement pour étudiant" />
<meta name="keywords" lang="fr" content="" />
<link rel="stylesheet" href="style/stylesheets/style.css" type="text/css" media="screen,projection" />
<link href="style/stylesheets/connexion.css" media="screen, projection" rel="stylesheet" type="text/css">

</head>
<!-- corps de page -->
<body>

<!-- Pour éviter des problèmes d'interface, il vaut mieux implementer les balises html de base dans le fichier php. Balises de base : html + css.-->

<?php
include('outils/db_existe.php');

 ///////////////////////////////////////////////////////////////////////////////
/* test d'affichage si db exite pas alors installation                       */
//////////////////////////////////////////////////////////////////////////////
/*le @ permet de cacher un warning ici , il s'agit de la création           /
du fichier dico.co qui ne le détecte pas au si supprimé ce qui est normal */
///////////////////////////////////////////////////////////////////////////

  if(@db_existe()==1){
    include('installation/installer.php');
    }
     
     else {
	include('outils/template.php');

	if (isset($_SESSION["user"]) and $_SESSION["user"]!=null){

		
	}
	else
	{
		$string="Bienvenue <i>Visiteur</i>";
		
		// On créé une instance de la classe template, passez en paramètre le répertoire ou se trouvent tous vos fichiers templates
		$template = new Template('style/template');
		
		// On assigne a un alias "test" le nom du fichier .tpl qu'on compte utiliser
		$template->set_filenames(array('user_ban' => 'header_out.html'));
		
		// On assigne un tableau de variables au template, en clef se situe le nom de la variable dans 
		// le fichier .tpl, en valeur ce qu'on lui donne comme valeur
		$template->assign_vars(array(
			'USER_BAN' =>		$string,
		));
		
		// On parse le fichier HTML, c'est à dire qu'on assigne aux fichier template toutes les données qu'on à créer dans le .php
		$template->pparse('user_ban');
	}
	
	include ("style/template/menu_index_post_install.html"); //importation du menu
	include("style/template/body_gen_index.html"); // importation du contenu de page
	include ("style/template/footer.html"); //importation du fond de page
}
?>
</body>
</html>