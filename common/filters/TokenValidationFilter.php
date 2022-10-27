<?php
namespace app\common\filters;

use app\common\components\Helpers;
use app\models\User;
use Yii;
use yii\base\ActionFilter;

class TokenValidationFilter extends ActionFilter {



    public function beforeAction($action)
    {
        $app = Yii::$app;
        $request = $app->request;
        $headers = $request->headers;
        $authorization = str_replace("Bearer ", "", $headers['authorization']);
        $decode = Helpers::decodeToken($authorization);

        /* cachable ----------------------------------------------- */
        /* bisa di cache untuk meringankan beban                    */
        $dataUser = User::find($decode['id'])->one()->toArray();    //
        /* end cachable ------------------------------------------- */

        $app->params['user_data'] = $dataUser;

        return parent::beforeAction($action);
    }

    public function afterAction($action, $result)
    {
        return parent::afterAction($action, $result);
    }
}