<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 28.06.2022
 * Time: 17:47
 */

namespace LocateMap\Providers;


use LocateMap\Abstcracts\AbstractProvider;
use LocateMap\ExceptionLocationMap;
use LocateMap\Interfaces\Provider;

class Yandex extends AbstractProvider implements Provider
{

    /**
     * @param float $lat
     * @param float $lon
     * @throws ExceptionLocationMap
     */
    public function _request(float $lat, float $lon): void
    {
        if (!defined('LOCATE_MAP_TOKEN_YANDEX')) {
            throw new ExceptionLocationMap('Constant LOCATE_MAP_TOKEN_YANDEX');
        }
        $yandexToken = LOCATE_MAP_TOKEN_YANDEX;


        $address = "{$lon},{$lat}";
        $url = "https://geocode-maps.yandex.ru/1.x/?apikey={$yandexToken}&format=json&geocode=" . urlencode($address);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $res = curl_exec($ch);
        curl_close($ch);
        $res = json_decode($res, true);

        if (!empty($res['response']['GeoObjectCollection']['featureMember'][0])) {
            $name = $res['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['name'];
            $description = $res['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['description'];


            $Address = $this->getAddress();
            $Components = $res['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['metaDataProperty']['GeocoderMetaData']['Address']['Components'];
            $postal_code = $res['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['metaDataProperty']['GeocoderMetaData']['Address']['postal_code'];


            foreach ($Components as $component) {
                $field = $component['kind'];
                switch ($field) {
                    case 'street':
                        $Address->setStreet($component['name']);
                        break;
                    case 'house':
                        $Address->setHouse($component['name']);
                        break;
                    case 'locality':
                        $Address->setCity($component['name']);
                        break;
                    case 'province':
                        $Address->setRegion($component['name']);
                        break;
                    default:
                        break;
                }
            }


            $Address
                ->setPostalCode($postal_code)
                ->setLat($lat)
                ->setLon($lon)
                ->setName($name)
                ->setDescription($description);


        } else {
            throw new ExceptionLocationMap("Адрес по координатам {$lat} {$lon} не определен ");
        }

    }
}
