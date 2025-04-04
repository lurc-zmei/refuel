<?php
//preg_match_all("/.{3,5}\.php/", 'index.php car.php', $matches);
//print_r($matches);

require_once $_SERVER['DOCUMENT_ROOT'].'/bootstrap/App.php';

// SELECT * FROM `car`
//dump($APP['db']->query('SELECT * FROM `car`'));

$newCar = [
    'name' => 'sangyong',
    'wallet' => 300,
    'fuel_id' => 1,
    'fuel_tank' => 90,
    'fuel_rest' => 30,
];

$newFuel = [
    'name' => 'Uran-235',
    'rest' => 100,
    'price' => 40,
];


//dump($APP['car']->create($newCar), 'vd');
//dump($APP['fuel']->create($newFuel), 'vd');
//dump($APP['car']->delete(19), 'vd');
//dump($APP['car']->update(12, ['name' => 'volvo']), 'vd');
//dump($APP);
//dump($APP['Car']->read());
dump($APP['Fuel']->read());
