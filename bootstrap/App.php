<?php


class App {
    protected array $env;
    public function __construct() {
        global $APP;
        $APP = $this->env();
        /*
        if($APP['APP']['DEBUG']) {
            error_reporting(($APP['APP']['DEBUG'] ? E_ALL ^ E_NOTICE : 0));
            ini_set('display_errors', $APP['APP']['DEBUG']);
        }
        */

        require_once $_SERVER['DOCUMENT_ROOT'].'/app/helpers.php';

        require_once $_SERVER['DOCUMENT_ROOT'].'/database/Database.php';
        $APP['DB'] = new Database($APP['DB']);

        // поиск и подключение файлов с классами
        foreach (scandir($_SERVER['DOCUMENT_ROOT'].'/app/Models') as $fileClass) {
            /*
            отсеивание '.', '..'
            версия 2 с регулярным выражением
            if (preg_match("/.+\.php/i", $fileClass, $matches)) dump($matches);
            версия 1
            */
            if (!in_array($fileClass, ['.', '..'])) {
                // параллельно подключаем файлы с классами
                spl_autoload_register(function ($fileClass) {
                    require_once $_SERVER['DOCUMENT_ROOT'].'/app/Models/'.$fileClass.'.php';
                });
                // отбрасываем расширение
                $fileClass = str_replace('.php', '', $fileClass);
                // является ли класс абстрактным
                if (!(new ReflectionClass($fileClass))->isAbstract()){
                    // создаем объект класса
                    $APP[$fileClass] = new $fileClass;
                }
            }
        }



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
