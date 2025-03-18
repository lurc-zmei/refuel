<?php

class App {
    protected array $env;
    public function __construct() {
        $this->env = require_once $_SERVER['DOCUMENT_ROOT'].'/env.php';
        require_once $_SERVER['DOCUMENT_ROOT'].'/app/helpers.php';
    }

}

new App();
