<?php


namespace soft\helpers;

use Yii;
use yii\base\Exception;
use yii\base\Model;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class UploadHelper extends Model
{

    const TYPE_FILE = 'file';
    const TYPE_IMAGE = 'image';

    public $required = false;

    /**
     * @var string type of the validator (self:TYPE_FILE or self:TYPE_IMAGE)
     */
    public $type = self::TYPE_FILE;

    public $fileRules = [
        'extensions' => ['jpg', 'jpeg'],
        'maxSize' => 1024000,
    ];

    /**
     * @var string|null dirname for uploading file
     * This dir must be located under frontend/uploads dir
     * If not set the file will be uploaded directly frontend/uploads dir
     */
    public $dirName;

    /**
     * @var string|UploadedFile attribute for ActiveForm
     */
    public $file;

    /**
     * @var string $prefix for file name
     * If not set, type property value will be used
     */
    public $prefix;

    public function rules()
    {
        $rules = [];

        $rules[] = array_merge(['file', $this->type], $this->fileRules);

        if ($this->required){
            $rules[] = ['file', 'required'];
        }

        return $rules;
    }

    public function attributeLabels()
    {
        return [
          'file' => "Faylni tanlang"
        ];
    }

    public function upload($fileName=null)
    {

        if ($this->validate()) {
            $this->file =  UploadedFile::getInstance($this, 'file');
            if ($this->file != null){
                if ($fileName == null){
                    $fileName = $this->generateFileName();
                    if ($fileName == false){
                        return false;
                    }
                }
                if( $this->file->saveAs('@frontend/web'.$fileName) ){
                    return $fileName;
                }
            }
            else{
                return null;
            }
        }
        return false;
    }

    private function generateFileName()
    {

        $prefix = $this->prefix ?? $this->type;
        $file =  $prefix ."_". microtime(true) ."_" . mt_rand() . '.' . $this->file->extension;
        if ($this->dirName == null){
            $filePath = '/uploads';
        }
        else{
            $filePath = '/uploads/'. $this->dirName;
        }

        $dirName = Yii::getAlias('@frontend/web'.$filePath);

        if(!is_dir($dirName)){
            try {
                FileHelper::createDirectory($dirName, 0777);
            } catch (Exception $e) {
               return false;
            }
        }

       return $filePath . "/" . $file;

    }


}