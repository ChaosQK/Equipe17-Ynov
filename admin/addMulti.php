<?php
    session_start();
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    if(!isset($_SESSION['token'])) {
        header("Location: /admin");
    } else {
        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
            include_once('../database/database.php');
            $bdd = bdd::getInstance();
            $increment = $bdd->select("SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'equipe17' AND TABLE_NAME = 'pictures'")['AUTO_INCREMENT'];
            
            $file = $_FILES['multiFile'];
            $total = count($file['name']);
            $sql = "";
            $array = array();
            for($i = 0; $i < $total; ++$i)
            {
                $fileext = explode('.', $file['name'][$i])[1];
                $filename = $increment . "." . $fileext;

                $tmp = $file['tmp_name'][$i];
                if($tmp != null)
                {
                    $uploadfile = '../public/img/' . $filename;
                    $sql .= "INSERT INTO pictures (filename, name, type, has_product, has_human, is_inst, is_vertical, author, limitrights, copyright, date, tags) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
                    array_push($array, $filename, "Unnamed", '0', '0', '0', '0', '0', "", '0', null, null, "");
                    move_uploaded_file($tmp, $uploadfile);
                }

                $increment++;
            }
            $bdd->execute($sql, $array);
            //header("Location: /admin");
        }
    }
?>
<html>
    <?php include('./header.php'); ?>
    <body>
        <form class="multi_add" enctype="multipart/form-data" action="addMulti.php" method="POST">
            <input type="file" name="multiFile[]" required multiple>
            <input class='button_success' type="submit" value="Ajouter">
        </form>
        <script src="../public/js/script.js"></script>
    </body>
</html>