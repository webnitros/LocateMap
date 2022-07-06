<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 06.07.2022
 * Time: 16:26
 */

namespace Tests\Providers;

use LocateMap\Providers\Yandex;
use Tests\TestCase;

class YandexTest extends TestCase
{

    public function test_request()
    {
        $Provider = new Yandex();
        $Provider->request($this->lat, $this->lon);

        echo '<pre>';
        print_r($Provider->getAddress());
        die;
    }
}
