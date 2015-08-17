<?php

namespace app\models;
use yii\base\Model;
use \yii\db\Expression;
use \yii\db\Command;
use yii\web\UploadedFile;
use yii\db\ActiveQuery;
use yii\db\Query;

class Like extends \yii\db\ActiveRecord
{  public $image;
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
        return 'like';
    }
 
    /**
     * @return array primary key of the table
     **/     
    public static function primaryKey()
    {
        return array('id_user1','id_user2');
    }  
	
	public static function updateMark($id_user1, $id_user2, $mark)
    {
	
	$command = \Yii::$app->db->createCommand(
			'UPDATE yii2.`like` SET mark='.$mark.' WHERE id_user1 = '.$id_user1.' and id_user2 = '.$id_user2);
	$command->execute();
	
	}
	
	
	public static function sum($id)
    {
		/*$sum = Yii::$app()->db->createCommand()
						->select('sum(mark) as a')
						->from('like')
						->where('id_user1='.$id)
						->queryRow();*/
		$command = \Yii::$app->db->createCommand("SELECT sum(mark) as a FROM yii2.`like` where id_user2=".$id);
		$sum = $command->queryOne();
		
        return $sum['a'];
    }
 
    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id_user1' => 'Id_user1',
            'id_user2' => 'Id_user2',
            'mark'     => 'Mark',
        );
    }
	

}
?>
