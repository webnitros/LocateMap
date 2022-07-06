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
    protected $key_session = 'locatemap';

    public function __construct($key = null)
    {
        $Address = $this->address();
        if (!empty($key)) {
            $this->key_session = $key;
        }
        $key = $this->keySession();
        if (!empty($_SESSION[$key]) && is_array($_SESSION[$key])) {
            $Address->fromArray($_SESSION[$key]);
        }
        $this->data = $Address->toArray();
    }

    public function keySession()
    {
        return $this->key_session;
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
        $_SESSION[$this->keySession()] = $Address->toArray();
    }

    public function setCenter(array $coords)
    {
        $coords = array_map('trim', $coords);
        $coords = array_filter($coords);
        if (count($coords) != 2) {
            return false;
        }
        $key = $this->keySession();
        $_SESSION[$key . '_center_coords'] = $coords;
        return true;
    }

    public function getCenter()
    {
        $key = $this->keySession();
        if (!empty($_SESSION[$key . '_center_coords'])) {
            return $_SESSION[$key . '_center_coords'];
        }
        return null;
    }

    public function reset()
    {
        $_SESSION[$this->keySession()] = $this->address()->toArray();
    }
}
