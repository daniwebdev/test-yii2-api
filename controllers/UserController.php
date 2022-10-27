<?php

namespace app\controllers;

use app\common\filters\TokenValidationFilter;
use app\models\User;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\HttpException;

class UserController extends BaseController
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
        $user = new User();


        return $this->responseSuccess($user->find()->all());
    }


    public function actionUpdate($id) {
        try {
            $body       =  Yii::$app->getRequest()->getBodyParams();
    
            $model      = User::find($id)->one();
    
            foreach($body as $key => $value) {
                $model->$key = $value;
            }
    
            $model->update();
    
    
            return $this->responseSuccess($model);
        } catch (\Throwable $th) {
            return $this->responseError($th->getMessage(), [], $th->getCode() ? $th->getCode():500);
        }

    }

    public function actionCreate() {

        try {

            $body       =  Yii::$app->getRequest()->getBodyParams();
            $model      = new User();

            $checkEmail = $model->find()->where(['email' => $body['email']])->count();

            if($checkEmail) {

                throw new HttpException(401, "Email sudah terdaftar.");

            }

            $hashPassword = Yii::$app->getSecurity()->generatePasswordHash($body['password']);

            $model->first_name = $body['first_name'];
            $model->last_name  = $body['last_name'];
            $model->password   = $hashPassword;
            $model->email      = $body['email'];

            $model->save();

            return $this->responseSuccess([$model]);
        } catch (HttpException $th) {
            
            return $this->responseError($th->getMessage(), [], $th->statusCode);

        } catch (\Throwable $th) {
            return $this->responseError($th->getMessage(), [], $th->getCode() ? $th->getCode():500);
        }
    }

    public function actionDelete($id) {

        try {

            $user       = User::find()->where(['id' => $id]);

            if(!$user->count()) {
                return $this->responseError("User tidak ditemukan", [], 404);
            }
    
            $user->one()->delete();
    
            return $this->responseSuccess("User telah dihapus");
    
        } catch (\Throwable $th) {

            return $this->responseError($th->getMessage(), [], $th->getCode() ? $th->getCode():500);
        }

    }

}
