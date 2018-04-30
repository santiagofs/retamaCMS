<?php
namespace Modules\Content;

class ServiceProvider extends \Illuminate\Support\ServiceProvider {

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->loadMigrationsFrom(__DIR__.'/migrations');
    }

    public function register()
    {
        // $this->mergeConfigFrom(
        //     __DIR__.'/config.php', 'retamaBack'
        // );
    }

    public static function getPath($file = null)
    {
	    $path = __DIR__;
	    if($file) $path .= '/'.$file;
	    return $path;
    }

    public static function getFile($path)
    {
	    $full_path = static::getPath().'/'.$path;
	    return file_exists($full_path) ? $full_path : false;
    }
}