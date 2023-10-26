<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update PHP</title>
</head>
<body>

<?php

require("connexion.php");

//VARIABLES

//variables pour récupérer les infos du formulaire
$nom = $_POST["nom"];
$prenom = $_POST["prenom"];
$id = $_POST["radio_update"];


//On s'assure que le bouton radio a bien été coché (si la valeur id est vide, on retourne directement sur l'index)
if (empty($id)){
    header('Location: index.php?message=Choisissez un nom à modifier.'); //permet de revenir sur l'index
    exit(); //exit() permet d'arrêter l'exécution du code (sécurité supplémentaire)
}

else{

    //CONNEXION

    $connect = connexion();

    //VERIFICATION DISPONIBILITE DU NOM

    //on créé une variable qui regroupe la requête MySQL => affiche un nom + prenom de la BDD si celui-ci correspond au nom + prenom rentré dans le formulaire
    $verifnom = "SELECT `nom`, `prenom` FROM `apprenant` WHERE `nom` = '" . $nom . "' AND `prenom` = '" . $prenom . "'";
    //on créé une variable qui va stocker l'execution de la requête
    $res_verifnom = mysqli_query($connect, $verifnom);
    //mysqli_num_rows() permet de récupérer le nombre de lignes de la requête éxecutée (explication après)
    $row_verifnom = mysqli_num_rows($res_verifnom);

    //si le nombre de lignes est supérieur à 0, ça veut dire qu'il y a un nom dans la BDD qui correspond au nom du formulaire, dans ce cas on arrête le script et on retourne à l'index
    if ($row_verifnom > 0){
        header('Location: index.php?message=Ce nom existe déjà.');
        exit();
    }

    //on refait les mêmes tests que pour l'insertion
    else if (empty($nom) || empty($prenom)){
        header('Location: index.php?message=Veuillez remplir les champs Nom et Prénom.');
        exit();
    }
    else if(!is_string($nom) || !is_string($prenom)){
        header('Location: index.php?message=Les champs doivent contenir seulement des lettres.');
    }
    else if(strlen($nom)>30 || strlen($nom)>30){
        header('Location: index.php?message=Les champs ne peuvent contenir plus de 30 caractères.');
    }
    else if (strlen($nom)<2 || strlen($nom)<2) {
        header('Location: index.php?message=Les champs doivent contenir au moins 2 caractères.');
    }

    //si c'est bon, on met à jour le tableau
    else{

        //MESSAGE


        $select = "SELECT `nom`, `prenom` FROM `apprenant` where `id` = '" . $id . "'";
        $res_select = mysqli_query($connect, $select);
        while($data = mysqli_fetch_array($res_select)){
            // on retourne à l'index
            header('Location: index.php?message=' . "L'utilisateur " . $data['prenom'] . ' ' . $data['nom'] . ' a été remplacé par ' . $prenom . ' ' . $nom . '.');
            // on met pas de exit ici car on veut que le code continue de s'exécuter pour pouvoir faire l'update
        }

        //UPDATE
        
        //on fait l'update après le message car sinon les valeurs nom et prenom dans la requête auraient déjà été modifiées
        //requête => on change le nom et prénom de la ligne de la BDD où l'id correspond à l'id qu'on a choisi avec le bouton radio dans le formulaire
        $update = "UPDATE `apprenant` SET `nom` = '" . $nom . "', `prenom` = '" . $prenom . "' WHERE `apprenant`.`id` = '" . $id . "'";
        //on l'exécute
        $res_update = mysqli_query($connect, $update);
    }
}


?>

</body>
</html>