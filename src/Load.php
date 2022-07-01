<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 28.06.2022
 * Time: 17:43
 */

namespace LocateMap;


use LocateMap\Interfaces\Provider;

class Load
{

    /**
     * @param $name
     * @throws ExceptionLocationMap
     */
    public static function provider($name)
    {
        $name = "\LocateMap\Providers\{$name}";
        $name = str_ireplace('{', '', $name);
        $name = str_ireplace('}', '', $name);

        if (!class_exists($name)) {
            throw new ExceptionLocationMap('Провайдер не найден ' . $name);
        }
        /* @var Provider $handler */
        $handler = new $name();
        return $handler;
    }
}
