<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace mirage\basicfilemanager\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class BfmAsset extends AssetBundle
{
    public $sourcePath = '@mirage/basicfilemanager/client';
    public $css = [
    	'css/style.css',
    ];
    public $js = [
    	'js/bfm.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
