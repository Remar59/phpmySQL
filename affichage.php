<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Affichage PHP</title>
</head>
<body>

<?php

//FONCTION D'AFFICHAGE

//on créé la fonction qu'on appelle affichage
//on précise $connect entre () pour lui faire comprendre qu'il s'agit d'un paramètre dont elle va avoir besoin, et qu'elle pourra remplacer quand on fera appel à elle
function affichage($connect){
    //on créé une variable de requete => afficher l'id, le nom et prénom de la table apprenants, par ordre croissant d'id
    $req_affichage = "SELECT `apprenant`.`ID`, `NOM`,`PRENOM`,`CODE_METIERS`,`code_rome`,`libelle_rome` FROM `apprenant` LEFT JOIN `metiers` ON `apprenant`.`CODE_METIERS` = `metiers`.`code_rome` ORDER BY `apprenant`.`ID`";

    //on exécute la requete (resultat => res)
    //on se connecte ($connect) puis (->) on utilise query() pour executer la requete stockée dans $req
    $res_req_affichage = $connect -> query($req_affichage);

    //affichage HTML
    //on passe par mysqli_fecth_array pour aller chercher les données de la requête et les stocker sous forme de tableau 
    //comme c'est un tableau, on utilise la boucle while() pour lire chaque ligne successivement et exécuter les actions de la boucle pour la ligne en question (on aurait pu passer par le foreach())
    while($data = mysqli_fetch_array($res_req_affichage)){
        //affichage des données sous forme de tableau
        //je décompose en plusieurs echo pour plus de lisibilité, mais j'aurai pu tout concaténer en un seul

        //première colonne = checkbox pour la suppression
        //la value=$data['id'] permet de donner à la checkbox la valeur id issue de la requête au-dessus
        //le name='id[]' permettra de récupérer la value en utilisant un $_GET['id'] ou $_POST['id'] là où en aura besoin (dans delete.php) (les [] servent à indiquer que les names seront stockés dans un tableau s'il y en a plusieurs)
        //les balises label sont juste là pour le style
        echo "<tr> <td style='text-align:center; width: fit-content;'> <label for='check" . $data['ID'] . "' style='background-color:red; border-radius:3px;'> <input type='checkbox' name='id[]' id='check" . $data['ID'] . "'  value='" . $data['ID'] . "' /></label> </td>"; 

        //deuxieme colonne = prénom
        //on affiche juste le nom récupéré de la requête au-dessus
        echo "<td>" . $data['NOM'] . "</td>";
        
        //troisieme colonne = nom
        //on affiche juste le prénom récupéré de la requête au-dessus
        echo "<td>" . $data['PRENOM'] . "</td>";

         //quatrieme colonne = métiers
        //on affiche juste le prénom récupéré de la requête au-dessus
        echo "<td>" . $data['libelle_rome'] . "</td>";

        //cinquieme colonne = radio bouton pour l'update
        //globalement la même chose que pour la checkbox
        echo "<td style='text-align:center; '><label for='radio" . $data['ID'] . "' style='background-color:orange; border-radius:50px;'> <input type='radio' id='radio" . $data['ID'] . "' name='radio_update' value='" . $data['ID'] . "'></td></label></tr>";
    }
}

?>   

</body>
</html>