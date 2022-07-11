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
        $this->lat = '53.75888899999671';
        $this->lon = '87.13816399999999';
        $Provider = new Nominatim();
        $Provider->request($this->lat, $this->lon);

        echo '<pre>';
        print_r($Provider->getAddress());
        die;

    }
}
