<?php

function dump($data, $flag = "pr") {
	echo "<pre style=\"margin: 10px 0; background: #eee; padding: 10px;\">";
	switch ($flag) {
		case 'vd': var_dump($data); break;
		default: print_r($data); break;
	}
	echo "</pre>";
}


# Исходные данные

// Резервуары с топливом
$fuel = [
	'benzin' => 500,
	'solyarka' => 400,
	'diesel' => 450,
];

// Автомобили, посетившие заправку
$cars = [
	[
		'name' => 'nissan',
		'fuel_type' => 'benzin',
		'fuel_tank' => 100, // объем бензобака
		'fuel_rest' => 30, // остаток топлива
	],
	[
		'name' => 'renault',
		'fuel_type' => 'solyarka',
		'fuel_tank' => 80,
		'fuel_rest' => 20,
	],
	[
		'name' => 'honda',
		'fuel_type' => 'diesel',
		'fuel_tank' => 110,
		'fuel_rest' => 50,
	],
];

# Заправка

foreach ($cars as $car) {
	if ($car['fuel_rest'] <= 40) {
		
		// объем топлива в резервуаре до заправки
		$fuel_count_before = $fuel[$car['fuel_type']];

		// необходимое количество топлива для заправки полного бака
		$refuel = $car['fuel_tank'] - $car['fuel_rest']; 

		// Забираем нужное количество топлива из резервуара для заправки автомобиля
		$fuel[$car['fuel_type']] = $fuel[$car['fuel_type']] - $refuel;
		
		// Отчет
		echo "Тип топлива: ".$car['fuel_type'].". Количество изнач: ".$fuel_count_before.". Было дозаправлено: ".$refuel.". Осталось в резервуаре: ".$fuel[$car['fuel_type']]."<br>";
	}
}

dump($fuel);