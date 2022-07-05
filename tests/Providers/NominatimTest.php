<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 05.07.2022
 * Time: 14:54
 */

namespace Tests\Providers;

use LocateMap\Providers\Nominatim;
use Tests\TestCase;

class NominatimTest extends TestCase
{

    public function test_request()
    {
        $this->lat = '44.850394203175';
        $this->lon = '37.356163102096';

        $Provider = new Nominatim();
        $Provider->request($this->lat, $this->lon);

        echo '<pre>';
        print_r($Provider->getAddress());
        die;

    }
}
