<?php

return array(

    'default' => 'valcrosis',

    'connections' => array(

        # Our primary database connection
        'valcrosis' => array(
            'driver'    => 'mysql',
            'host'      => 'localhost',
            'database'  => 'valcro_db',
            'username'  => 'userVal',
            'password'  => 'ntmJX2zn92CQFc6P',
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
            'database'  => 'valcro_datos',
            'username'  => 'userVal',
            'password'  => 'ntmJX2zn92CQFc6P',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ),
    ),
);