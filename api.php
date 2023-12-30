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
    function CleansDB($NamesDirs="NOME_DA_PASTA_DB"){
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
            /**
             * ! 1-) SEPARADOR EXPLODE [ WWW. | HTTPS | HTTP ]
             */
            $ValueDB = $FilesDB[$i][0];
            $https = str_contains("$ValueDB", 'https://');
            $http = str_contains("$ValueDB", 'http://');
            $www = str_contains("$ValueDB", 'www.');
            $RemoveTagsWeb = ["http://","https://","www."];
            $link =  str_replace($RemoveTagsWeb,"",$FilesDB[$i][0]);
            $explode = explode(":",$link);
            if(count($explode)==3){
                $RemoveTagsFiles = [".","-"];
                $file = $explode[0];
                $file =  str_replace($RemoveTagsFiles,"_",$file);
                $user = $explode[1];
                $pass = $explode[2];
                if(str_contains($user,"@")){
                    $dir = "./key/$NamesDirs";
                    if(!is_dir($dir)){
                        mkdir($dir);
                        $dir = "./key/$NamesDirs/";
                        if(!is_dir($dir)){
                            mkdir($dir);
                        }
                    }
                    $file = "./key/$NamesDirs/".$file.".txt";
                    $file_save = fopen($file, "a+");
                    fwrite($file_save, "{$user}|{$pass}\n");
                    fclose($file_save);
                    echo"\e[0;32;42m[ • ] \e[0m\e[0;42m SUCCESS SAVE FILE [ E-MAIL | [ : ] ] : [ $file ] <=> [ $user|$pass ]"."\e[0m\e[0;32;42m[ • ] \e[0m\n";
                }else{
                    $RemoveTagsNumber = [".","-"];
                    $user =  str_replace($RemoveTagsNumber,"",$user);
                    $dir = "./key/$NamesDirs";
                    if(!is_dir($dir)){
                        mkdir($dir);
                        $dir = "./key/$NamesDirs/";
                        if(!is_dir($dir)){
                            mkdir($dir);
                        }
                    }
                    $file = "./key/$NamesDirs/".$file.".txt";
                    $file_save = fopen($file, "a+");
                    fwrite($file_save, "{$user}|{$pass}\n");
                    fclose($file_save);
                    echo"\e[0;32;42m[ • ] \e[0m\e[0;42m SUCCESS SAVE FILE [ NUMBER | [ : ] ] : [ $file ] <=> [ $user|$pass ]"."\e[0m\e[0;32;42m[ • ] \e[0m\n";
                }
            }else{
                $RemoveTagsWeb = ["http://","https://","www."];
                $link =  str_replace($RemoveTagsWeb,"",$FilesDB[$i][0]);
                $explode = explode(";",$link);
                if(count($explode)==3){
                    $RemoveTagsFiles = [".","-"];
                    $file = $explode[0];
                    $file =  str_replace($RemoveTagsFiles,"_",$file);
                    $user = $explode[1];
                    $pass = $explode[2];
                    if(str_contains($user,"@")){
                        echo "[ E-MAIL ] FILES: " . $file ." USER: " . $user . " PASS: " . $pass."\n";
                        $dir = "./key/$NamesDirs";
                        if(!is_dir($dir)){
                            mkdir($dir);
                            $dir = "./key/$NamesDirs/";
                            if(!is_dir($dir)){
                                mkdir($dir);
                            }
                        }
                        $file = "./key/$NamesDirs/".$file.".txt";
                        $file_save = fopen($file, "a+");
                        fwrite($file_save, "{$user}|{$pass}\n");
                        fclose($file_save);
                        echo"\e[0;32;42m[ • ] \e[0m\e[0;42m SUCCESS SAVE FILE [ E-MAIL | [ ; ] ] : [ $file ] <=> [ $user|$pass ]"."\e[0m\e[0;32;42m[ • ] \e[0m\n";
                    }else{
                        $RemoveTagsNumber = [".","-"];
                        $user =  str_replace($RemoveTagsNumber,"",$user);
                        $dir = "./key/$NamesDirs";
                        if(!is_dir($dir)){
                            mkdir($dir);
                            $dir = "./key/$NamesDirs/";
                            if(!is_dir($dir)){
                                mkdir($dir);
                            }
                        }
                        $file = "./key/$NamesDirs/".$file.".txt";
                        $file_save = fopen($file, "a+");
                        fwrite($file_save, "{$user}|{$pass}\n");
                        fclose($file_save);
                        echo"\e[0;32;42m[ • ] \e[0m\e[0;42m SUCCESS SAVE FILE [ NUMBER | [ ; ] ] : [ $file ] <=> [ $user|$pass ]"."\e[0m\e[0;32;42m[ • ] \e[0m\n";
                    }
                }
            }
        }
    }
    CleansDB();
?>