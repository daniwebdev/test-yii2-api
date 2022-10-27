<?php
namespace app\common\components;

use app\models\Config;
use Yii;
use yii\web\HttpException;

class Helpers {

    static $key = '123abc';

    static function createToken($data, $expired=60*60*24) {
        
        $data = base64_encode(gzcompress(time()+$expired.'|||'.serialize($data), 9));

        $hash = base64_encode(Yii::$app->getSecurity()->generatePasswordHash(self::$key.$data)).'.'.$data;

        // $decode = gzuncompress(base64_decode($data));
        // $split = explode('|', $decode);

        // $expiredAt = $split[0];
        // $data = unserialize($split[1]);

        return $hash;
    }

    static function decodeToken($token) {
        try {
            $split = explode('.', $token);
            $dataencoded  = $split[1];
            $hash  = base64_decode($split[0]);
    
            if(!Yii::$app->getSecurity()->validatePassword(self::$key.$dataencoded, $hash)) {
                throw new HttpException(401, "Token tidak valid");
            }
    
    
            $decodeSplit = explode('|||', gzuncompress(base64_decode($dataencoded)));
    
            $expiredAt   = $decodeSplit[0];
            $payload     = unserialize($decodeSplit[1]);
    
            if($expiredAt < time()) {
                throw new HttpException(401, "Token kadaluarsa");
            }
    
            return $payload;
        } catch (\Throwable $th) {
            throw new HttpException(401, "Token tidak valid");
        }
    }


    static function config($key) {

        $data = Config::find()->where(['key' => $key])->one() ?? (object) ['value' => null];

        return $data->value;
    }
}