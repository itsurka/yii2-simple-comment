<?php

namespace itsurka\simpleComment\models;

use app\models\CommentAttachment;
use Yii;

/**
 * This is the model class for table "sc_comment".
 *
 * @property integer             $id
 * @property string              $relModelClass
 * @property integer             $relModelId
 * @property string              $text
 * @property string              $createdDate
 *
 * @property CommentAttachment[] $attachments
 */
class Comment extends \yii\db\ActiveRecord
{
    private $attachmentsCount;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sc_comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['relModelId'], 'integer'],
            [['text'], 'string'],
            [['relModelClass'], 'string', 'max' => 25]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'            => Yii::t('app', 'ID'),
            'relModelClass' => Yii::t('app', 'Rel Model Class'),
            'relModelId'    => Yii::t('app', 'Rel Model ID'),
            'text'          => Yii::t('app', 'Text'),
            'createdDate'   => Yii::t('app', 'Created Date'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttachments()
    {
        return $this->hasMany(CommentAttachment::className(), ['commentId' => 'id']);
    }

    public function getHasAttachments()
    {
        if (is_null($this->attachmentsCount)) {
            $this->attachmentsCount = count($this->attachments);
        }
        return $this->attachmentsCount > 0;
    }
}
