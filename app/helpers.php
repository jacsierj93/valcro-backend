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

        return  ($databd != null)?  date_format(date_create($databd),'d/m/Y') : $databd;
    }
}
if ( ! function_exists('emails_path'))
{
    /**
     * Get the  email templates  paths
     *
     * @param  string $path
     * @return string
     */
    function emails_path($path = '')
    {
        return  app()->basePath().'/resources/views/emails'.($path ? '/' . $path : $path);
    }
}

if ( ! function_exists('emails_templates_lang'))
{
    /**
     * Get the  email lang  paths
     *
     * @param  string $mod the module
     * @param  string $accion the accion or function
     * @return string
     */
    function emails_templates_lang($mod,$accion)
    {
        $files = scandir(emails_path($mod.'/'.$accion));
        unset($files[0],$files[1]);
        $data = [];
        foreach ($files as $aux){
            $f = str_replace('.blade.php','', $aux);
            $data[] = ['iso_lang'=>$f,'file'=>$aux];
        }
        return $data;

    }
}


if ( ! function_exists('attachments_file'))
{
    /**
     * Get the  email lang  paths
     *
     * @param  string $mod the module
     * @param  string $accion the accion or function
     * @return string
     */
    function attachments_file($keys)
    {
        $data = [];
        foreach($keys as $aux){
            $att = [];
            $file= \App\Models\Sistema\Masters\FileModel::findOrFail($aux);
            $att['archivo_id'] = $aux;
            $att['thumb']=$file->getThumbName();
            $att['tipo']=$file->tipo;
            $att['archivo'] = $file->archivo;
            $data[]= $att;
        }
        return $data;

    }
}
if ( ! function_exists('attachment_file'))
{
    /**
     * Get the  email lang  paths
     *
     * @param  string $mod the module
     * @param  string $accion the accion or function
     * @return string
     */
    function attachment_file($id)
    {
            $file= \App\Models\Sistema\Masters\FileModel::findOrFail($id);
            $att['archivo_id'] = $id;
            $att['thumb']=$file->getThumbName();
            $att['tipo']=$file->tipo;
            $att['archivo'] = $file->archivo;
            $data[]= $att;

        return $data;

    }
}
if ( ! function_exists('storage_disk_path'))
{
    /**
     * Get the  email lang  paths
     *
     * @param  string $mod the module
     * @param  string $accion the accion or function
     * @return string
     */
    function storage_disk_path($disk, $file = '')
    {
        return Storage::disk($disk)->getDriver()->getAdapter()->getPathPrefix().$file;

    }
}