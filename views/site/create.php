<?php 
	use yii\helpers\Html;
	use yii\web\UploadedFile;
	use yii\widgets\ActiveForm;
	
 ?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
	<?php echo $form->field($model, 'title')->textInput(array('class' => 'span8')); ?>
	<?php echo $form->field($model, 'content')->textArea(array('class' => 'span8')); ?>
	<?= $form->field($model1, 'file')->fileInput() ?>
	
	<div class="form-actions">
		<button>Отправить</button>
	</div>
<?php ActiveForm::end(); ?>
