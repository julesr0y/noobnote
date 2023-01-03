<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "connect.php"; //connexion a la bdd

//récupération de toutes les notes
$sql = "SELECT * FROM `notes` ORDER BY `Id` DESC ";
$requete = $db->query($sql);
$notes = $requete->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-witdh, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="style/index.css">
    <title>Noobnote</title>
</head>
<body>
    <h1>Noobnote</h1>
    <h6>Oui, clairement l'opposé de Pronote :,)</h6>
    <form method="post">
        <select name="matiere" id="matiere">
            <option value="Maths">Maths</option>
            <option value="Physique">Physique</option>
            <option value="Prog">Prog</option>
            <option value="Web">Web</option>
            <option value="Anglais">Anglais</option>
            <option value="FH">FH</option>
        </select>
        <input type="text" name="nom">
        <input type="text" name="note">
        <select name="coeff" id="coeff">
            <option value="1">1</option>
            <option value="20">20</option>
            <option value="50">50</option>
            <option value="100">100</option>
        </select>
        <button type="submit">Ajouter la note</button>
    </form>
    <br>
    <?php
    if(!empty($_POST)){
        if(isset($_POST["matiere"], $_POST["nom"], $_POST["coeff"]) && !empty($_POST["note"]))
        {
            $ajout_matiere = strip_tags($_POST["matiere"]);
            $ajout_nom = strip_tags($_POST["nom"]);
            $ajout_note = strip_tags($_POST["note"]);
            $ajout_coeff = strip_tags($_POST["coeff"]);

            $sql = "INSERT INTO `notes`(`matiere`, `nom`, `note`, `coeff`) VALUES(:matiere, :nom, :note, :coeff)";
            $query = $db->prepare($sql);
            $query->bindValue(":matiere", $ajout_matiere, PDO::PARAM_STR);
            $query->bindValue(":nom", $ajout_nom, PDO::PARAM_STR);
            $query->bindValue(":note", $ajout_note, PDO::PARAM_STR);
            $query->bindValue(":coeff", $ajout_coeff, PDO::PARAM_STR);
            $query->execute();
            header("Location: /index.php");
        } else {
            echo "<br><div class='erreur'>Envoi impossible, l'entrée est incomplète</div>";
        }
    }
    ?>


    <? //partie affichage des notes ?>
    <?php foreach($notes as $note): ?>
        <?php 
        $note_matiere = $note["matiere"];
        $note_nom = $note["nom"];
        $note_note = $note["note"];
        $note_coeff = $note["coeff"];
        ?>
        <table>
            <tr>
                <td><? echo "$note_matiere"; ?></td>
                <td><? echo "$note_nom"; ?></td>
                <td><? echo "$note_note"; ?></td>
                <td><? echo "Coeff: $note_coeff"; ?></td>
            </tr>
        </table>
    <?php endforeach; ?>

    <br>

    <?php
    $cpt = 0;
    $somme = 0;
    foreach($notes as $note):
        $somme += $note["note"] * $note["coeff"]; //on ajoute la note multipliée par son coeff (calcul de moyenne)
        $cpt += $note["coeff"]; //on ajoute le coeff de la note au diviseur (calcul de moyenne)
    endforeach;
    if($cpt != 0){ //permet d'éviter un message d'erreur (division par 0) si aucune note n'a été encore rentrée
        $moyenne = $somme/$cpt;
        echo "<strong>Moyenne: $moyenne</strong>";
    }
    else{
        echo "<strong>Ajoutez des notes pour obtenir votre moyenne</strong>";
    }
    ?>

    <footer>
        <img class="github" src="img/github.webp" alt="Official Github" onclick="window.location.href='https://github.com/julesr0y/noobnote'">
    </footer>
</body>
</html>