<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace soft\gii\generators\model;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Connection;
use yii\db\Schema;
use yii\db\TableSchema;
use yii\gii\CodeFile;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/**
 * This generator will generate one or multiple ActiveRecord classes for the specified database table.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class Generator extends \yii\gii\generators\model\Generator
{
    const RELATIONS_NONE = 'none';
    const RELATIONS_ALL = 'all';
    const RELATIONS_ALL_INVERSE = 'all-inverse';

    public $db = 'db';
    public $ns = 'backend\models';
    public $tableName;
    public $modelClass;
    public $baseClass = 'soft\db\SActiveRecord';
    public $generateRelations = self::RELATIONS_ALL;
    public $generateRelationsFromCurrentSchema = true;
    public $generateLabelsFromComments = false;
    public $useTablePrefix = false;
    public $standardizeCapitals = false;
    public $singularize = false;
    public $useSchemaName = true;
    public $generateQuery = false;
    public $queryNs = 'backend\models\query';
    public $queryClass;
    public $queryBaseClass = 'soft\db\SActiveQuery';


    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Soft Model Generator';
    }

}
