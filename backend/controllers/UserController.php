<?php

namespace backend\controllers;

use common\models\UserForm;
use backend\services\EmailServices\RegisterService;
use yii\web\Controller;
use yii\web\Response;
use Yii;

class UserController extends Controller
{

    /**
     * @inheritdoc
     * off a csrf token for this method in UserController
     */
    public function beforeAction($action)
    {            
        if ($action->id === 'actionRegister') {
            $this->enableCsrfValidation = false;
        }
        return true;
    }

    public function actionRegister()
    {
        Yii::$app->controller->enableCsrfValidation = false;
        $userForm = new UserForm();
        $postData = Yii::$app->request->post();
        if ($userForm->load($postData, '')) {
            if ($userForm->validate()) {
                
                $registerService = new RegisterService();
                $response = $registerService->actionRegister($userForm->getUserAttributes());
                return  $response;
            
            } else {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ['status' => 'error', 'message' => $userForm->errors];
            }
        } else {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['status' => 'error', 'message' => 'Получены неверные данные.'];
        }
    }
}