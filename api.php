<?php
    error_reporting(0);
    function ReadDB(){
        $arrayReadDB = array();
        $dir = new DirectoryIterator("db");
        foreach ($dir as $fileinfo) {
            if(strpos($fileinfo,".txt")){
                $arrayReadDB[] = $fileinfo->getFilename();
            }
        }
        return $arrayReadDB;
    }
    function CleansDB($NamesDirs){
        $ReadDB = ReadDB();
        $FilesDB = array();
        foreach ($ReadDB as $files) {
            $arquivo = fopen ('./db/'.$files, 'r');
            while(!feof($arquivo)){
                $FilesDB[] = explode(" ",fgets($arquivo));
            }
            fclose($arquivo);
        }
        for ($i=0; $i < count($FilesDB); $i++){
            $explode = explode(";",$FilesDB[$i][0]);
            if(count($explode)==3){
                $user = $explode[0];
                $password = $explode[1];
                if(strpos($user,"@")){
                    /**
                     * ! Cleans DB for Email and Password.
                     */
                    $RemoveTagsWeb = ["http://","https://","www.",":","-"];
                    $user =  str_replace($RemoveTagsWeb,"",$user);
                    $explodeUser = explode("/",$user);
                    if(count($explodeUser)==3){
                        $FileName = $explodeUser[0];
                        $RemoveTagsWeb = [".","/","-","*"];
                        $FileName =  str_replace($RemoveTagsWeb,"",$FileName);
                        $user = $explodeUser[2];
                        $dir = "./key/$NamesDirs";
                        if(!is_dir($dir)){
                            mkdir($dir);
                            $dir = "./key/$NamesDirs/";
                            if(!is_dir($dir)){
                                mkdir($dir);
                            }
                        }
                        $file = "./key/$NamesDirs/".$FileName.".txt";
                        $file_save = fopen($file, "a+");
                        fwrite($file_save, "{$user}|{$password}\n");
                        fclose($file_save);
                        echo"\e[0;32;42m[ • ] \e[0m\e[0;42m SUCCESS SAVE FILE [ E-MAIL ] : [ $FileName ] <=> [ $user|$password ]"."\e[0m\e[0;32;42m[ • ] \e[0m\n";
                    }
                }
            }else{
                $explode = explode(":",$FilesDB[$i][0]);
                print_r($explode);
            }
        }
    }
    CleansDB("Test");
?>