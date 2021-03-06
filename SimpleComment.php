<?php

namespace itsurka\simpleComment;

use app\models\CommentAttachment;
use itsurka\simpleComment\models\Comment;
use itsurka\simpleComment\models\CommentForm;
use yii\base\Exception;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

\Yii::setAlias('@simplecomment', __DIR__);

require_once(\Yii::getAlias('@simplecomment') . '/models/Comment.php');
require_once(\Yii::getAlias('@simplecomment') . '/models/CommentForm.php');
require_once(\Yii::getAlias('@simplecomment') . '/models/CommentAttachment.php');

class SimpleComment extends \yii\base\Widget
{
    /**
     * AR model for which will be displayed the comments widget.
     *
     * @var ActiveRecord
     */
    public $model;

    /**
     * AR model - comments author.
     *
     * @var ActiveRecord
     */
    public $author;

    /**
     * AR models name attribute.
     *
     * @var string
     */
    public $authorNameAttribute;

    /**
     * Avatar URL. Use this or $authorAvatarFunction param.
     *
     * @var string
     */
    public $authorAvatarAttribute;

    /**
     * To get avatar URL. Use this or $authorAvatarAttribute param.
     *
     * @var string
     */
    public $authorAvatarFunction;

    /**
     * Avatar pixels width.
     *
     * @var int
     */
    public $authorAvatarWidth = 10;

    /**
     * Avatar pixels height.
     *
     * @var int
     */
    public $authorAvatarHeight;

    /**
     * todo
     *
     * @var string
     */
    public $template = "{form}\n{comments}";

    public function init()
    {
        $this->validateInputParams();
    }

    public function run()
    {
        $commentForm = new CommentForm();

        $commentForm = $this->handlePostComment($commentForm);

        echo $this->_renderForm($commentForm);
        echo $this->_renderComments();
    }

    private function _renderForm($commentForm)
    {
        return $this->renderFile(\Yii::getAlias('@simplecomment') . '/views/form.php', [
            'model'       => $this->model,
            'commentForm' => $commentForm,
        ]);
    }

    private function _renderComments()
    {
        return $this->renderFile(\Yii::getAlias('@simplecomment') . '/views/comments.php', [
            'query'      => Comment::find()->where('relModelClass = :relModelClass AND relModelId = :relModelId', [
                'relModelClass' => get_class($this->model),
                'relModelId'    => $this->model->id,
            ]),
            'viewParams' => [
                'author'                => $this->author,
                'authorNameAttribute'   => $this->authorNameAttribute,
                'authorAvatarAttribute' => $this->authorAvatarAttribute,
                'authorAvatarFunction'  => $this->authorAvatarFunction,
                'authorAvatarWidth'     => $this->authorAvatarWidth !== null ? $this->authorAvatarWidth : null,
                'authorAvatarHeight'    => $this->authorAvatarHeight !== null ? $this->authorAvatarHeight : null,
            ]
        ]);
    }

    /**
     * Проверка входящих параметров
     *
     * @throws \yii\base\Exception
     */
    private function validateInputParams()
    {
        if (is_null($this->model)) {
            throw new Exception('Параметр model не задан');
        }

        if (!$this->model instanceof ActiveRecord) {
            throw new Exception('Параметр model должен быть объектом класса ActiveRecord');
        }

        if (!is_null($this->author)) {

            if (!$this->author instanceof ActiveRecord) {
                throw new Exception('Параметр author должен быть объектом класса ActiveRecord');
            }

            if (!is_null($this->authorNameAttribute) && !$this->author->hasAttribute($this->authorNameAttribute)) {
                throw new Exception('Параметр author не содержит свойство ' . $this->authorNameAttribute);
            }

            if (!is_null($this->authorAvatarAttribute) && !$this->author->hasAttribute($this->authorAvatarAttribute)) {
                throw new Exception('Параметр author не содержит свойство ' . $this->authorAvatarAttribute);
            }

        }
    }

    private function handlePostComment(CommentForm $commentForm)
    {
        $request = \Yii::$app->request;

        if ($request->getIsPost() && $request->post('cs-comment-form-submit') !== null) {
            $commentForm->attributes = $request->post('CommentForm');

            if ($commentForm->validate()) {
                $comment = new Comment();
                $comment->relModelClass = get_class($this->model);
                $comment->relModelId = $this->model->id;
                $comment->text = $commentForm->text;
                $comment->insert();
                $comment->refresh();

                // обработка файла
                if ($uploadedFile = UploadedFile::getInstance($commentForm, 'attachment')) {
                    $fileName = md5(uniqid() . $comment->id . rand(1, 1000)) . '.' . $uploadedFile->extension;
                    $folder = '/uploads/sc/' . date('Y') . '/' . date('m') . '/' . date('d');

                    if (!is_dir(\Yii::getAlias('@webroot') . $folder)) {
                        if (!@mkdir(\Yii::getAlias('@webroot') . $folder, 0777, true)) {
                            throw new Exception('Не удалось создать директорию');
                        }
                    }
                    if (!$uploadedFile->saveAs(\Yii::getAlias('@webroot') . $folder . '/' . $fileName)) {
                        throw new Exception('Не удалось скопировать файл');
                    }

                    $commentAttachment = new CommentAttachment();
                    $commentAttachment->commentId = $comment->id;
                    $commentAttachment->fileName = $fileName;
                    $commentAttachment->filePath = \Yii::getAlias('@webroot') . $folder . '/' . $fileName;
                    $commentAttachment->fileUrl = $folder . '/' . $fileName;
                    $commentAttachment->fileExtension = $uploadedFile->extension;
                    $commentAttachment->insert();
                }
                \Yii::$app->controller->refresh();
            }
        }
        return $commentForm;
    }
}
