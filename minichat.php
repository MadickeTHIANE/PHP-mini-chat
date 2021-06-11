<?php

/**
 *todo créer le formulaire => action='minichat_post.php' method='POST'
 *todo récupérer la base de donnée
 *todo depuis la base de donnée afficher les 10 messages du plus récent au plus ancien  */
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minichat OPC</title>
</head>

<body>
    <form action="./minichat_post.php" method="POST">
        <label for="pseudo">Votre pseudo : <input type="text" id="pseudo" name="pseudo"></label>
        <label for="commentaire">Votre commentaire : <textarea name="commentaire" id="commentaire" cols="30" rows="5" >Ceci est un commentaire</textarea></label>
        <input type="submit" value="Envoyer">
        <?php
        /**
         * todo => Proposez d'actualiser le minichat. Le minichat ne s'actualise pas automatiquement s'il y a de nouveaux messages. C'est normal, ce serait difficile à faire à notre niveau. À la base, le Web n'a pas vraiment été prévu pour ce type d'application. En revanche, ce que vous pouvez facilement faire, c'est proposer un lien « Rafraîchir » qui charge à nouveau la page minichat.php  . Ainsi, s'il y a de nouveaux messages, ils apparaîtront après un clic sur le lien.
         */
        ?>
        <input type="submit" value="Rafraîchir" name='actualiser'>
    </form>
    <br>
    <?php
    $bdd = new PDO('mysql:host=localhost;dbname=test;chartset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    $top10 = $bdd->query('SELECT*FROM minichat ORDER BY ID DESC LIMIT 10');
    // print_r($bdd);
    ?>
    <br><br>
    <?php
    // print_r($top10);
    ?>
    <br>
    <hr>
    <?php
    while ($info = $top10->fetch()) {
        echo '<p>Message de ' . $info['pseudo'] . ' : ' . $info['commentaire'] . '</p>';
    }
    $top10->closeCursor();
    //*======= ou ========

    // while ($info = $top10->fetch()) {
    //     echo '<p>Message de ' . htmlspecialchars($info['pseudo']) . ' : ' . htmlspecialchars($info['commentaire']) . '</p>';
    //     }
    //? avec cette méthode pas besoin de mettre htmlspecialchars dans la cible

    

    ?>
    <hr>
    <?php
    /**
     * todo => Retenir le pseudo. On doit actuellement saisir à nouveau son pseudo à chaque nouveau message. Comme vous le savez probablement, il est possible en HTML de préremplir un champ avec l'attribut value  . Par exemple :
     *?<input type="text" name="pseudo" value="M@teo21" />
     *todo =>Remplacez M@teo21  par le pseudonyme du visiteur. Ce pseudonyme peut être issu d'un cookie, par exemple : lorsqu'il poste un message, vous inscrivez son pseudo dans un cookie, ce qui vous permet ensuite de préremplir le champ.
     */

    ?>

    <?php
    /**
     * todo => Afficher les anciens messages. On ne voit actuellement que les 10 derniers messages. Sauriez-vous trouver un moyen d'afficher les anciens messages ? Bien sûr, les afficher tous d'un coup sur la même page n'est pas une bonne idée. Vous pourriez imaginer un paramètre $_GET['page']  qui permettrait de choisir le numéro de page des messages à afficher.
     */
    if (isset($_GET['page'])) {
        $requete_3 = $bdd->prepare('SELECT * FROM minichat WHERE ID=?');
        $requete_3->execute(array($_GET['page']));
        while ($donnee = $requete_3->fetch()) {
            echo '<p>Vous avez demandé à voir le commentaire de la page ' . $_GET['page'] . ' : ' . $donnee['commentaire'] . '</p>';
        }
        $requete_3->closeCursor();
    }
    
    ?>
</body>

</html>