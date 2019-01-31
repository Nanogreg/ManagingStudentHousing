<?php
include('../outils/db_existe.php');
include('../outils/template_inc.php');
include('../outils/connect_database.php');
include('admin_header.html');
include('../outils/requetes.php');
$verif=0;

if(isset($_POST['matricule'])){

    if($_POST['matricule'] !=""){
      $verif=1; 
///////////////////////////////////////////////////////////////
/* lecture des infos de connexion db du fichier dico.co     */
/////////////////////////////////////////////////////////////
    $tab_db=read_file_db();
    $template=template_inc('./','Rechercher','admin_rechercher_resultat.html');
///////////////////////////////////////////////////////////////
/* connexion                                                */
/////////////////////////////////////////////////////////////
    $db=connexionDatabase($tab_db[0],$tab_db[1],$tab_db[2],$tab_db[3]);
    $donnees=select_all_etudiant($db);
////////////////////////////////////////////////////////////////////////////
/* afficher par le template on parse le fichier admin_rechercher_resultat*/
//////////////////////////////////////////////////////////////////////////
   if($donnees['nom_etud']!=""){
    $template->assign_vars(array('RESULTAT'=>'Le résultat de votre recherche'));
    $template->assign_block_vars('afficher',array('matricule'=>$donnees['mat_etud'],'nom'=>$donnees['nom_etud'],'prenom'=>$donnees['prenom_etud'],'adresse'=>$donnees['adr_adr_rue'],'localite'=>$donnees['adr_adr_localite'],'cp'=>$donnees['adr_adr_cp'],'telephone'=>$donnees['telephone_etud'],'email'=>$donnees['email_etud'],'datenaissance'=>$donnees['date_naiss_etud'],'section'=>$donnees['section_inscrit'],'grade'=>$donnees['libelle']));
$template->pparse('Rechercher');
      }
      
      else
         $template->assign_vars(array('RESULTAT'=>'<strong style="color:red;">Aucun étudiant trouvé</strong>'));
         $template->pparse('Rechercher');
    }    
 }
if($verif==0) {
              $template=template_inc('./','Rechercher','admin_rechercher.html');
              $template->pparse('Rechercher');
          }            
                
include('admin_menu_membre_cooperateur.html');
include('admin_menu_gestion_logement.html');
include('admin_menu_produit_service.html');

?>