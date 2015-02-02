<?php
/**
 * @var \yii\db\ActiveQuery $query
 * @var array               $viewParams
 */
use itsurka\simpleComment\models\Comment;
use yii\widgets\ListView;

?>

<?php echo ListView::widget([
    'layout'       => "{items}",
    'itemView'     => '_comment',
    'options'      => ['tag' => 'ul', 'class' => 'media-list'],
    'itemOptions'  => ['tag' => 'li', 'class' => 'media'],
    'viewParams'   => $viewParams,
    'dataProvider' => new \yii\data\ActiveDataProvider([
        'query' => $query
    ])
]); ?>