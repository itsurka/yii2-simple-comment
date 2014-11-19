<?php

namespace itsurka\simpleComment\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class CommentForm extends Model
{
    public $text;

    /**
     * @var UploadedFile
     */
    public $attachment;

    public function rules()
    {
        return [
            [['text'], 'required'],
            [['text'], 'string', 'max' => 255],
            [['attachment'], 'file', 'extensions' => 'jpg, jpeg, gif, png, txt, doc, docx, xml', 'skipOnEmpty' => true, 'minSize' => 10, 'maxSize' => 10 * 1024 * 1024],
        ];
    }

    public function attributeLabels()
    {
        return [
            'text' => 'Текст',
            'attachment' => 'Файл',
        ];
    }
}
