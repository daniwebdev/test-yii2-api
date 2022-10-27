<?php
namespace app\api\filters;

use app\api\components\Helpers;
use app\api\models\User;
use Yii;
use yii\base\ActionFilter;
use yii\web\HttpException;

class TokenValidationFilter extends ActionFilter {



    public function beforeAction($action)
    {
        $app = Yii::$app;
        $request = $app->request;
        $headers = $request->headers;
        $authorization = str_replace("Bearer ", "", $headers['authorization']);
        $decode = Helpers::decodeToken($authorization);

        /* bisa di cache untuk meringankan beban                    */
        $dataUser = User::find($decode['id'])->one();    //
        // $app->params['user_data'] = $dataUser;

        if($dataUser == null) {
            throw new HttpException(401, "Token tidak valid");
        }


        return parent::beforeAction($action);
    }

    public function afterAction($action, $result)
    {
        return parent::afterAction($action, $result);
    }
}