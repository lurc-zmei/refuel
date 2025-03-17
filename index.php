<?php

function dump($data, $flag = "pr") {
	echo "<pre style=\"margin: 10px 0; background: #eee; padding: 10px;\">";
	switch ($flag) {
		case 'vd': var_dump($data); break;
		default: print_r($data); break;
	}
	echo "</pre>";
}

$sqlConnect = mysqli_connect('localhost', 'root', '', 'refuel');

# Исходные данные

// Автомобиль
$sqlQuery =  mysqli_query($sqlConnect, "SELECT * FROM `car`");
while($row = mysqli_fetch_assoc($sqlQuery)){
	// Группировка данных о топливе под новым ключем 
	$row['fuel'] = [
		'type' => $row['fuel_id'],
		'tank' => $row['fuel_tank'],
		'rest' => $row['fuel_rest'],
	];
	unset($row['fuel_id'], $row['fuel_tank'], $row['fuel_rest']);

	// 
	$cars[$row['id']] = $row; // Готовые данные, с которыми мы работаем дальше в коде
}

// Топливо
$sqlQuery =  mysqli_query($sqlConnect, "SELECT * FROM `fuel`");
while($row = mysqli_fetch_assoc($sqlQuery)){
	$fuel[$row['id']] = $row; // Готовые данные, с которыми мы работаем дальше в коде
}

// Метки для отчета
$report_label = [
	'car_id' => 'Автомобиль',
	'refuel_type' => 'Тип топлива',
	'refuel' => 'Заправлено топлива, литров',
	'refuel_price' => 'Стоимость заправленного топлива',
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
		$reports[] = [
			'car_id' => $id, // автомобиль
			'refuel_type' => $car['fuel']['type'], //тип топлива
			'refuel' => $refuel_result, // заправлено топлива, литров
			'refuel_price' => $refuel_price, // стоимость заправленного топлива
		];
	}
}

# Вывод отчета
foreach($reports as $report) {
	foreach($report as $label => $value) {

		switch ($label) {
			case 'car_id': $value = $cars[$value]['name']; break;
			case 'refuel_type': $value = $fuel[$value]['name']; break;
		}

		echo "{$report_label[$label]}: {$value} <br>";
		//dump(array_key_last($report));

		if (array_key_last($report) == $label) {
			echo "<br>";
		}
	}
}