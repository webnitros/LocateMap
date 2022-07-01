<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 28.06.2022
 * Time: 16:29
 */

namespace LocateMap\Providers;


use Exception;
use LocateMap\Abstcracts\AbstractProvider;
use LocateMap\ExceptionLocationMap;
use LocateMap\Interfaces\Provider;

class DaData extends AbstractProvider implements Provider
{

    /**
     * @param float $lat
     * @param float $lon
     * @throws ExceptionLocationMap
     */
    public function _request(float $lat, float $lon): void
    {

        if (!defined('LOCATE_MAP_TOKEN_DADATA')) {
            throw new ExceptionLocationMap('Constant LOCATE_MAP_TOKEN_DADATA');
        }

        try {
            $dadata = new \Dadata\DadataClient(LOCATE_MAP_TOKEN_DADATA, null);
            $result = $dadata->geolocate("address", $lat, $lon);
        } catch (Exception $e) {
            throw new ExceptionLocationMap($e->getMessage());
        }


        if (!empty($result[0])) {
            $row = $result[0];
            $data = $result[0]['data'];


            $street = !empty($data['street_with_type']) ? $data['street_with_type'] : '';


            $house = !empty($data['house']) ? $data['house'] : '';
            $block = !empty($data['block']) ? $data['block'] : '';
            $postal_code = !empty($data['postal_code']) ? $data['postal_code'] : '';
            $region = !empty($data['region_with_type']) ? $data['region_with_type'] : '';


            $city = !empty($data['city_district_with_type']) ? $data['city_district_with_type'] : '';
            if (!empty($data['settlement_with_type'])) {
                $city = $data['settlement_with_type'];
            }

            if (empty($block)) {
                if (strripos($house, '/') !== false) {
                    list($house, $block) = explode('/', $house);
                }
            }


            $name = $street;
            if (!empty($house)) {
                $name .= ', д ' . $house;
            }

            if (!empty($block)) {
                $name .= '/' . $block;
            }

            $description = $row['value'];
            $description = str_ireplace(', ' . $name, '', $description);


            $Address = $this->getAddress();
            $Address
                ->setLat($lat)
                ->setLon($lon)
                ->setPostalCode($postal_code)
                ->setStreet($street)
                ->setHouse($house)
                ->setBlock($block)
                ->setName($name)
                ->setDescription($description)
                ->setCity($city)
                ->setRegion($region);

        }

    }


}
