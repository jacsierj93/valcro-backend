<?php

return array(

    'default' => 'valcro2',

    'connections' => array(

        # Our primary database connection
        'valcrosis' => array(
            'driver'    => 'mysql',
            'host'      => 'userver',
            'database'  => 'valcro_db',
            'username'  => 'root',
            'password'  => 'delimce',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ),

        # base de datoa de profit
        'profit' => array(
            'driver'    => 'sqlsrv',
            'host'      => 'valcro-main\psql',
            'database'  => 'VAL_INV',
            'username'  => 'profit',
            'password'  => 'profit',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ),

        # base de datos viejo sistema valcro
        'valcro2' => array(
            'driver'    => 'mysql',
            'host'      => 'localhost',
            'database'  => 'valcro_db2',
            'username'  => 'root',
            'password'  => '12345',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ),
    ),
);
