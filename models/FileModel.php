<?php

namespace mirage\basicfilemanager\models;

use Yii;

class FileModel extends \yii\db\ActiveRecord
{

    public $files;

    public $routes;

    public function init()
    {
        parent::init();

        if(substr(Yii::$app->controller->module->routes['basePath'], 0, 1) === '@'){
            $basePath = Yii::getAlias(Yii::$app->controller->module->routes['basePath']);
        }else{
            $basePath = Yii::$app->controller->module->routes['basePath'];
        }

        $arr = [
            'baseUrl' => '',
            'basePath' => $basePath,
            'uploadPath' => Yii::$app->controller->module->routes['uploadPath'],
        ];
        $arr['uploadDir'] = $arr['basePath'].'/'.$arr['uploadPath'];
        $this->routes = (object)$arr;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['files'], 'file', 'skipOnEmpty' => false, 'maxFiles' => false],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'files' => 'Files',
        ];
    }

    public function itemList($options=[])
    {
        $session = Yii::$app->session;
        $moduleId = Yii::$app->controller->module->id;
        if(isset($options['sub-directory'])){
            $session->set($moduleId, ['path'=>'/'.ltrim($options['sub-directory'], '/')]);
        }
        //$session->remove($moduleId);
        $dir = $this->routes->uploadDir.$session->get($moduleId)['path'];
        if(is_dir($dir)){
            //echo $dir;
            $files=\yii\helpers\FileHelper::findFiles($dir,['recursive'=>false]);
            $files_r = [];
            if(!isset($options['show-directory']) || intval($options['show-directory']) === 1){
                foreach (glob($dir.'/*', GLOB_ONLYDIR) as $filename) {
                    $files_r[] = $filename;
                }
            }

            foreach ($files as $value) {
                $files_r[] = str_replace('\\', '/', $value);
            }
        }else{
            $message = 'Path '.$session->get($moduleId)['path']. ' not found!.';
            $session->remove($moduleId);
            throw new \yii\web\HttpException(500, $message);
        }

        return $files_r;
    }

    public function filesizeText($path)
    {
        //return $path;
        $bytes = filesize($path);
        //$bytes = 210036;
        $label = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB' );
        for( $i = 0; $bytes >= 1024 && $i < ( count( $label ) -1 ); $bytes /= 1024, $i++ );
        return( round( $bytes, 2 ) . " " . $label[$i] );
    }


    public function upload($subDir='')
    {
        $dir = $this->routes->uploadDir.'/'.$subDir.'/';
        if ($this->validate()) { 
            foreach ($this->files as $file) {
                $file->saveAs($dir . $file->baseName . '.' . $file->extension);
            }
            return true;
        } else {
            return false;
        }
    }
}
