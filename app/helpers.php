<?php
if ( ! function_exists('config_path'))
{
    /**
     * Get the configuration path.
     *
     * @param  string $path
     * @return string
     */
    function config_path($path = '')
    {
        return app()->basePath() . '/config' . ($path ? '/' . $path : $path);
    }
}

if ( ! function_exists('vl_db_out_put_date'))
{
    /**
     * Get the configuration path.
     *
     * @param  string $path
     * @return string
     */
    function vl_db_out_put_date($databd)
    {
        return  date_format(date_create($databd),'d/m/Y');
    }
}