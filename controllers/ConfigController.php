<?php

namespace app\controllers;

use app\models\Config;
use Yii;

class ConfigController extends BaseController
{
    public function actionIndex()
    {
        $model = Config::find()->all();

        return $this->responseSuccess($model);
    }


    public function actionCreate() {

        $body       =  Yii::$app->getRequest()->getBodyParams();

        foreach($body as $key => $value) {

            $model = Config::findOne(['key' => $key]);


            if(empty($model)) {
                $model = new Config();
            }

            
            $model->key = strval($key);
            $model->value = strval($value);
            
            $model->save();
        }

        return $this->responseSuccess($body);
    }

}
