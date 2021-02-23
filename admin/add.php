<?php
    session_start();
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    if(!isset($_SESSION['token']))
    {
        header("Location: /admin");
    }else{
        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
            include_once('../database/database.php');
            $bdd = bdd::getInstance();
            $increment = $bdd->select("SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'equipe17' AND TABLE_NAME = 'pictures'")['AUTO_INCREMENT'];
            
            $file = $_FILES['file'];
            $fileext = explode('.', $file['name'])[1];
            $filename = $increment . "." . $fileext;
            $name = $_POST['name'];
            $type = $_POST['type'];

            $has_product = isset($_POST['has_product']) ? 1 : 0;
            $has_human = isset($_POST['has_human']) ? 1 : 0;
            $is_inst = isset($_POST['is_inst']) ? 1 : 0;
            $is_vertical = isset($_POST['is_vertical']) ? 1 : 0;
            $limitrights = isset($_POST['limitrights']) ? 1 : 0;

            $author = $_POST['author'];
            $copyright = $_POST['copyright'];
            $date = $_POST['date'];
            $tags = $_POST['tags'];

            $uploadfile = '../public/img/' . $filename;
            move_uploaded_file($file['tmp_name'], $uploadfile);
            $bdd->execute('INSERT INTO pictures (filename, name, type, has_product, has_human, is_inst, is_vertical, author, limitrights, copyright, date, tags) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);',
            array($filename, $name, $type, $has_product, $has_human, $is_inst, $is_vertical, $author, $limitrights, (!$limitrights ? null : $copyright), (!$limitrights ? null : $date), $tags));

            header("Location: /admin");
        }
    }
    
    
?>

<html>
        <?php include('./header.php'); ?>
    <head>
        <link href="../public/css/form.css" rel="stylesheet">
        <!--link href="../public/css/style.css" rel="stylesheet">-->
    </head>
    <body>
        <form class='addForm' enctype="multipart/form-data" action="add.php" method="POST">
            <div class='titre'><h1>Ajout d'une photo </h1></div>
            <input type="file" name="file" id="Insert" required>
            <div class="text_element">
                <label>Nom de l'image</label>
                <input type="text" name="name" required>
            </div>
            <div class="text_element">
                <label>Type d'image</label>
                <select name="type" class="select-css">
                    <option value="0" selected>PassionFroid</option>
                    <option value="1">Fournisseur</option>
                    <option value="2">Logo</option>
                </select>
            </div>
            <div class="checkbox_element">
                <input id="has_product" type="checkbox" name="has_product[]" value="1">
                <label for="has_product" style="margin-left: 8px">L'image contient-elle un produit ?</label>
            </div>
            <div class="checkbox_element">
                <input id="has_human" type="checkbox" name="has_human[]" value="1">
                <label for="has_human" style="margin-left: 8px">L'image contient-elle un humain ?</label>
            </div>
            <div class="checkbox_element">
                <input id="is_inst" type="checkbox" name="is_inst[]" value="1">
                <label for="is_inst" style="margin-left: 8px">L'image est institutionnelle ?</label>
            </div>
            <div class="checkbox_element">
                <input id="is_vertical" type="checkbox" name="is_vertical[]" value="1">
                <label for="is_vertical" style="margin-left: 8px">L'image est vertical ?</label>
            </div>
            <div class="text_element">
                <label>Auteur</label>
                <input type="text" name="author" required>
            </div>
            <div class="checkbox_element">
                <input id="limitrights" type="checkbox" name="limitrights[]" value="1">
                <label for="limitrights" style="margin-left: 8px">L'image est-elle copyrighté ?</label>
            </div>
            <div id="is_copyright" style="display: none">
                <div class="text_element">
                    <label>Quel est le droit d'autheur</label>
                    <input type="text" name="copyright">
                </div>
                <div class="text_element">
                    <label>Date de fin du droit d'usage du copyright</label>
                    <input type="date" name="date">
                </div>
            </div>
            <div class="text_element">
                <label>Renseignez le ou les tag(s) séparé par un espace</label>
                <textarea rows="5" type="textarea" name="tags"></textarea>
            </div>
            <input class='button_success' type="submit" value="Ajouter">
        </form>
        <script src="../public/js/script.js"></script>
    </body>
</html>