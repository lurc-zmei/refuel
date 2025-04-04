<?php

function dump($data, $flag = "pr") {
    global $APP;
    if (!$APP['APP']['DEBUG']) return;
	echo "<pre style=\"margin: 10px 0; background: #eee; padding: 10px;\">";
	switch ($flag) {
		case 'vd': var_dump($data); break;
		default: print_r($data); break;
	}
	echo "</pre>";
}
