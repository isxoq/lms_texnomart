<?php

/** @var frontend\components\FrontendView $this */

use backend\modules\billing\models\Purchases;
use backend\modules\billing\models\Payouts;

$this->title = "O'qituvchi profili";

\frontend\assets\adminty\AdmintyAmchartAsset::register($this);
$totalRevenue = Purchases::totalRevenue(false);
?>


    <div class="row">
        <!-- task, page, download counter  start -->
        <div class="col-xl-3 col-md-6">
            <?= \soft\adminty\widgets\ECard::widget([
                'mainLabel' => user()->getEnrolledUsers()->count(),
                'rightIconClass' => 'feather icon-user f-28',
                'subLabel' => "Umumiy talabalar soni",
                'footerLink' => ''
            ]) ?>
        </div>

     <!--   <div class="col-xl-3 col-md-6">
            <?/*= \soft\adminty\widgets\ECard::widget([
                'mainLabel' => Yii::$app->formatter->asInteger($totalRevenue),
                'mainLabelClass' => 'text-c-green f-w-600',
                'subLabel' => "Jami tushgan summa",
                'bgFooter' => 'bg-c-green',
                'footerLink' => ''
            ]) */?>
        </div>-->


    <!--    <div class="col-xl-3 col-md-6">
            <?/*= \soft\adminty\widgets\ECard::widget([
                'mainLabel' => Yii::$app->formatter->asInteger(Payouts::getUserPayouts()),
                'mainLabelClass' => 'text-c-blue f-w-600',
                'subLabel' => "Jami to'langan summa",
                'bgFooter' => 'bg-c-blue',
                'rightIconClass' => 'feather icon-download f-28',
                'footerLink' => ''
            ]) */?>
        </div>


        <div class="col-xl-3 col-md-6">
            <?/*= \soft\adminty\widgets\ECard::widget([
                'mainLabel' => Yii::$app->formatter->asInteger($totalRevenue - Payouts::getUserPayouts()),
                'mainLabelClass' => 'text-c-pink f-w-600',
                'subLabel' => "Jami to'lanmagan summa",
                'bgFooter' => 'bg-c-pink',
                'rightIconClass' => 'feather icon-file-text f-28',
                'footerLink' => ''
            ]) */?>
        </div>-->

        <div class="col-xl-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-header-left ">
                        <h5><?= t("Bu oyda qo'shilgan studentlar") ?></h5>

                    </div>
                </div>
                <div class="card-block-big">
                    <div id="monthly-graph" style="height:250px"></div>
                </div>
            </div>
        </div>


     <!--   <div class="col-xl-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-header-left ">
                        <h5><?/*= t("Bu oydagi daromad") */?></h5>

                    </div>
                </div>
                <div class="card-block-big">
                    <div id="monthly-revenue" style="height:250px"></div>
                </div>
            </div>
        </div>-->

    </div>

<?php

$js = <<<JS

        $.ajax({
            url:'/teacher/ajax/monthly-students',
            type:"GET",
            success:function(data) {
               var chartData = JSON.parse(data);
                var chart = AmCharts.makeChart("monthly-graph", {
        "type": "serial",
        "theme": "light",
        "dataDateFormat": "YYYY-MM-DD",
        "dataProvider": chartData,
        "addClassNames": true,
        "startDuration": 1,
        "marginLeft": 0,

        "categoryField": "date",
        "categoryAxis": {
            "parseDates": true,
            "minPeriod": "DD",
            "autoGridCount": false,
            "gridCount": 50,
            "gridAlpha": 0.1,
            "gridColor": "#FFFFFF",
            "axisColor": "#555555",
            "dateFormats": [{
                "period": 'DD',
                "format": 'DD'
            }, {
                "period": 'WW',
                "format": 'MMM DD'
            }, {
                "period": 'MM',
                "format": 'MMM'
            }, {
                "period": 'YYYY',
                "format": 'YYYY'
            }]
        },

        "valueAxes": [{
            "id": "a1",
            "title": "Student",
            "gridAlpha": 0,
            "axisAlpha": 0
        }, {
            "id": "a2",
            "position": "right",
            "gridAlpha": 0,
            "axisAlpha": 0,
            "labelsEnabled": false
        }, {
            "id": "a3",
            "title": "",
            "position": "left",
            "gridAlpha": 0,
            "axisAlpha": 0,
            "lineAlpha": 0,
            "fontSize": 0,
            "inside": true,
        }],
        "graphs": [{
            "id": "g1",
            "valueField": "soni",
            "title": "Soni",
            "type": "column",
            "fillAlphas": 0.9,
            // "cornerRadiusTop": 5,
            // "columnWidth": 0.3,
            "valueAxis": "a1",
            "balloonText": "[[value]] ta",
            "legendValueText": "[[value]] ta",
            "legendPeriodValueText": "total: [[value.sum]] ta",
            "lineColor": "#01a9ac",
            "alphaField": "alpha"
        }, {
            "id": "g2",
            "valueField": "latitude",
            "classNameField": "bulletClass",
            "title": "latitude/city",
            "type": "line",
            // "type": "smoothedLine",
            "valueAxis": "a2",
            "lineColor": "#303549",
            "lineThickness": 2,
            "dashLength": 8,
            "legendValueText": "[[value]]/[[description]]",
            "descriptionField": "townName",
            "bullet": "round",
            "bulletSizeField": "townSize",
            "bulletBorderColor": "#01a9ac",
            "bulletBorderAlpha": 1,
            "bulletBorderThickness": 2,
            "bulletColor": "#0ac282",
            "labelText": "[[townName2]]",
            "labelPosition": "right",
            "balloonText": "latitude:[[value]]",
            "showBalloon": true,
            "animationPlayed": true,
        }, {

            "id": "g3",
            "title": "duration",
            "valueField": "duration",
            "type": "smoothedLine",
            "valueAxis": "a3",
            "lineColor": "#fe5d70",
            "balloonText": "[[value]]",
            "lineThickness": 2,
            "legendValueText": "[[value]]",
            "bullet": "round",
            "bulletBorderColor": "#fe5d70",
            "bulletBorderThickness": 1,
            "bulletBorderAlpha": 1,
            "dashLengthField": "dashLength",
            "animationPlayed": true
        }]
    });
            }
        })
        
                $.ajax({
            url:'/teacher/ajax/monthly-revenue',
            type:"GET",
            success:function(data) {
               var chartData = JSON.parse(data);
                var chart = AmCharts.makeChart("monthly-revenue", {
        "type": "serial",
        "theme": "light",
        "dataDateFormat": "YYYY-MM-DD",
        "dataProvider": chartData,
        "addClassNames": true,
        "startDuration": 1,
        "marginLeft": 0,

        "categoryField": "date",
        "categoryAxis": {
            "parseDates": true,
            "minPeriod": "DD",
            "autoGridCount": false,
            "gridCount": 50,
            "gridAlpha": 0.1,
            "gridColor": "#FFFFFF",
            "axisColor": "#555555",
            "dateFormats": [{
                "period": 'DD',
                "format": 'DD'
            }, {
                "period": 'WW',
                "format": 'MMM DD'
            }, {
                "period": 'MM',
                "format": 'MMM'
            }, {
                "period": 'YYYY',
                "format": 'YYYY'
            }]
        },

        "valueAxes": [{
            "id": "a1",
            "title": "SUM (UZS)",
            "gridAlpha": 0,
            "axisAlpha": 0
        }, {
            "id": "a2",
            "position": "right",
            "gridAlpha": 0,
            "axisAlpha": 0,
            "labelsEnabled": false
        }, {
            "id": "a3",
            "title": "",
            "position": "left",
            "gridAlpha": 0,
            "axisAlpha": 0,
            "lineAlpha": 0,
            "fontSize": 0,
            "inside": true,
        }],
        "graphs": [{
            "id": "g1",
            "valueField": "amount",
            "title": "UZS",
            "type": "column",
            "fillAlphas": 0.9,
            // "cornerRadiusTop": 5,
            // "columnWidth": 0.3,
            "valueAxis": "a1",
            "balloonText": "[[value]] UZS",
            "legendValueText": "[[value]] UZS",
            "legendPeriodValueText": "total: [[value.sum]] UZS",
            "lineColor": "#01a9ac",
            "alphaField": "alpha"
        }, {
            "id": "g2",
            "valueField": "latitude",
            "classNameField": "bulletClass",
            "title": "latitude/city",
            "type": "line",
            // "type": "smoothedLine",
            "valueAxis": "a2",
            "lineColor": "#303549",
            "lineThickness": 2,
            "dashLength": 8,
            "legendValueText": "[[value]]/[[description]]",
            "descriptionField": "townName",
            "bullet": "round",
            "bulletSizeField": "townSize",
            "bulletBorderColor": "#01a9ac",
            "bulletBorderAlpha": 1,
            "bulletBorderThickness": 2,
            "bulletColor": "#0ac282",
            "labelText": "[[townName2]]",
            "labelPosition": "right",
            "balloonText": "latitude:[[value]]",
            "showBalloon": true,
            "animationPlayed": true,
        }, {

            "id": "g3",
            "title": "duration",
            "valueField": "duration",
            "type": "smoothedLine",
            "valueAxis": "a3",
            "lineColor": "#fe5d70",
            "balloonText": "[[value]]",
            "lineThickness": 2,
            "legendValueText": "[[value]]",
            "bullet": "round",
            "bulletBorderColor": "#fe5d70",
            "bulletBorderThickness": 1,
            "bulletBorderAlpha": 1,
            "dashLengthField": "dashLength",
            "animationPlayed": true
        }]
    });
            }
        })

     

JS;

$this->registerJs($js);
