<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP_MySQL</title>
</head>

<body style="font-family:'Roboto', sans-serif;">

    <!-- ouverture du PHP -->
    <?php
    //require permet de faire le lien avec un autre fichier, puisqu'on va utiliser une fonction dans ce fichier (même principe que le CSS)
    require("affichage.php");
    require("connexion.php");

    //on attribue à la variable $connect la valeur retournée par connexion()
    $connect = connexion();

$req_metier = "SELECT DISTINCT `libelle_rome` FROM `metiers` ORDER BY `libelle_rome`";
$res_req_metier = $connect -> query($req_metier);

    ?>
    <!-- on ferme le PHP et on revient en HTML -->

    <div style="margin:auto; width:fit-content; display: flex; flex-direction: column; align-items:center; gap:10px">
        <h1 style="margin:50px 0; width=fit-content;">Formulaire PHP MySQL</h1>


        <!-- FORMULAIRE 

J'ai juste fait un seul formulaire pour toutes les actions qu'on veut faire 
On utilisera la classe "formaction" dans les boutons de validation (input submit) pour changer le type d'action que l'on veut (par défaut action = insert.php)
-->
        <form action="insert.php" method="post"
            style="width:fit-content; display:flex; flex-direction: column; gap:10px; align-items:center">
            <div>
                <!-- les input Nom et Prenom nous serons utiles pour l'insertion et l'update -->
                <input type="text" placeholder="Nom" name="nom" maxlength="30" minlength="2"
                    style="width:200px; font-size:15px">
                <input type="text" placeholder="Prénom" name="prenom" maxlength="30" minlength="2"
                    style="width:200px; font-size:15px">

                <!-- Input permettant de modifier le champs métier, suivi de la recherche permettant de trouver le nom de métier dans la base de donnée existante-->
                <input type="text" placeholder="Métier" name="metier" maxlength="30" minlength="2"
                    style="width:200px; font-size:15px">
                <label>Métier</label><select name="Search">
<?php

                while($data = mysqli_fetch_array($res_req_metier)){
                    echo "<option> {$data['libelle_rome']} </option>";
                }
                    ?>
                </select>
                

                <!-- Bouton 1 = Ajouter (voir "insert.php")-->
                <input type="submit" value="Ajouter" name="insert" class="btn1"
                    style="width:fit-content; border-radius:5px;">
            </div>

            <!-- Je créé mon tableau ici pour pouvoir mettre les en-têtes (et le styliser) -->
            <table
                style=" border: 1px solid black; max-width: 700px; min-width: 700px; font-size: 20px; border-radius: 15px;">

                <!-- juste pour dimensionner les colonnes -->
                <colgroup>
                    <col span="1" style="width: 20%;">
                    <col span="1" style="width: 20%;">
                    <col span="1" style="width: 20%;">
                    <col span="1" style="width: 20%;">
                    <col span="1" style="width: 20%;">
                </colgroup>

                <!-- corps du tableau -->
                <tbody>
                    <tr style="text-align:center; font-weight:bold;">
                        <th>
                            <!-- Bouton 2 = Délétion (formaction="delete.php") -->
                            <input type="submit" value="Supprimer" name="delete" class="btn2" formaction="delete.php"
                                style="width:fit-content; border-radius:5px;">
                            <label for="checkall"
                                style="font-size: 15px;">ALL<!-- la première ligne est un peu barabre, elle permet de cocher toutes les checkbox d'un coup (pour la suppression) -->
                                <input type='checkbox' id="checkall" style="width: fit-content;"
                                    onclick="for(c in document.getElementsByName('id[]')) document.getElementsByName('id[]').item(c).checked = this.checked"></label>
                        </th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Métiers</th>
                        <th style="width:fit-content;">
                            <!-- Bouton 3 = Modification (formaction="update.php") -->
                            <input type="submit" value="Modifier" name="updatebtn" class="btn3" formaction="update.php"
                                style="width:fit-content; border-radius:5px;">
                        </th>
                    </tr>

                    <!-- on vient récupérer le reste du tableau dans la BDD grâce à la fonction affichage (voir "affichage.php") -->
                    <?php
                    //pour indiquer que la fonction doit être exécutée avec $connect il faut lui préciser entre ()
                    affichage($connect);
                    ?>
                </tbody>
            </table>
        </form>


        <!-- MESSAGES -->

        <!-- balise de mise en forme -->
        <span style='width:fit-content; margin:30px 0; font-weight:bold;'>
            <?php

            //on va chercher s'il y a "message" dans l'URL
            if (strpos($_SERVER['REQUEST_URI'], "message") !== false) {
                //si oui, on récupère le message par méthode GET, que l'on stocke dans une variable
                $message = $_GET['message'];
                //on affiche la variable
                echo $message;
            }

            ?>
        </span>


        <!-- STYLES -->

        <style>
            .btn1 {
                background-color: green;

            }

            .btn1:hover {
                background-color: lightgreen;
            }

            .btn2 {
                background-color: red;

            }

            .btn2:hover {
                background-color: pink;
            }

            .btn3 {
                background-color: orange;

            }

            .btn3:hover {
                background-color: yellow;
            }

            .btn1,
            .btn2,
            .btn3 {
                font-size: 20px;
                font-weight: bold;
            }

            td {
                border-top: 1px solid gray;
            }
        </style>


    </div>
</body>

</html>