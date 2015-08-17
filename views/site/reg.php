<?php 
	use yii\helpers\Html;
	use yii\web\UploadedFile;
	use yii\widgets\ActiveForm;
	
 ?>

<?php     

$form = ActiveForm::begin([
    'id' => 'ride-form',
    'enableClientValidation'=>false,
    'validateOnSubmit' => true, // this is redundant because it's true by default
]); ?>
	<?php echo $form->field($model, 'login')->textInput(array('class' => 'span8')); ?>
	<?php echo $form->field($model, 'password')->passwordInput(array('class' => 'span8')); ?>
	<?php echo $form->field($model, 'name')->textInput(array('class' => 'span8')); ?>
	<?php echo $form->field($model, 'surname')->textInput(array('class' => 'span8')); ?>
	<div class="form-actions">
		<?php echo Html::submitButton('Submit', null, null, array('class' => 'btn btn-primary')); ?>
	</div>
<?php ActiveForm::end(); ?>