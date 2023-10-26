<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertion PHP</title>
</head>
<body>

<?php

//CONNEXION

//pour se connecter (et tester la connexion) on passe par le fichier connexion.php
require('connexion.php');
//on attribue à la variable $connect la valeur retournée par connexion() (sinon php ne connait pas sa valeur)
$connect=connexion();

//VARIABLES

//variables de récupération du formulaire
$nom = $_POST['nom'] ;
$prenom = $_POST['prenom'] ;

    
//VERIFICATION

//on vérifie que les champs ne sont pas vides
if(empty($nom) || empty($prenom)){
    header('Location: index.php?message=Veuillez remplir tous les champs.');
}
//on vérifie que les champs sont bien du texte (le is_string() est clairement pas adapté, vaut mieux passer par un pattern en HTML)
else if(!is_string($nom) || !is_string($prenom)){
    header('Location: index.php?message=Les champs doivent contenir seulement des lettres.');
}
//on vérifie la longueur max du texte
else if(strlen($nom)>30 || strlen($nom)>30){
    header('Location: index.php?message=Les champs ne peuvent contenir plus de 30 caractères.');
}
//on vérifie la longueur min du texte
else if (strlen($nom)<2 || strlen($nom)<2) {
    header('Location: index.php?message=Les champs doivent contenir au moins 2 caractères.');
}

//si c'est bon on vérifie que le nom est dispo
else{
    
    //VERIFICATION DISPONIBILITE

    //on créé une variable qui regroupe la requête MySQL => affiche un nom + prenom de la BDD si celui-ci correspond au nom + prenom rentré dans le formulaire
    $dispo = "SELECT `nom`, `prenom` FROM `apprenant` WHERE `nom` = '" . $nom . "' AND `prenom` = '" . $prenom . "'";
    //on créé une variable qui va stocker l'execution de la requête
    $res_dispo = mysqli_query($connect, $dispo);
    //mysqli_num_rows() permet de récupérer le nombre de lignes de la requête éxecutée (explication après)
    $row_dispo = mysqli_num_rows($res_dispo);

    //si le nombre de lignes est supérieur à 0, ça veut dire qu'il y a un nom dans la BDD qui correspond au nom du formulaire, dans ce cas on arrête le script et on retourne à l'index
    if ($row_dispo > 0){
        header('Location: index.php?message=' . "L'utilisateur " . $prenom . ' ' . $nom . ' existe déjà.');
    }

    //si c'est bon on passe à l'insertion
    else{

        //INSERTION
        
        //variable de requete 
        $insert = "INSERT INTO `apprenant` (`nom`, `prenom`) VALUES ('$nom', '$prenom')";
        $req_insert = $connect -> query($insert); //  autre commande = mysqli_query($connect, $insert);   //
        
        //MESSAGE
        
        //si la requête d'insertion a réussi, on retourne vers l'index en ajoutant dans l'URL un message, qu'on affichera dans l'index (une méthode GET faite à la main en gros)
        if ($req_insert){
            header('Location: index.php?message=' . "L'utilisateur " . $prenom . ' ' . $nom . ' a été ajouté.');
        }  
    }
}


?>

</body>
</html>