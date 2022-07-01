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
            $response = $client->setAcceptLanguage('ru')->reverse($lat, $lon);
            if ($response->isOK()) {

                #   $add = $response->getAddress();
                $data = $response->toArray();

                $desc = $data['display_name'];
                $name = $street = $house = $block = $postal_code = '';
                if (!empty($data['place_id'])) {
                    $details = $client->details($data['place_id']);
                    $row = $details->toArray();

                    if (!empty($row['calculated_postcode'])) {
                        $postal_code = $row['calculated_postcode'];
                    }

                    if (!empty($row['localname'])) {
                        $name = $row['localname'];
                    }

                    if (!empty($row['addresstags']['street'])) {
                        $street = $row['addresstags']['street'];
                    }

                    if (!empty($row['addresstags']['housenumber'])) {
                        if (strripos($row['addresstags']['housenumber'], '/') !== false) {
                            list($house, $block) = explode('/', $row['addresstags']['housenumber']);
                        } else {
                            $house = $row['addresstags']['housenumber'];
                        }
                    }

                    if (!empty($street) && !empty($house)) {
                        $name = $street . ', д ' . $house;
                    }
                }

                $Address = $this->getAddress();
                $Address
                    ->setLat($lat)
                    ->setLon($lon)
                    ->setPostalCode($postal_code)
                    ->setName($name)
                    ->setStreet($street)
                    ->setHouse($house)
                    ->setBlock($block)
                    ->setDescription($desc);
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
