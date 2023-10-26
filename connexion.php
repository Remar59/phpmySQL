<?php

//FONCTION DE CONNEXION

//on créé la fonction qu'on appelle connexion
function connexion(){
    //Variables de connexion au serveur
    $server = 'localhost';
    $user = 'root';
    $password = '';
    $bdd = 'm2i';
    
    //On stocke la connexion dans une variable
    $connect = mysqli_connect($server, $user, $password, $bdd);

    //vérifie la condition dans laquelle $connect ne retourne aucune valeur (echec de connexion)
    if(!$connect) { 
        //on affiche un message d'erreur stocké dans mysql
        //die = affiche message et déconnecte en même temps
        die('Erreur de connexion : ' . mysqli_connect_error());
    }

    //return permet à la fonction connexion() de prendre la valeur $connect, ce qui va nous permettre de l'utiliser ailleurs
    return $connect;
}

?>