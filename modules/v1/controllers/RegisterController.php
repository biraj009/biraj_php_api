<?php

namespace app\modules\v1\controllers;

use Yii;
use yii\rest\Controller;

class RegisterController extends Controller
{
    const INTEGER_VALUE = 1;

    public function actionRegisterUser(){

        $user_details = \Yii::$app->getRequest()->getBodyParams();
        if($user_details){
            $age = $this->validateRequestParam(RegisterController::INTEGER_VALUE, $user_details['age']);
            $sex = $this->validateRequestParam(RegisterController::INTEGER_VALUE, $user_details['sex']);
            if(!$age){
                \Yii::$app->response->statusCode = 400;
                return ['status' => 400,'error' => 'Age is invalid'];
            }
            if($sex){
                \Yii::$app->response->statusCode = 400;
                return ['status' => 400,'error' => 'Sex is invalid'];
            }
            $users = new \app\modules\v1\models\User();
            $response = $users->addUserDetails($user_details);
            if($response->validate() && $response->save()){
                \Yii::$app->getResponse()->setStatusCode(201);
                return ['status' => 201, 'message' => 'user successfully created', 'user' => $users];
            } else {
                \Yii::$app->getResponse()->setStatusCode(400);
                return ['status' => 400, 'error' => $users->getErrors() ];
            }
        }  
    }
    public function validateRequestParam($type, $value){

        if($type == RegisterController::INTEGER_VALUE){
            return filter_var($value, FILTER_VALIDATE_INT);
        }
    }
    public function actionUpdateUserProfile(){

        $params = $_GET;
        if(isset($params['access_token']) && $params['access_token']){
            $update_user_details = \Yii::$app->getRequest()->getBodyParams();
            if($update_user_details && isset($update_user_details['user_id']) && $update_user_details['user_id'] ){
                  $user = \app\modules\v1\models\User::find()->where(array('id'=> $update_user_details['user_id']))->one();
                  if($user){
                    $result = $user->validateAuthKey($params['access_token']); 
                  }
                  if($result){
                    $response = $user->updateUserDetails($update_user_details); 
                    if($response->validate() && $response->save() ){
                        \Yii::$app->response->statusCode = 400;
                        return ['status' => 400,'message' => 'user updated successfully'];
                    } else {
                        \Yii::$app->getResponse()->setStatusCode(400);
                        return ['status' => 400, 'error' => $user->getErrors() ];
                    }  
                  } else {
                    \Yii::$app->response->statusCode = 400;
                    return ['status' => 400,'error' => 'access token is invalid'];
                  }
            } else {
                \Yii::$app->response->statusCode = 404;
                return ['status' => 404,'message' => 'user id cannot be blank'];
            }
        } else {
            \Yii::$app->response->statusCode = 401;
            return ['status' => 401,'message' => 'Your request was made with invalid credentials.'];
        }    
    }
}
