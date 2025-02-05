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
	1 => [
		'id' => 1,
		'name' => "benzin",
		'rest' => 500, // остаток топлива в резервуаре
		'price' => 7, // цена за единицу топлива
	],
	2 => [
		'id' => 2,
		'name' => "solyarka",
		'rest' => 400,
		'price' => 5.30,
	],
	3 => [
		'id' => 3,
		'name' => "diesel",
		'rest' => 450,
		'price' => 4,
	],
];

// Автомобили, посетившие заправку
$cars = [
	23 => [
		'id' => 23,
		'name' => 'nissan',
		'wallet' => 527, // количество денег на заправку
		'fuel' => [
			'type' => 1, // "внешний ключ" для массива с резервуарами
			'tank' => 100, // объем бензобака
			'rest' => 30, // остаток топлива
		],
	],
	24 => [
		'id' => 24,
		'name' => 'renault',
		'wallet' => 200,
		'fuel' => [
			'type' => 2,
			'tank' => 80,
			'rest' => 20,
		],
	],
	25 => [
		'id' => 25,
		'name' => 'honda',
		'wallet' => 158,
		'fuel' => [
			'type' => 3,
			'tank' => 110,
			'rest' => 50,
		],
	],
];


# Заправка
foreach ($cars as $id => $car) {

	// если у машины остаток топлива меньше 40, тогда ее заправляем
	if ($car['fuel']['rest'] <= 40) {

		// объем топлива в резервуаре до заправки
		$fuel_count_before = $fuel[$car['fuel']['type']]['rest'];


		// необходимое количество топлива для заправки полного бака
		$refuel = $car['fuel']['tank'] - $car['fuel']['rest'];


		// сколько литров можем себе позволить
		$refuel_possible = floor($car['wallet'] / $fuel[$car['fuel']['type']]['price']);
		

		// если количество топлива мы можем себе позволить больше, чем нужно заправить
		$refuel_result = $refuel_possible >= $refuel ? $refuel : $refuel_possible ;
		
		// покупка топлива
		$refuel_price = $refuel_result * $fuel[$car['fuel']['type']]['price'];
		$cars[$id]['wallet'] = $car['wallet'] - $refuel_price;

		// Забираем нужное количество топлива из резервуара для заправки автомобиля
		$fuel[$car['fuel']['type']]['rest'] -= $refuel_result;

		// Отчет

		/*
		echo "
		Тип топлива: ".$fuel[$car['fuel']['type']]['name']."
		. Количество изнач: ".$fuel_count_before."
		. Было дозаправлено: ".$fuel_count_before - $fuel[$car['fuel']['type']]['rest']."
		. Осталось в резервуаре: ".$fuel[$car['fuel']['type']]['rest']."
		. Осталось денег:: ". $cars[$id]['wallet'] ."
		<br>";
		*/

		$reports[] = [
			'car_id' => $id, // автомобиль
			'refuel_type' => $car['fuel']['type'], //тип топлива
			'refuel' => $refuel_result, // заправлено топлива, литров
			'refuel_price' => $refuel_price, // стоимость заправленного топлива
		];
	}
}

$report_label = [
	'car_id' => 'Автомобиль',
	'refuel_type' => 'Тип топлива',
	'refuel' => 'Заправлено топлива, литров',
	'refuel_price' => 'Стоимость заправленного топлива',
];

// dump(array_key_last($reports[0])); // последний ключ
// dump($reports[0][array_key_last($reports[0])]); // последнее значение

foreach($reports as $report) {
	foreach($report as $label => $value) {

		switch ($label) {
			case 'car_id':
				$value = $cars[$value]['name'];
			break;

			case 'refuel_type':
				$value = $fuel[$value]['name'];
			break;
		}

		echo "{$report_label[$label]}: {$value} <br>";
		//dump(array_key_last($report));

		if (array_key_last($report) == $label) {
			echo "<br>";
		}
	}
}
