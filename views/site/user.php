<?php 
	use yii\helpers\Html;
	use yii\web\UploadedFile;
	use yii\widgets\ActiveForm;
?>


 

  <table  class="table table-bordered">
  <tr>
    <td style="width:200px; height:200px;"">
	<?php if ($user->image){ ?>
		<img src="<?php echo $user->image;?>" width="189" height="255" alt="lorem">
	<?php } else{?>
		<img src="uploads/no_images.jpg" width="189" height="255" alt="lorem">
	<?php }?>
		<hr/>
			<?php if(!Yii::$app->user->isGuest){ ?>
			 <?php echo Html::a('Update Photo', array('site/upload', 'id' => $user->id), array('class' => 'btn btn-primary')); }?>
   
	</td>
	<td>
 <div class="pull-right btn-group">
<button class="btn btn-mini" id="mark" class="mark">mark = <?= $sum ?></button>
<button class="btn btn-mini" href="#" type="button" onclick='setLike(0,<?= $user->id;?>);'>0</button>
<button class="btn btn-mini" href="#" type="button" onclick='setLike(1,<?= $user->id;?>);'>1</button>
<button class="btn btn-mini" href="#" type="button" onclick='setLike(2,<?= $user->id;?>);'>2</button>
<button class="btn btn-mini" href="#" type="button" onclick='setLike(3,<?= $user->id;?>);'>3</button>
<button class="btn btn-mini" href="#" type="button" onclick='setLike(4,<?= $user->id;?>);'>4</button>
<button class="btn btn-mini" href="#" type="button" onclick='setLike(5,<?= $user->id;?>);'>5</button>

    <?php echo Html::a('Update', array('site/userupdate', 'id' => $user->id), array('class' => 'btn btn-primary')); ?>

</div>
<h1><?php echo $user->name." ".$user->surname;  ?></h1>
<hr /><b>
.<br/>
.<br/>
.<br/>
</b>
</td>
  </tr>
  
</table>




<hr/>
<?php     
 if(!Yii::$app->user->isGuest){ 
$form = ActiveForm::begin([
    'id' => 'ride-form',
    'enableClientValidation'=>false,
    'validateOnSubmit' => true, // this is redundant because it's true by default
]); ?>
	<?php echo $form->field($comment, 'comment')->textArea(['value' => 'comment']); ?>
	<div style="display: none;"><?php echo $form->field($comment, 'id_user')->hiddenInput(['value' => $user->id]); ?>
	<?php echo $form->field($comment, 'id_my')->hiddenInput(['value' => Yii::$app->user->identity->id]); ?>
	</div>
	<div class="form-actions">
		<?php echo Html::submitButton('Submit', null, null, array('class' => 'btn btn-primary')); ?>
	</div>
<?php ActiveForm::end(); }?>
<hr/>

<?php foreach ($data as $row): ?>
<div class="bs-example" data-example-id="simple-pre">

  <table  class="table table-bordered">
	<tr>
		<td><div class="pull-right btn-group">
			</div>
			<p><?php echo $row->content; ?></p>
		<hr />
		<time><?php echo $row->updated; ?></time></td>
	</tr>
  </table>

</div>
<?php endforeach; ?>