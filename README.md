# CRUD PHP

formation m2i  php procedural mysql

## etapes

- requete

- query (mysqli_query)

-  affichage données => boucle si besoin (while ou foreach)


```
$req_affichage = "SELECT `id`, `nom`, `prenom`,`metiers` FROM `apprenant` ORDER BY `id`";

    $res_req_affichage = $connect -> query($req_affichage);
    while($data = mysqli_fetch_array($res_req_affichage)){}
```