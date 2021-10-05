<?php


namespace soft\form;

use kartik\builder\FormGrid;

class SFormGrid extends FormGrid
{
    protected function getGridOutput()
    {
        $output = '';
        foreach ($this->rows as $row) {
            $defaults = [
                'model' => $this->model,
                'form' => $this->form,
                'formName' => $this->formName,
                'columns' => $this->columns,
                'attributeDefaults' => $this->attributeDefaults,
                'autoGenerateColumns' => $this->autoGenerateColumns,
                'columnSize' => $this->columnSize,
                'columnOptions' => $this->columnOptions,
                'rowOptions' => $this->rowOptions,
                'options' => $this->fieldSetOptions,
            ];
            $config = array_replace_recursive($defaults, $row);
            $output .= SForm::widget($config) . "\n";
        }
        return $output;
    }
}