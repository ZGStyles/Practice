<?php
if($_COOKIE['idUser'] == ""){
    header("Location: /",true,307);
}
require_once("include/selectedFunc.php");
?>

<html>
    <head>
        <title>
            Filter Page
        </title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    </head>
    <body>
    <div class="container">
        <div class="row">
            <?php
            $allRows = filterFnc($_POST['tag']);
            foreach ($allRows as $data):
                ?>
                <div class="col-sm-4">
                    <form action="photoDetails.php" method="post">
                        <div class="alert alert-primary">
                            <img style="width: 250px;height: 250px" src="<?=$data['file_path']?>"><br>
                            <h5>Views:<span class="badge badge-pill badge-secondary"><?=$data['views']?></span></h5>
                            <input name="idPhoto" type="hidden" value="<?=$data['id']?>">
                            <button type="submit" class="btn btn-primary" name="moreDetails">More details</button>
                        </div>
                    </form>
                </div>
            <?php endforeach;?>
        </div>
    </div>
    <form action="Engine.php" method="post">
        <button name="exit" type="submit" class="btn btn-primary">Main Page(Exit)</button>
    </form>
    </body>
</html>
