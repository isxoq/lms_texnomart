<?phpnamespace soft\kartik;use Yii;use soft\helpers\SArray;use yii\helpers\ArrayHelper;class SDetailView extends \kartik\detail\DetailView{    public $hover = true;    public $buttons1 = false;    public function init()    {        SArray::setValueIfNoValid($this->panel, 'type', self::TYPE_PRIMARY);        SArray::setValueIfNoValid($this->panel, 'heading', $this->view->title);        $this->generateAttributes();        parent::init();    }    public function generateAttributes()    {        $attributes = [];        foreach ($this->attributes as $key => $value) {            // agar berilgan qiymat faqat attribut nomidan iborat bo'lsa            if (is_string($value)) {                $attributeConfigs = $this->generateConfigs($value);            }            else{//                agar element 'group' elementidan iborat bo'lsa                if (array_key_exists('group', $value)){                    SArray::setValueIfNoValid($value, 'rowOptions.class', 'info');                    $attributes[] = $value;                    continue;                }//                agar view faylda attributga qo'shimcha configlar berilgan bo'lsa...                $attributeConfigs = $this->generateConfigs($key, $value);            }            $attribute = SArray::getValue($attributeConfigs, 'attribute', false);            if ($this->model->isMultilingualAttribute($attribute)){                $generateMultingiualAttributes = SArray::getValue($attributeConfigs, 'multilingual', true);                if ($generateMultingiualAttributes){                    foreach ($this->model->generateMultilingualAttributes($attribute) as $mAttribute){                        $config = $attributeConfigs;                        $config['attribute'] = $mAttribute;                        $attributes[] = $config;                    }                }                else{                    $attributes[] = $attributeConfigs;                }            }            else{                $attributes[] = $attributeConfigs;            }        }        $this->attributes = $attributes;    }    public function defaultConfigs()    {        return [            'created_at' => [                'label' => Yii::t('app', 'Created At'),                'format' => 'dateTimeUz',            ],            'updated_at' => [                'label' => Yii::t('app', 'Updated At'),                'format' => 'dateTimeUz',            ],            'status' => [                'format' => 'status',            ],            'image' => [                'format' => 'image',            ],            'content' => [                'format' => 'html',            ],        ];    }    /**     * Kartik DetailView uchun configni generatsiya qilish     * $customConfigs - bu SDetailViewni generatsiya qilayotganda user tomonidan     * berilgan configlar     */    public function generateConfigs($attribute, $customConfigs = [])    {        $attributeDefaultConfigs = ArrayHelper::getValue($this->defaultConfigs(), $attribute, []);        $configs = ArrayHelper::merge($attributeDefaultConfigs, $customConfigs);        if (!isset($configs['attribute'])){            $configs['attribute'] = $attribute;        }        return $configs;    }}