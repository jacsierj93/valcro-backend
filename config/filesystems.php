<?php

/**
 * arbol de directorios de archivos del sistema de valcro
 */
return ['disks' => [
    'pay' => [
        'driver' => 'local',
        'root' => storage_path() . '/app/pagos',
    ],
    'prov' => [
        'driver' => 'local',
        'root' => storage_path() . '/app/proveedores',
    ],
    'orders' => [
        'driver' => 'local',
        'root' => storage_path() . '/app/pedidos',
    ],
    'shipments' => [
        'driver' => 'local',
        'root' => storage_path() . '/app/embarques',
    ],
    'mail_fail' => [
        'driver' => 'local',
        'root' => storage_path() . '/app/mail/fails',
    ],
    'mail_backut' => [
        'driver' => 'local',
        'root' => storage_path() . '/app/mail/backut',
    ]
],

];