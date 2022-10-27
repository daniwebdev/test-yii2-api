<?php

namespace app\controllers;

use app\common\filters\TokenValidationFilter;
use app\models\Config;
use Yii;
use yii\helpers\ArrayHelper;

class ConfigController extends BaseController
{

    function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [

            'verbs' => [

                'class' => TokenValidationFilter::class,

            ],

        ]);
    }

    
    public function actionIndex()
    {
        $model = Config::find()->all();

        return $this->responseSuccess($model);
    }


    public function actionCreate() {
        try {

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
        } catch (\Throwable $th) {

            return $this->responseError($th->getMessage(), [], $th->getCode() ? $th->getCode():500);
        }
    }

    public function actionUpdate($id) {
        try {
            $body       =  Yii::$app->getRequest()->getBodyParams();

            $model      = Config::find($id)->one();
    
            foreach($body as $key => $value) {
                $model->$key = $value;
            }
    
            $model->update();
    
    
            return $this->responseSuccess($model);
        } catch (\Throwable $th) {

            return $this->responseError($th->getMessage(), [], $th->getCode() ? $th->getCode():500);
        }
    }

    public function actionDelete($id) {
        try {

            $user       = Config::find()->where(['id' => $id]);

            if(!$user->count()) {
    
                return $this->responseError("Config tidak ditemukan", [], 404);
            }
    
            $user->one()->delete();
    
            return $this->responseSuccess("Config telah dihapus");
    
        } catch (\Throwable $th) {

            return $this->responseError($th->getMessage(), [], $th->getCode() ? $th->getCode():500);
        }
    }

}
