<?php
if($_COOKIE['idUser']==""){
    header("Location:/",true,307);
}
include_once("include/selectedFunc.php");
$data = photoDetailsFnc($_POST['idPhoto']);
?>
<html>
    <head>
        <title>Details page</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <img width="900" height="600" src="<?=$data['file_path']?>">
                </div>
                <div class="col-sm-10">
                    <h4>Tags:<?=$data['tags']?></h4>
                    <h4>The date of the post:<?=$data['date']?></h4>
                    <h4>User:<?=$data['login']?></h4>
                    <h4>Views:<?=$data['views']?></h4>
                    <a href="mainPage.php" class="btn btn-primary">Exit</a>
                </div>
            </div>
        </div>
    </body>
</html>
