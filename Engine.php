<?php
require_once("include/selectedFunc.php");
setcookie('Errors',"");
function Registr(){
    if($_POST['password'] != $_POST['submitPassword']){
        setcookie('Errors',"Error: passwords didn't match.");
        header("Location:/",true,307);
        exit;
    }else if(strlen($_POST['password'])<5 || strlen($_POST['password'])>30){
        setcookie('Errors',"Error: the password length must be between 5 and 30");
        header("Location:/",true,307);
        exit;
    }else if(strlen($_POST['login'])<5 || strlen($_POST['login'])>30){
        setcookie('Errors',"Error: the login length must be between 5 and 30");
        header("Location:/",true,307);
        exit;
    }

    $pdo = dataBase();
    $query = "SELECT count(login) as count FROM users where login like '{$_POST['login']}'";
    $count = $pdo->query($query)->fetch();
    if($count['count'] == 0){
        $query = "INSERT INTO users(login,password) VALUES(?,?)";
        $statement = $pdo->prepare($query);
        $statement->execute([$_POST['login'],$_POST['password']]);
        setcookie('Errors',"");
        header("Location:/",true,307);
        exit;
    }else{
        setcookie('Errors',"Eror: This user is already registered");
        header("Location:/",true,307);
        exit;
    }
}
function Login(){
    $pdo = dataBase();
    $query = "SELECT id FROM users where login like '{$_POST['login']}' and password like '{$_POST['password']}'";
    $id = $pdo->query($query)->fetch();
    if(is_array($id) == 2) {
    setcookie('idUser',$id['id']);
    setcookie("visibility",array());
    header("Location:/mainPage.php",true,307);
    exit;
    }else{
        setcookie('Errors',"Error:Invalid username or password");
        header("Location:/",true,307);
        exit;
    }
}
function uploadFiles(){
    if(!is_dir("images")){
        mkdir("images",0777,true);
    }
    if(!empty($_FILES['docs'])){
        $pdo = dataBase();
        $tags = preg_replace('/[^ a-zа-яё\d]/ui','',$_POST['tags']);
        if($tags != ""){
            $tags = str_replace(' ',',#',$tags);
            $tags = "#".$tags;
        }
        $query = "INSERT INTO images(id_user,file_path,tags,comment,views,date) VALUES(?,?,?,?,?,?)";
        $statment = $pdo->prepare($query);
        $docs = $_FILES['docs'];
        foreach ($docs['tmp_name'] as $index => $tmpPath){
            if(!array_key_exists($index,$docs['name'])){
                continue;
            }
            move_uploaded_file($tmpPath,__DIR__.DIRECTORY_SEPARATOR."images".DIRECTORY_SEPARATOR.$docs['name'][$index]);
            $statment->execute([$_COOKIE['idUser'],DIRECTORY_SEPARATOR."images".DIRECTORY_SEPARATOR.$docs['name'][$index],$tags,"",0,date("Y-n-t")]);
        }
    }
    header("Location:/",true,307);
    exit;
}
function deletePhoto(){
    $pdo = dataBase();
    $query = "delete from images WHERE id = ?";
    $pdo->prepare($query)->execute([$_POST['idPhoto']]);
    header("Location:/",true,307);
    exit;
}
function updateTags(){
    $pdo = dataBase();
    $tags = preg_replace('/[^ a-zа-яё\d]/ui','',$_POST['newTags']);
    $tags = "#".str_replace(' ',',#',$tags);
    $query = "UPDATE images SET tags = '{$tags}' WHERE id = {$_POST['idPhoto']}";
    $pdo->prepare($query)->execute();
    header("Location:/",true,307);
    exit;
}




if(isset($_POST['btnLogin'])){
    Login();
}
else if(isset($_POST['btnRegister'])){
    Registr();
}
if(isset($_POST['signOut'])){
    setcookie('idUser',"");
    header("Location:/",true,307);
    exit;
}

if(isset($_POST['uploadPhoto'])){
    uploadFiles();
}

if(isset($_POST['deletePhoto'])){
    deletePhoto();
}

if(isset($_POST['changeTag'])){
    updateTags();
}

if(isset($_POST['exit'])){
    header("Location:/",true,307);
    exit;
}

if($_COOKIE['idUser'] == ""){
    header("Location:/",true,307);
    exit;
}
