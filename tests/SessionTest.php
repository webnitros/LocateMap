<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 04.07.2022
 * Time: 14:02
 */

namespace Tests;

use LocateMap\Session;
use Tests\TestCase;

class SessionTest extends TestCase
{

    public function test__construct()
    {
        $Session = new Session();
        echo '<pre>';
        print_r($Session);
        die;

    }
}
