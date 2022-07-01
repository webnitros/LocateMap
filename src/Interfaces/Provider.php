<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 28.06.2022
 * Time: 16:28
 */

namespace LocateMap\Interfaces;

use LocateMap\ExceptionLocationMap;

interface Provider
{
    /**
     * @throws ExceptionLocationMap
     */
    public function _request(float $lat, float $lon): void;
}
