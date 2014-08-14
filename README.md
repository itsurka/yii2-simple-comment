Simple Comment
==============

***UNDER DEVELOPING! DO NOT USE IN PRODUCTION!***

A simple comment extension.

Installation
------------

1) Download extension

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist itsurka/yii2-simple-comment "*"
```

or add

```
"itsurka/yii2-simple-comment": "*"
```

to the require section of your `composer.json` file.

2) Apply migrations from yii2-simple-comment/migrations folder.

Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
<?php echo SimpleComment::widget([
    'model' => $model,
    'author' => $user,
    'authorNameAttribute' => 'username'
]); ?>```