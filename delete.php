<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete PHP</title>
</head>
<body>
    
<?php

require('affichage.php');
require('connexion.php');

//VARIABLES

//variables pour récupérer les infos du formulaire
//l'id est récupéré grâce aux checkbox (sous forme de tableau)
$id = $_POST["id"];


//On s'assure que le bouton radio a bien été coché (si la valeur id est vide, on retourne directement sur l'index)
if (empty($id)){
    header('Location: index.php?message=Choisissez un nom à supprimer.');
    exit();
}
else{

    //CONNEXION

    $connect = connexion();
    
    //on créé un variable tableau pour stocker le nom des gens supprimés (pour le message de retour)
    $array_supp = array("Les utilisateurs :");

    //AFFICHAGE DU NOM SUPPRIME (ne s'affichera pas vu qu'on fait un retour vers l'index)

    //comme on récupère l'id via les checkbox, il peut y en avoir plusieurs, du coup les id seront stockés sous forme de tableau donc on passe par un foreach
    foreach($_POST["id"] as $choix){
        //requête => affiche le nom et prenom de la BDD où l'id correspond à la checkbox cochée (une par une vu qu'on est dans une boucle)
        $select = "SELECT  `nom`, `prenom` FROM `apprenant` WHERE `id` = '" . $choix . "'";
        //on execute la requete
        $res_select = mysqli_query($connect, $select);
        //on créé une variable pour stocker les infos de la requête sous forme de tableau (on s'en servira pour afficher le nom supprimé)
        $data = mysqli_fetch_array($res_select);
        
        //SUPPRESSION
        
        //requête => supprime la ligne du tableau apprenants où l'id correspond à la checkbox cochée (une par une vu qu'on est dans une boucle)
        $delete = "DELETE  FROM `apprenant` WHERE `id` = '" . $choix . "'";
        //on l'exécute
        $res_delete = mysqli_query($connect, $delete);

        //on ajoute le nom de la personne supprimée dans le tableau
        array_push($array_supp, $data['prenom'] . " " . $data['nom']);
    }
    
    //si plusieurs personnes ont été supprimées
    if (count($id)>1){
        //on ajoute une dernière ligne au tableau pour conclure
        array_push($array_supp, "ont été supprimés.");
        //on transforme le tableau en une seule chaine de caractère (chaque ancienne ligne est séparéé par <br><br>) que l'on stocke dans une variable
        $str_supp = implode('<br><br>', $array_supp);
        //on retourne à l'index en affichant la variable dans le message
        header('Location: index.php?message=' . $str_supp);
        exit();
    }

    //si une seule personne a été supprimée
    else{
        //on retourne à l'index en affichant un message
        header('Location: index.php?message=' . "L'utilisateur " . $data['prenom'] . " " . $data['nom'] . " a été supprimé.");
        exit();
    }
}
?>
</body>
</html>