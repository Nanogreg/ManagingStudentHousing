<?php	
//////////////////////////////////////////////
//          Auteur: GCuyle          //
/////////////////////////////////////////////
//	Cette page permet de selectionner un étudiant dans une liste et peut le modifier ensuite //
///////////////////////////////////////////////////////////////////////////////////////////////

	/* Include du html */
	include('admin_header.html');
	include('admin_body.html');
	include('admin_menu_gestion_logement.html');
	include('admin_menu_produit_service.html');
	include('admin_menu_membre_cooperateur.html');

	/* Include des outils */
	include('../outils/db_existe.php');
	include('../outils/template_inc.php');
	include('../outils/connect_database.php');
	include('admin_header.html');
	include('../outils/requetes.php');
	
	/* On initialise les variables pour se connecter à la BDD + le template */
	$tab_db=read_file_db();
	$template=template_inc('./admin','modifierMembre','admin_modifier_membre.html');
	
	/* Traitement si une modification a été effectuée */
	if(isset($_POST['modifier'])){
		if($_POST['nom_etud']=="" || $_POST['prenom_etud']=="" || $_POST['rue_etud']=="" || $_POST['ville_etud']=="" || $_POST['cp_etud']=="" || $_POST['tel_etud']=="" || $_POST['email_etud']=="" || $_POST['mdp_etud']=="" || $_POST['dnaiss_etud']=="" || $_POST['section_etud']=="" || $_POST['responsable']==""){
			$template->assign_vars(array('HIDDENBOXMSG'=>';','BOXTYPE'=>'warning','MSG'=>'Veuillez remplir tout les champs !'));
			$template->assign_vars(array('HIDDENFORMMOD'=>';','HIDDENSELECT'=>'hidden'));
			//On "simule" la selection d'un étudiant avec son matricule pour réafficher le forulaire
			$_POST['select']="";
			$_POST['mat']=$_POST['mat_etud'];
		}
		else{
			if($_POST['responsable']=='membre')$_POST['responsable']=NULL;
			$reponse= modifEtudiant(connexionDatabase($tab_db[0],$tab_db[1],$tab_db[2],$tab_db[3]),$_POST['mat_etud'],$_POST['nom_etud'],$_POST['prenom_etud'],$_POST['rue_etud'],$_POST['ville_etud'],$_POST['cp_etud'],$_POST['tel_etud'],$_POST['email_etud'],$_POST['mdp_etud'],$_POST['dnaiss_etud'],$_POST['section_etud'],$_POST['responsable']);
			$template->assign_vars(array('HIDDENBOXMSG'=>';','BOXTYPE'=>'success','MSG'=>'Etudiant "'.$_POST['prenom_etud'].' '.$_POST['nom_etud'].'('.$_POST['mat_etud'].')" modifié !'));
		}
	}
	
	/* Traitement si un étudiant a été selectionné */
	if(isset($_POST['select'])){
		$etudiant = getEtudiant(connexionDatabase($tab_db[0],$tab_db[1],$tab_db[2],$tab_db[3]),$_POST['mat']);
		//Si l'étudiant n'est pas dans la BDD -> message d'erreur.
		if(!$etudiant){
			$template->assign_vars(array('HIDDENBOXMSG'=>';','BOXTYPE'=>'error','MSG'=>'Opération impossible, le matricule "'.$_POST['mat'].'" n\'existe pas !'));
			$template->assign_vars(array('HIDDENFORMMOD'=>'hidden'));
		}
		//Si l'étudiant est dans la base de donnée, on affihe le forulaire de modification avec les valeurs de l'étudiant
		else {
			$template->assign_vars(array(
				'HIDDENFORMMOD'=>';',
				'MAT'=>$etudiant['mat_etud'],
				'NOM'=>$etudiant['nom_etud'],
				'PRENOM'=>$etudiant['prenom_etud'],
				'RUE'=>$etudiant['adr_adr_rue'],
				'VILLE'=>$etudiant['adr_adr_localite'],
				'CODEPOSTAL'=>$etudiant['adr_adr_cp'],
				'TELEPHONE'=>$etudiant['telephone_etud'],
				'EMAIL'=>$etudiant['email_etud'],
				'MOTDEPASSE'=>$etudiant['pwd_etud'],
				'DATENAISS'=>$etudiant['date_naiss_etud'],
				'SECTION'=>$etudiant['section_inscrit'],
			));
			//On check la case responsable qui correspond
			if($etudiant['libelle']=='Etudiant')$template->assign_vars(array('MEMBRE'=>'CHECKED'));
			else if($etudiant['libelle']=='Coopérateur')$template->assign_vars(array('COOP'=>'CHECKED'));
			else if($etudiant['libelle']=='Gestionnaire')$template->assign_vars(array('GEST'=>'CHECKED'));
			//Si un étudiant est selectionné, on cache la selection d'étudiant
			$template->assign_vars(array('HIDDENSELECT'=>'hidden'));
		}
	}
	else{
		//Si un étudiant n'est pas selectionné, le formulaire de modification de membre est caché.
		$template->assign_vars(array('HIDDENFORMMOD'=>'hidden'));
	}
	
	//On remplis le forulaire de selection de membre
	/* On récupere tout les étudiants inscrits */
	$array = new ArrayObject();
	$array= getEtudiantsValid(connexionDatabase($tab_db[0],$tab_db[1],$tab_db[2],$tab_db[3]));
	
	/* On cree les <option> avec les objets presents dans $array */
	foreach($array as $etu){
		if($etu->libelle =="")$etu->libelle='membre';
		$template->assign_block_vars('OP',array(	 
			'MAT'=>$etu->mat_etud,
			'RESP'=>$etu->libelle,
			'NOM'=>$etu->nom_etud,
			'PRENOM'=>$etu->prenom_etud));
	}
	
	//On parse le html avec les valeurs php
	$template->pparse('modifierMembre');
?>