<?php

namespace app\models;
use yii\web\IdentityInterface;
use yii\db\ActiveRecord;

class Auth extends ActiveRecord implements IdentityInterface
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%auth}}';
    }

    /**
    * @inheritdoc
    */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['source','source_id'], 'string', 'max' => 250],
        ];
    }

}
