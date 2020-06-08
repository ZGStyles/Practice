<?php
$text = "Result";
if(isset($_POST['Upload'])){
    $text="Upload";
}
if(isset($_POST['moreInf'])){
    $text="info";
}

$pdo = new PDO('mysql:host=localhost:3306;dbname=ex3',"root","root");
?>

<html>
<head>
    <title>Главная страница</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body>

    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
        <h5 class="my-0 mr-md-auto font-weight-normal">Navigation bar</h5>
        <nav class="my-2 my-md-0 mr-md-3">
            <form action = "3.1.php" method="post">
                <button type="submit" name="Upload" class="btn btn-outline-secondary">Upload</button>
            </form>
        </nav>
    </div>
    <?php if($text == 'Upload'): ?>
        <form enctype="multipart/form-data" method="post" action="3.php">
            <input type="file" name="docs" class="form-control-file"><br>
            <input type="submit" class="btn btn-primary">
        </form>
    <?php elseif($text != 'info'):?>
        <h1>Results</h1><br>
        <?php
        $query = 'SELECT * FROM uploaded_text';
        $allRows = $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
        foreach ($allRows as $array):?>
        <form action="3.1.php" method="post">
            <div class="alert alert-info">
                <h5>Date:<?=$array['date']?></h5>
                <h5>Text:<?=substr($array['content'],0,80)."...."?></h5>
                <h5>Total words:<?=$array['words_count']?></h5>
                <input name="idText" type="hidden" value="<?=$array['id']?>">
                <input type="submit" name="moreInf" class="btn btn-primary" value="More information">
            </div>
        </form>
        <?php endforeach;?>
    <?php else:?>
    <table class="table">
        <tr>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Word</th>
                <th scope="col">Count</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $query = "SELECT * FROM word WHERE text_id = {$_POST['idText']}";
        $allRows = $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
        foreach ($allRows as $array):?>
        <tr>
            <th scope="row"><?=$array['id']?></th>
            <td><?=$array['word']?></td>
            <td><?=$array['count']?></td>
        </tr>
        <?php endforeach;?>
        </tbody>
    </table>
    <?php endif;?>
</body>
</html>