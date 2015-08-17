<?php

namespace app\models;
use yii\base\Model;
use \yii\db\Expression;
use yii\web\UploadedFile;

class Userreg extends \yii\db\ActiveRecord
{  
     /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Comments the static model class
     */
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

	
}
?>
