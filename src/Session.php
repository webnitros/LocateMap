<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 29.06.2022
 * Time: 16:04
 */

namespace LocateMap;

class Session
{
    protected $data = [];

    public function __construct()
    {
        $Address = $this->address();
        if (!empty($_SESSION['locate_map']) && is_array($_SESSION['locate_map'])) {
            $Address->fromArray($_SESSION['locate_map']);
        }
        $this->data = $Address->toArray();
    }

    public function address()
    {
        return new \LocateMap\Address();
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
        $Address = $this->address();
        $Address->fromArray($this->data);
        $_SESSION['locate_map'] = $Address->toArray();
    }

    public function setCenter(array $coords)
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
        $_SESSION['locate_map'] = $this->address()->toArray();
    }
}
