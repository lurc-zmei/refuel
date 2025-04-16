<?php

namespace Bootstrap;
use Database\Database;

class App {

    protected array $env;

    public function __construct() {
        global $APP;
        $APP = $this->env();
        $APP['db'] = new Database($APP['DB']);
        //

    }

    public function message($string){
        return $string;
    }





    private function env()
    {

        $envFile = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/.env');

        $envLines = explode("\r\n", $envFile);

        foreach ($envLines as $line) {

            // избавляемся от пустых строк и комментариев
            if (empty(trim($line)) || $line[0] == '#') continue;

            // разделяем на ключ и значение
            list($lineKey, $lineValue) = explode('=', $line);

            // Родительский и дочерний ключ
            list($keyParent, $keySub) = explode('_', $lineKey);

            // приведение к boolean
            $lineValue = match ($lineValue) {
                "true" => true,
                "false" => false,
                default => $lineValue,
            };

            // формируем массив
            $result[$keyParent][$keySub] = $lineValue;
        }
        return $result;
    }

}

new App();
