<?php

    include_once('./database/database.php');
    $bdd = bdd::getInstance();
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $name = $_POST['name'];
        $author = $_POST['author'];
        $tags = $_POST['tags'];

        $prepare = array();

        $conditions = " WHERE ";

        if($name == "" && $author == "" && $tags == "") {
            $conditions = "";
        }
        else
        {

            if($name != "") {
                $conditions .= "name = ?";
                array_push($prepare, $name);
            }

            if($author != "") {
                $conditions .= ($name != "" ? " AND " : "") . "author = ?";
                array_push($prepare, $author);
            }
    
            if($tags != "") {
                $tag = explode(" ", $tags);
                $conditions .= ($name != "" || $author != "" ? " AND " : "");
                for($i = 0; $i < sizeof($tag); ++$i)
                {
                    $conditions .= "tags LIKE '%" . $tag[$i] . "%' " . ($i != (count($tag)-1) ? 'OR ' : '');
                    //array_push($prepare, $tag[$i]);
                }
            }
        }  
        
        $pictures = $bdd->selectAllPrepare('SELECT * FROM pictures' . $conditions, $prepare);
    }else{
        $pictures = $bdd->selectAll('SELECT * FROM pictures');
    }
?>

<html>
    <head>
        <title></title>
        <link href="./public/css/style.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body>
        <nav class="passion_nav">
            <div class="titre">PassionFroid</div>

            <div class="recherche">
                <div class="titre">Recherche</div>
                <form enctype="multipart/form-data" action="index.php" method="POST">
                    <div class="text_element">
                        <label style="font-size: 16px;">Nom de l'image:</label>
                        <input type="text" name="name" class="input_text"></input>
                    </div>
                    <div class="text_element" style="margin-top: 14px">
                        <label style="font-size: 16px">Auteur de l'image:</label>
                        <input type="text" name="author" class="input_text"></input>
                    </div>  
                    <div class="text_element" style="margin-top: 14px">
                        <label style="font-size: 16px">Tags de l'image:</label>
                        <input type="text" name="tags" class="input_text"></input>
                    <div>
                    <input type="submit" value=Rechercher class="search_btn" style="margin-top: 18px;">
                </form>
            </div>
        </nav>
            <div class="pictures_div">
            <?php
            for($i = 0; $i < count($pictures); ++$i)
            {
                $picture = $pictures[$i];
                ?>
                <div class="picture_element">
                    <div class="div_picture">
                        <img class="pictures" src="<?php echo './public/img/' . $picture['filename'] ?>" onclick="onImageClicked(event);">
                        <div class="download_img"><a href="<?php echo './public/img/' . $picture['filename'] ?>" download="<?php echo ($picture['name'] . '-' . $picture['filename']) ?>"><i class="fa fa-download"></i></a></div>
                    </div>
                    <label style="margin-top: 12px;"><?php echo $picture['name'] ?></label>
                </div>
                <?php
            }
            ?>
            </div>
        <div class="fullscreen_picture" style="display: none;">
            <img id="picture_full" src="">
        </div>
        <script src="../public/js/script.js"></script>
    </body>
</html>