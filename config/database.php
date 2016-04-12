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
            'host'      => '10.15.2.106',
            'database'  => 'valcro_db2',
            'username'  => 'userVal',
            'password'  => 'ntmJX2zn92CQFc6P',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ),
    ),
);