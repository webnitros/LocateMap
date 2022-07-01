<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 28.06.2022
 * Time: 16:27
 */

namespace LocateMap\Abstcracts;


use LocateMap\Address;

abstract class AbstractProvider
{
    /* @var Address $_address */
    protected $_address;


    public function newAddress()
    {
        $this->_address = new Address();
        return $this->_address;
    }

    protected function _request(float $lat, float $lon): void
    {
    }

    public function request(float $lat, float $lon)
    {
        $this->newAddress();
        $this->_request($lat, $lon);
        return $this->getAddress();
    }

    /**
     * @return Address
     */
    public function getAddress()
    {
        return $this->_address;
    }

}
