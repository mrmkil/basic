<?php 
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\data\Pagination;
use yii\db\ActiveRecord;
 ?>
 <?php if(!Yii::$app->user->isGuest){ 
	echo Html::a('Create New Post', array('site/create'), array('class' => 'btn btn-primary pull-right')); 
 }?>
<div class="clearfix"></div>
<hr />
<?php if(Yii::$app->session->hasFlash('PostDeletedError')): ?>
<div class="alert alert-error">
    There was an error deleting your post!
</div>
<?php endif; ?>
 
<?php if(Yii::$app->session->hasFlash('PostDeleted')): ?>
<div class="alert alert-success">
    Your post has successfully been deleted!
</div>
<?php endif; ?>

<?php foreach ($post as $post1): ?>
<div class="bs-example" data-example-id="simple-pre">

  <table  class="table table-bordered">
  <tr>
    <td style="width:200px; height:200px;"">
		<?php if ($post1->image){ ?>
		<img src="<?php echo $post1->image;?>" width="189" height="255" alt="lorem">
	<?php } ?>
	</td>
	<td><div class="pull-right btn-group">
	<?php if(!Yii::$app->user->isGuest){ ?>
    <?php echo Html::a('Delete', array('site/delete', 'id' => $post1->id), array('class' => 'btn btn-danger')); }?>
</div>
 
<h1><?php echo $post1->title; ?></h1>
<p><?php echo $post1->content; ?></p>
<hr />

<time><?php echo $post1->updated; ?></time></td>
  </tr>
  
</table>

</div>
<?php endforeach; ?>
<div >
<?= LinkPager::widget(['pagination' => $pagenator,'lastPageLabel'=>'LAST','firstPageLabel'=>'FIRST',
     'prevPageLabel' => 'Prev',
     'nextPageLabel' => 'Next',
]) ?>

</div>