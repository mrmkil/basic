<?php

namespace app\models;
use yii\base\Model;
use \yii\db\Expression;
use yii\web\UploadedFile;
use \yii\db\ActiveRecord;
use  yii\web\IdentityInterface;


class Userreg extends \yii\db\ActiveRecord 
{
   
	
	
	
	
	
	
	
	   public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
 
    /**
     * @return string the associated database table name
     */
    public static function tableName()
    {
        return 'user';
    }
 
    /**
     * @return array primary key of the table
     **/     
    public static function primaryKey()
    {
        return array('id');
    }
 
    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'login' => 'Login',
            'password' => 'Password',
            'name' => 'Name',
            'surname' => 'Surname',
			'image' => 'Image',
        );
    }
	
	public function rules()
	{
		return array(
        array(array('login', 'password'), 'required'),
	//	array(['image'], 'file',  'extensions' => 'png,jpg', 'skipOnEmpty' => false)
		
		);
	}
	public function beforeSave($insert)
	{
		if ($this->isNewRecord)
    {
        $this->created = new Expression('NOW()');
        $command = static::getDb()->createCommand("select max(id) as id from posts")->queryAll();
        $this->id = $command[0]['id'] + 1;
    }
 
    $this->updated = new Expression('NOW()');
    return parent::beforeSave($insert);
}
	
}
