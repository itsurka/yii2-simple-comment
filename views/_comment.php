<?php
/**
 * @var SimpleComment             $this
 * @var Comment                   $model
 * @var \yii\db\ActiveRecord|null $author
 * @var string|null               $authorNameAttribute
 * @var string|null               $authorAvatarAttribute
 * @var string|null               $authorAvatarFunction
 * @var string|null               $authorAvatarWidth
 * @var string|null               $authorAvatarHeight
 */
use itsurka\simpleComment\models\Comment;
use itsurka\simpleComment\SimpleComment;
use yii\helpers\Html;

$avatarUrl = null;
$avatarOptions = [];

if ($author) {
    if ($authorAvatarAttribute) {
        $avatarUrl = $author->$authorAvatarAttribute;
    } elseif ($authorAvatarFunction) {
        $avatarUrl = $author->$authorAvatarFunction();
    }
    if ($avatarUrl) {
        if ($authorAvatarWidth) {
            $avatarOptions['width'] = $authorAvatarWidth;
            $avatarOptions['height'] = $authorAvatarHeight;
        }
    }
}
?>

<a class="pull-left" href="#">
    <? if ($author): ?>

        <? if ($avatarUrl): ?>
            <?= Html::img($avatarUrl, $avatarOptions) ?>
            <? /* else: */ ?><!--
            <img
                src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI2NCIgaGVpZ2h0PSI2NCI+PHJlY3Qgd2lkdGg9IjY0IiBoZWlnaHQ9IjY0IiBmaWxsPSIjZWVlIi8+PHRleHQgdGV4dC1hbmNob3I9Im1pZGRsZSIgeD0iMzIiIHk9IjMyIiBzdHlsZT0iZmlsbDojYWFhO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1zaXplOjEycHg7Zm9udC1mYW1pbHk6QXJpYWwsSGVsdmV0aWNhLHNhbnMtc2VyaWY7ZG9taW5hbnQtYmFzZWxpbmU6Y2VudHJhbCI+NjR4NjQ8L3RleHQ+PC9zdmc+"
                style="width: 64px; height: 64px;" class="media-object" data-src="holder.js/64x64" alt="64x64">-->
        <? endif ?>

        <? if ($authorAvatarAttribute): ?>
            <h4 class="media-heading"><?php echo $author->$authorNameAttribute; ?></h4>
        <? endif ?>

    <? endif ?>
</a>

<div class="media-body">

    <?php if ($author && $authorNameAttribute): ?>
        <h4 class="media-heading"><?php echo $author->$authorNameAttribute; ?></h4>
    <?php endif; ?>

    <?php echo Html::encode($model->text); ?>

    <?php if ($model->getHasAttachments()): ?>
        <br><br><b>Файлы:</b><br>
        <ul>
            <?php foreach ($model->attachments as $eachAttachment): ?>
                <li>
                    <?php echo Html::a($eachAttachment->fileName, $eachAttachment->fileUrl); ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>