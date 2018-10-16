<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

use app\models\LoginForm;

class AuthController extends Controller
{
    
    public function behaviors()
    {
        return [
            /** 
             * Checks oauth2 credentions and try to perform OAuth2 authorization on logged user.
             * AuthorizeFilter uses session to store incoming oauth2 request, so 
             * you can do additional steps, such as third party oauth authorization (Facebook, Google ...)  
             */
            // 'oauth2Auth' => [
            //     'class' => \conquer\oauth2\AuthorizeFilter::className(),
            //     'only' => ['index'],
            // ],
        ];
    }
    
    public function actions()
    {
        return [
            /**
             * Returns an access token.
             */
            'token' => [
                'class' => \conquer\oauth2\TokenAction::classname(),
            ],
            /**
             * OPTIONAL
             * Third party oauth providers also can be used.
             */
            // 'back' => [
            //     'class' => \yii\authclient\AuthAction::className(),
            //     'successCallback' => [$this, 'successCallback'],
            // ],
        ];
    }

    /**
     * Display login form, signup or something else.
     * AuthClients such as Google also may be used
     */
    public function actionIndex()
    {
        // echo 1;die;
        $model = new LoginForm();
        if ($model->load(\Yii::$app->request->post()) && $model->login()) {
            if ($this->isOauthRequest) {
                $this->finishAuthorization();
            } else {
                return $this->goBack();
            }
        } else {
            return $this->render('index', [
                'model' => $model,
            ]);
        }
    }

    /**
     * OPTIONAL
     * Third party oauth callback sample
     * @param OAuth2 $client
     */
    public function successCallback($client)
    {
        switch ($client::className()) {
            case GoogleOAuth::className():
                // Do login with automatic signup                
                break;
            default:
                break;
        }
        /**
         * If user is logged on, redirects to oauth client with success,
         * or redirects error with Access Denied
         */
        if ($this->isOauthRequest) {
            $this->finishAuthorization();
        }
    }

}
