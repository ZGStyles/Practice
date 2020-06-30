  
<?php
if($_COOKIE['idUser']==""){
    header("Location:/",true,307);
}
include("include/selectedFunc.php");
$data = addTagsFnc($_POST['idPhoto']);
?>
<html>
<head>
    <title>Tags page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <img width="900" height="600" src="<?=$data['file_path']?>">
        </div>
        <div class="col-sm-10">
            <form method="post" action="Engine.php">
                <h5>Теги:<input name="newTags" value = "<?=$data['tags']?>" class="form-control"/></h5>
                <input name="idPhoto" hidden value="<?=$_POST['idPhoto']?>"/>
                <button name="changeTag" type="submit" class="btn btn-success">Save</button>
            </form>
            <a href="mainPage.php" class="btn btn-warning">Exit</a>
        </div>
    </div>
</div>
</body>
</html>
