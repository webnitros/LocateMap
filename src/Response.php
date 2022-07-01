<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 28.06.2022
 * Time: 17:37
 */

namespace LocateMap;


class Response
{

    public static function success(Address $address, $json = true)
    {
        $data = [
            'success' => true,
            'data' => $address->toArray(),
        ];
        if (!$json) {
            return $data;
        }
        return self::json($data);
    }

    public static function error($msg, $json = true)
    {
        $data = [
            'success' => false,
            'message' => $msg,
        ];
        if (!$json) {
            return $data;
        }
        return self::json($data);
    }

    public static function header()
    {
        header('Content-Type: application/json; charset=utf-8');
    }

    public static function json(array $res)
    {
        return json_encode($res);
    }
}
