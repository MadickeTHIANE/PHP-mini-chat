<?php

/**
 *todo récupérer le message envoyé 
 *todo l'ajouter à la base de donnée
 *todo  */


$bdd = new PDO('mysql:host=localhost;dbname=test;chartset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
//? Si on clique sur rafraîchir
if (isset($_POST['actualiser'])) {
    //? On efface la table
    $vierge = $bdd->exec('DELETE FROM minichat');
    header('Location: minichat.php');
} elseif (isset($_POST['pseudo']) and isset($_POST['commentaire']) and $_POST['pseudo']!=null and $_POST['commentaire']!=null) {
    $commentaire = htmlspecialchars($_POST['commentaire']);
    $pseudo = htmlspecialchars($_POST['pseudo']);

    $req = $bdd->prepare('INSERT INTO minichat(pseudo, commentaire) VALUES(:pseudo,:commentaire)');
    $req->execute(array(
        'pseudo' => $pseudo,
        'commentaire' => $commentaire
    ));

    //* ======= ou =======

    // $req = $bdd->prepare('INSERT INTO minichat (pseudo, message) VALUES(?, ?)');
    // $req->execute(array($_POST['pseudo'], $_POST['message']));



    header('Location: minichat.php');
}else{
echo 'Veuillez rentrer un pseudo et un commentaire !';
}
?>
