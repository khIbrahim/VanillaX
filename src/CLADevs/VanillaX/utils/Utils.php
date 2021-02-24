<?php

namespace CLADevs\VanillaX\utils;

use CLADevs\VanillaX\VanillaX;

class Utils{

    public static function getVanillaXPath(): string{
        if(VanillaX::getInstance()->isPhar()){
            $path = self::removeLastDirectory(VanillaX::getInstance()->getDescription()->getMain());
            $path = VanillaX::getInstance()->getFile() . "src" . DIRECTORY_SEPARATOR . $path;
            return $path;
        }else{
            return (self::removeLastDirectory( __DIR__));
        }
    }

    public static function callDirectory(string $directory, callable $callable): void{
        $dirname = self::getVanillaXPath();
        $path = $dirname . DIRECTORY_SEPARATOR . $directory;
        $phar = VanillaX::getInstance()->isPhar();

        foreach(array_diff(scandir($path), [".", ".."]) as $file){
            if(is_dir($path . DIRECTORY_SEPARATOR . $file)){
                self::callDirectory($directory . DIRECTORY_SEPARATOR . $file, $callable);
            }else{
                $i = explode(".", $file);
                $extension = $i[count($i) - 1];

                if($extension === "php"){
                    $name = $i[0];
                    $namespace = "";
                    $i = explode(DIRECTORY_SEPARATOR, str_replace(getcwd() . DIRECTORY_SEPARATOR, "", $dirname));
                    for($v = 0; $v <= ($phar ? 1 : 2); $v++){
                        unset($i[$v]);
                    }
                    foreach($i as $key => $string){
                        $namespace .= $string . DIRECTORY_SEPARATOR;
                    }
                    $namespace .= $directory . DIRECTORY_SEPARATOR . $name;
                    $namespace = str_replace("/", "\\", $namespace);
                    $callable($namespace);
                }
            }
        }
    }

    private static function removeLastDirectory(string $str, int $loop = 1): string{
        for($i = 0; $i < $loop; $i++){
            $exp = explode(DIRECTORY_SEPARATOR, $str);
            unset($exp[array_key_last($exp)]);
            $str = implode(DIRECTORY_SEPARATOR, $exp);
        }
        return $str;
    }
}