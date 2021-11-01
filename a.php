<?php

$map = [0 => 'php', 1 => 'go', 2 => 'javascript'];
echo json_encode($map); // ["php","go","javascript"]

$tmp = new \stdClass();
foreach ($map as $key => $value) {
    $tmp->{"{$key}"} = $value;
}
echo json_encode($tmp); // {"0":"php","1":"go","2":"javascript"}
