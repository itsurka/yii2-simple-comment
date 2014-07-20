<?php

namespace app\models;

use itsurka\simpleComment\models\Comment;
use Yii;

/**
 * This is the model class for table "sc_comment_attachment".
 *
 * @property integer $id
 * @property integer $commentId
 * @property string $fileName
 * @property string $fileExtension
 * @property string $filePath
 * @property string $fileUrl
 * @property string $createdDate
 *
 * @property Comment $comment
 */
class CommentAttachment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sc_comment_attachment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['commentId'], 'integer'],
            [['createdDate'], 'safe'],
            [['fileName', 'fileExtension'], 'string', 'max' => 100],
            [['filePath', 'fileUrl'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'commentId' => Yii::t('app', 'Comment ID'),
            'fileName' => Yii::t('app', 'File Name'),
            'fileExtension' => Yii::t('app', 'File Extension'),
            'filePath' => Yii::t('app', 'File Path'),
            'fileUrl' => Yii::t('app', 'File Url'),
            'createdDate' => Yii::t('app', 'Created Date'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComment()
    {
        return $this->hasOne(Comment::className(), ['id' => 'commentId']);
    }
}
