<?php
function countWords($Val){
    $sym = [",",".","-",PHP_EOL];
    $array1=[];
    $text = str_replace($sym,"",$Val);
    $text = mb_strtolower($text);
    $array = explode(" ",$text);
    $count = count($array);
    $insertData =[];
    foreach ($array as $word){
        if(!array_key_exists($word,$array1)){
            $array1[$word] = 1;
        }else{
            $array1[$word] += 1;
        }
    }

    $pdo = new PDO('mysql:host=localhost:3306;dbname=ex3',"root","root");
    //Insert Uploaded text
    $query = 'INSERT INTO uploaded_text(content,date,words_count) VALUES(?,?,?)';
    $statement = $pdo->prepare($query);
    $statement->execute([$Val,date("Y-m-d h:i:s"),$count]);

    $query = 'SELECT id FROM uploaded_text order by id desc';
    $id = $pdo->query($query)-> fetch();

    foreach ($array1 as $key => $val){
        array_push($insertData,array($id[0],$key,$val));
    }

    $statement = $pdo->prepare('INSERT INTO word(text_id,word,count) VALUES (?,?,?)');
    $pdo->beginTransaction();
    foreach ($insertData as $row){
        $statement->execute($row);
    }
    $pdo->commit();

    header("Location: /",true,307);
}


if(empty(!$_FILES['docs']['name'])){
    $val = file_get_contents($_FILES['docs']['tmp_name']);
    if(!empty($val)){
        countWords($val);
    }
}