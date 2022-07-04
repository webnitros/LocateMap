<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 29.06.2022
 * Time: 16:04
 */

namespace LocateMap;

use LocateMap\Address;

class Session
{
    protected $data = [];

    public function __construct()
    {
        $Address = new Address();
        $this->data = $Address->toArray();
        if (!empty($_SESSION['locate_map'])) {
            $this->data = $_SESSION['locate_map'];
        }
    }

    public function fromArray(array $data)
    {
        $this->data = $data;
    }

    public function toArray()
    {
        return $this->data;
    }

    public function get($key)
    {
        if (array_key_exists($key, $this->data)) {
            return $this->data[$key];
        }
        return null;
    }


    public function save()
    {
        $_SESSION['locate_map'] = $this->data;
    }

    public function setCenter(array $coords): bool
    {
        $coords = array_map('trim', $coords);
        $coords = array_filter($coords);
        if (count($coords) != 2) {
            return false;
        }
        $_SESSION['locate_map_center_coords'] = $coords;
        return true;
    }

    public function getCenter()
    {
        if (!empty($_SESSION['locate_map_center_coords'])) {
            return $_SESSION['locate_map_center_coords'];
        }
        return null;
    }

    public function reset()
    {
        $_SESSION['locate_map'] = [];
    }
}
