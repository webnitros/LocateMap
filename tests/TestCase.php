<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 24.03.2021
 * Time: 22:49
 */

namespace Tests;

use Mockery\Adapter\Phpunit\MockeryTestCase;

abstract class TestCase extends MockeryTestCase
{
    public $lat = 44.885442206864525;
    public $lon = 37.34017921843076;
    public $fake = [
        'name' => 'Мой адрес не дом и не улица',
        'house' => 5,
        'street' => 'Бродячик',
        'description ' => 'Россия Бродячик'
    ];

    protected function setUp(): void
    {
        parent::setUp();
    }
}
