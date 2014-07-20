<?php
/**
 * @var CommentForm $commentForm
 */

use itsurka\simpleComment\models\CommentForm;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>

<?php $form = ActiveForm::begin([
    'method' => 'post',
//    'enableClientValidation' => false,
    'options' => [
        'enctype' => 'multipart/form-data'
    ]
]); ?>
<?php echo $form->field($commentForm, 'text')->textarea(); ?>
<?php echo $form->field($commentForm, 'attachment')->fileInput(); ?>
    <div class="form-group">
        <?php echo Html::submitButton(Yii::t('app', 'Add'), ['class' => 'btn btn-primary', 'name' => 'cs-comment-form-submit']); ?>
    </div>
<?php ActiveForm::end(); ?>