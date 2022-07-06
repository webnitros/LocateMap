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
        $this->lat = '44.850233593234655';
        $this->lon = '37.35588614858598';
/*
 * <pre>Array
(
    [place_id] => 184013933
    [licence] => Data © OpenStreetMap contributors, ODbL 1.0. https://osm.org/copyright
    [osm_type] => way
    [osm_id] => 351169660
    [lat] => 44.85043665
    [lon] => 37.3561656
    [display_name] => 12, улица Лермонтова, Супсех, городской округ Анапа, Краснодарский край, Южный федеральный округ, 353411, Россия
    [address] => Array
        (
            [house_number] => 12
            [road] => улица Лермонтова
            [village] => Супсех
            [county] => городской округ Анапа
            [state] => Краснодарский край
            [ISO3166-2-lvl4] => RU-KDA
            [region] => Южный федеральный округ
            [postcode] => 353411
            [country] => Россия
            [country_code] => ru
        )

    [boundingbox] => Array
        (
            [0] => 44.8503765
            [1] => 44.8504606
            [2] => 37.3560897
            [3] => 37.3562415
        )

)
*/
        $Provider = new Nominatim();
        $Provider->request($this->lat, $this->lon);

        echo '<pre>';
        print_r($Provider->getAddress());
        die;

    }
}
