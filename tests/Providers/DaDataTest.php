<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 28.06.2022
 * Time: 16:34
 */

namespace Tests\Providers;

use LocateMap\Address;
use LocateMap\Providers\DaData;
use Mockery;
use Tests\TestCase;

class DaDataTest extends TestCase
{
    public function testRequest2()
    {
        $Response = new DaData();
        $Address = $Response->request($this->lat, $this->lon);
        self::assertEquals($Address->name(), 'Мой адрес не дом и не улица');
        self::assertEquals($Address->house(), 5);
        self::assertEquals($Address->street(), 'Бродячик');
        self::assertEquals($Address->description(), 'Россия Бродячик');
    }

    public function testRequest()
    {
        $Response = Mockery::mock(DaData::class);
        $Response->shouldReceive('request')->andReturn(new Address($this->fake));
        $Address = $Response->request($this->lat, $this->lon);
        self::assertEquals($Address->name(), 'Мой адрес не дом и не улица');
        self::assertEquals($Address->house(), 5);
        self::assertEquals($Address->street(), 'Бродячик');
        self::assertEquals($Address->description(), 'Россия Бродячик');
    }
}
