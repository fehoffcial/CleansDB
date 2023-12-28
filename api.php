<?php
    error_reporting(0);
    function ReadDB(){
        /** 
         * ! 1-) FAZER A LEITURA DOS ARQUIVOS DA PASTA.
         */
        $Files = new FilesystemIterator("./db");
        $Files_db = [];
        foreach ($Files as $fileinfo) {
            $Files_db[] = $fileinfo->getFilename();
        }
        return $Files_db;
    }
    function CleansDB($NamesDirs){
        $ReadDB = ReadDB();
        $FilesDB = array();
        foreach($ReadDB as $files){
            $arquivo = fopen ('./db/'.$files, 'r');
            while(!feof($arquivo)){
                $FilesDB[] = explode(" ",fgets($arquivo));
            }
            fclose($arquivo);
        }
        for ($i=0; $i < count($FilesDB); $i++) { 
            $explode = explode(";",$FilesDB[$i][0]);
            if(count($explode)==3){
                $dbName = $explode[0];
                $dbName = trim($dbName," ");
                $dbNameRemove = ['*',':','/',".","-","_","https","http","www"];
                $dbName =  str_replace($dbNameRemove,"_",$dbName);
                $dbInput = $explode[1];
                $dbInput = trim($dbInput," ");
                $dbOutInput = $explode[2];
                $dbOutInput = trim($dbOutInput," ");
                if(!strpos($dbInput,"@")){
                    $dbNameRemoves = ['*',':','/',".","-","_"];
                    $dbInput =  str_replace($dbNameRemove,"",$dbInput);
                }
                if($dbName!==null && strlen($dbName) > 1 && $dbInput!==null && strlen($dbInput) > 1 && $dbOutInput!==null && strlen($dbOutInput) > 1){
                    echo "Name DB: $dbName | Input DB: $dbInput | OutInput DB: $dbOutInput | \n";
                    $dir = "./key/$NamesDirs";
                    if(!is_dir($dir)){
                        mkdir($dir);
                        $dir = "./key/$NamesDirs/".date('d_m_Y')."/";
                        if(!is_dir($dir)){
                            mkdir($dir);
                        }
                    }
                    $file = "./key/$NamesDirs/".date('d_m_Y')."/".$dbName.".txt";
                    $file_save = fopen($file, "a+");
                    fwrite($file_save, $dbInput."|".$dbOutInput."\n");
                    fclose($file_save);
                }
            }
        }
    }
    CleansDB("santander_clean_db");
?>