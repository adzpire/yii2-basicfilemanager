# yii2-basicfilemanager

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
composer require miragesoft/yii2-basicfilemanager "dev-master"
```

or add

```
"miragesoft/yii2-basicfilemanager": "dev-master"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by :

Config
```php
    'modules' => [
        ...
        'basicfilemanager' => [
            'class' => 'mirage\basicfilemanager\Module',
            // Upload routes
            'routes' => [
                // Base absolute path to web directory
                'baseUrl' => '',
                // Base web directory url
                'basePath' => '@webroot',
                // Path for uploaded files in web directory
                'uploadPath' => 'uploads',
            ],
        ],
        ...
    ],
```


Standalone
```html
<input type="text" name="avatar" id="profile-avatar">
```
```php
<?php
echo \mirage\basicfilemanager\widgets\ModalBrowser::widget([
    'browserUrl' => '/basicfilemanager',
    'fieldID' => 'profile-avatar',
    'returnType' => 'basename', //url(default), absolute, behind, basename
        //url คือ ที่อยู่ของไฟล์ (/uploads/images/abc.jpg),
        //absolute คือ ที่อยู่ของไฟล์แบบเต็ม (http://www.example.com/uploads/images/abc.jpg),
        //behind คือ ที่ตั้งไฟล์โดยเริ่มนับจากหลังคอนฟิคไดเรคทอรี่อัพโหลด (images/abc.jpg),
        //basename คือ ใช้ชื่อไฟล์อ่างเดียว (abc.jpg)
    'options' => [
        'subDir' => 'user/10/avatar', //บังคับเข้า dir ตามค่า (default='')
        'changeDir' => false, //การอนุญาตให้เปลี่ยน dir ได้ (default=true)
        'createDir' => false, //การอนุญาติให้สร้าง dir ได้ (default=true)
        'upload' => false, //การอนุญาติให้ upload ได้ (default=true)
    ],
    'modalOptions'=>[ //ค่า config ของ bootstrap modal
        'header' => '<strong>Covers</strong>',
        'id' => 'modalAvatar',
        'toggleButton' => [
            'label' => '<i class="glyphicon glyphicon-picture"></i>', 
            'id' => 'avatar-btn-browse',
            'class'=>'btn btn-default btn-change-avatar'
        ],
    ],
]);
?>
```

If you want effect after selected file please register javascript to view 
```php
<?php
$this->registerJS("
function after_selected_function(){
    alert('After selected first.');
}
", $this::POS_HEAD);

$this->registerJS("
function modalAvatar_after_selected_function(){
    alert('After selected second.');
}
", $this::POS_HEAD);
?>
```