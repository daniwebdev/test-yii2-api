<?php

namespace app\controllers;

use app\common\components\Helpers;
use app\models\User;
use Exception;
use PHPUnit\TextUI\Help;
use Yii;
use yii\web\HttpException;

class AuthController extends BaseController
{

    
    public function actionLogin() {

        try {
            $body       =  Yii::$app->getRequest()->getBodyParams();
            $model      = new User();

            $user       = $model->find()->where(['email' => $body['email']])->one();

            if($user == null) {
                throw new HttpException(401, "Email tidak terdaftar");
            }

            $checkPassword = Yii::$app->getSecurity()->validatePassword($body['password'], $user->password);

            if(!$checkPassword) {
                throw new HttpException(401, "Password yang anda masukan salah.");
            }


            $token = Helpers::createToken([
                'id' => $user['id'],
                'email' => $user['email']
            ]);

            // sleep(2);

            // $decode = Helpers::decodeToken($token);

            // dd($decode);



            return $this->responseSuccess([
                "token" => $token,
                "user"  => $user,
            ]);

        } catch (HttpException $th) {
            //throw $th;

            return $this->responseError($th->getMessage(), [], $th->statusCode);
        }

    }


    public function actionRegister() {
        
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
       }

    }

}
