<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 28.06.2022
 * Time: 17:54
 */

namespace LocateMap\Providers;


use Exception;
use InvalidArgumentException;
use LocateMap\Abstcracts\AbstractProvider;
use LocateMap\ExceptionLocationMap;
use LocateMap\Interfaces\Provider;

class Nominatim extends AbstractProvider implements Provider
{
    /**
     * @param float $lat
     * @param float $lon
     * @throws ExceptionLocationMap
     */
    public function _request(float $lat, float $lon): void
    {

        $client = new \Nominatim\Client();
        try {
            $lat = str_ireplace(',', '.', (string)$lat);
            $lon = str_ireplace(',', '.', (string)$lon);
            $response = $client->setAcceptLanguage('ru')->reverse($lat, $lon, [
                'addressdetails' => true
            ]);
            if ($response->isOK()) {
                $data = $response->toArray();
                $Address = $this->getAddress();
                $kind = null;
                switch ($data['osm_type']) {
                    case 'way':
                        $kind = 'house';
                        break;
                    case 'node':
                        $kind = 'locality';
                        break;
                    case 'relation':
                        $kind = 'country';
                        break;
                    default:
                        break;
                }

                if ($kind) {
                    $Address->setKind($kind);
                }

                if (!empty($data['address'])) {
                    $add = $data['address'];

                    if (!empty($add['house_number'])) {

                        $ext = explode(' ', $add['house_number']);

                        if (count($ext) == 2) {
                            list($house, $block) = explode(' ', $ext);
                        } else {
                            $house = $add['house_number'];
                        }


                        $Address->setHouse($house);
                        if (!empty($block)) {
                            $Address->setBlock($block);
                        }
                    }

                    if (!empty($add['road'])) {
                        $Address->setStreet($add['road']);
                    }
                    if (!empty($add['residential'])) {
                        $Address->setArea($add['residential']);
                    }


                    if (!empty($add['town'])) {
                        $Address->setCity($add['town']);
                    } else if (!empty($add['village'])) {
                        $Address->setCity($add['village']);
                    }

                    if (!empty($add['state'])) {
                        $Address->setRegion($add['state']);
                    }

                    if (!empty($add['display_name'])) {
                        $Address->setDescription($add['display_name']);
                    }
                    if (!empty($add['postcode'])) {
                        $Address->setPostalCode($add['postcode']);
                    }
                }


                if (!empty($data['country_code'])) {
                    $Address->setCountryCode($data['country_code']);
                }


                $name = $Address->generateName();
                $Address
                    ->setLat($lat)
                    ->setLon($lon)
                    ->setName($name);

            } else {
                throw new ExceptionLocationMap('Address not found');
            }
        } catch (InvalidArgumentException $e) {
            throw new ExceptionLocationMap($e->getMessage());
        } catch (Exception $e) {
            throw new ExceptionLocationMap($e->getMessage());
        }
    }
}
