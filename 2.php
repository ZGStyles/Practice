<?php
function countW($type,$message){

    if($type === 'file'){
        $path = 'File';
    }else{
        $path = 'Result2';
    }

    $sym = [",",".","-",PHP_EOL];
    $array2=[];
    $message = str_replace($sym,"",$message);
    $message = mb_strtolower($message);
    $array = explode(" ",$message);
    foreach ($array as $word){
        if(!array_key_exists($word,$array2)){
            $array2[$word] = 1;
        }else{
            $array2[$word] += 1;
        }
    }

    $list = array(array("Word","Count"));
    foreach ($array as $key => $Value){
        array_push($list,array($key,$Value));
    }
    array_push($list,array("total words",count($array)));
    $path = "Result/{$path}/".date("U").".csv";
    $fp = fopen($path,'w');
    foreach ($list as $lines){
        fputcsv($fp,$lines);
    }
    fclose($fp);
}

if(!is_dir("Result")){
    mkdir("Result",0777,true);
}

if(!is_dir("Result/Result2")){
    mkdir("Result/Result2",0777,true);
}

if(!is_dir("Result/Result2")){
    mkdir("Result/Result2",0777,true);
}


if(!empty($_FILES['docs']['name'])){
    $valueText = file_get_contents($_FILES['docs']['tmp_name']);
    countW('file',$valueText);
}

if(!empty($_POST['Message'])) {
    $text = $_POST['Message'];
    countW('text', $text);
}
