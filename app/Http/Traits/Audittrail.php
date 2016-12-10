<?php

/**
 * Created by PhpStorm.
 * User: jacsiel
 * Date: 10/12/16
 * Time: 02:32 PM
 */
namespace App\Http\Traits;
use Session;
trait Audittrail
{
    public static function hello(){
        dd("hello from trait");
    }
    public static function bootAudittrail(){

        static::created(function ($model) {

        });

        static::updated(function ($model) {

        });

        static::deleted(function ($model) {

        });
    }
}