<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 28.06.2022
 * Time: 16:55
 */

namespace LocateMap;


use phpDocumentor\Reflection\Types\Boolean;

class Address
{

    protected $_description = '';
    protected $_name = '';
    protected $_house = '';
    protected $_street = '';
    protected $_block = '';
    protected $_lat = '';
    protected $_lon = '';
    protected $_postal_code = '';
    protected $_city = '';
    protected $_region = '';
    protected $_properties = [];

    public function __construct(array $args = [])
    {
        if (!empty($args)) {
            $this->fromArray($args);
        }
    }

    public function fromArray(array $data)
    {
        foreach ($data as $field => $arg) {
            $k = str_ireplace('_', ' ', $field);
            $method = 'set' . $this->mb_ucwords(trim($k));
            $method = str_ireplace(' ', '', $method);
            if (method_exists($this, $method)) {
                $this->$method($arg);
            }
        }
    }

    public function mb_ucfirst($str, $charset = '')
    {
        if ($charset == '') $charset = mb_internal_encoding();
        $letter = mb_strtoupper(mb_substr($str, 0, 1, $charset), $charset);
        $suffix = mb_substr($str, 1, mb_strlen($str, $charset) - 1, $charset);
        return $letter . $suffix;
    }

    function mb_ucwords($str)
    {
        return mb_convert_case($str, MB_CASE_TITLE, "UTF-8");
    }

    /**
     * @return bool
     */
    public function isKnown()
    {
        return !empty($this->name());
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this->_name;
    }

    public function house()
    {
        return $this->_house;
    }


    public function street()
    {
        return $this->_street;
    }

    public function description()
    {

        return $this->_description;
    }


    public function setName(string $name)
    {
        $this->_name = $name;
        return $this;
    }


    public function setLat(string $lat)
    {
        $this->_lat = $lat;
        return $this;
    }

    public function formatFloat($val)
    {
        if (strripos($val, ',') !== false) {
            $val = str_ireplace(',', '.', $val);
        }
        $val = (float)$val;
        return $val;
    }

    public function lat()
    {
        return $this->formatFloat($this->_lat);
    }

    public function setLon(string $lon)
    {
        $this->_lon = $lon;
        return $this;
    }

    public function lon()
    {
        return $this->formatFloat($this->_lon);
    }


    public function setDescription(string $description)
    {
        $this->_description = $description;
        return $this;
    }

    public function setStreet(string $street)
    {
        $this->_street = $street;
        return $this;
    }


    public function setHouse(string $house)
    {
        $this->_house = $house;
        return $this;
    }

    public function toArray()
    {
        $class_methods = get_class_vars(__CLASS__);
        $data = [
            'known' => $this->isKnown()
        ];
        foreach ($class_methods as $k => $class_method) {
            $field = ltrim($k, '_');
            $data[$field] = $this->{$field}();
        }
        return $data;
    }

    public function setBlock(string $block)
    {
        $this->_block = $block;
        return $this;
    }

    public function block()
    {
        return $this->_block;
    }

    public function setPostalCode($postal_code)
    {
        $this->_postal_code = $postal_code;
        return $this;
    }

    public function postal_code()
    {
        return $this->_postal_code;
    }

    public function region()
    {
        return $this->_region;
    }

    public function setRegion(string $region)
    {
        $this->_region = $region;
        return $this;
    }

    public function city()
    {
        return $this->_city;
    }

    public function setCity(string $city)
    {
        $this->_city = $city;
        return $this;
    }

    public function properties()
    {
        return $this->_properties;
    }

    public function setProperties(array $properties)
    {
        $this->_properties = $properties;
        return $this;
    }

    public function get(string $key, $default = null)
    {

        if (method_exists($this, $key)) {
            $value = $this->{$key}();
            if (!empty($value)) {
                return $value;
            }
        }
        return $default;
    }


}
