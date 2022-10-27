<?php
namespace app\api\controllers;

use Yii;

class BaseController extends \yii\rest\Controller {



    protected function responseSuccess($details, $message=null) {

        return [
            'error' => 0,
            'message' => $message ? $message:"Success",
            'details' => $details,
        ];
    }

    protected function responseError($message, $details, $code=null) {

        if(!is_null($code) && $code <= 500 && $code >= 400) {
            Yii::$app->response->statusCode = $code;
        }

        return [
            'error' => 1,
            'message' => $message ? $message:'Error',
            'details' => $details
        ];
    }



    // public function behaviors()
    // {
    //     return [
    //         'corsFilter' => [
    //             'class' => \app\common\filters\Cors::class,
    //             'cors' => [
    //                 'Access-Control-Request-Method' => [
    //                     'GET',
    //                     'POST',
    //                     'PUT',
    //                     'PATCH',
    //                     'DELETE',
    //                     'HEAD',
    //                     'OPTIONS',
    //                 ],
    //                 'Access-Control-Request-Headers' => [
    //                     '*',
    //                 ],
    //                 'Access-Control-Allow-Credentials' => null,
    //                 'Access-Control-Max-Age' => 86400,
    //                 'Access-Control-Expose-Headers' => [],
    //             ],
    
    //         ],
    //     ];
    // }
}
