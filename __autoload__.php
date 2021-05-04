<?php

$Order = [
    'Interface',
    'Core',
    'Model',
    'Service',
    'Wallet'
];

foreach ($Order as $folder) {
    foreach (scandir($folder) as $item) {
        if ($item != 'index.php' and $item != '__autoload__.php' and strstr($item, '.php')) {
            include $folder . DIRECTORY_SEPARATOR . $item;
        }
    }
}

