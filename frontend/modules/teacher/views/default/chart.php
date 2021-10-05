<?php

/** @var frontend\components\FrontendView $this */

$this->title = "O'qituvchi profili";

\frontend\assets\adminty\AdmintyAmchartAsset::register($this);

?>

    <div class="col-xl-8 col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-header-left ">
                    <h5>Monthly View</h5>
                    <span class="text-muted">For more details about usage,
                                                                please refer <a
                            href="https://www.amcharts.com/online-store/"
                            target="_blank">amCharts</a> licences.</span>
                </div>
            </div>
            <div class="card-block-big">
                <div id="monthly-graph" style="height:250px"></div>
            </div>
        </div>
    </div>


<?php

$js = <<<JS

      var chartData = [{
        "date": "2012-01-01",
        "distance": 227,
        "townName": "New York",
        "townName2": "New York",
        "townSize": 25,
        "latitude": 40.71,
        "duration": 408
    }, {
        "date": "2012-01-02",
        "distance": 371,
        "townName": "Washington",
        "townSize": 14,
        "latitude": 38.89,
        "duration": 482
    }, {
        "date": "2012-01-03",
        "distance": 433,
        "townName": "Wilmington",
        "townSize": 6,
        "latitude": 34.22,
        "duration": 562
    }, {
        "date": "2012-01-04",
        "distance": 345,
        "townName": "Jacksonville",
        "townSize": 7,
        "latitude": 30.35,
        "duration": 379
    }, {
        "date": "2012-01-05",
        "distance": 480,
        "townName": "Miami",
        "townName2": "Miami",
        "townSize": 10,
        "latitude": 25.83,
        "duration": 501
    }, {
        "date": "2012-01-06",
        "distance": 386,
        "townName": "Tallahassee",
        "townSize": 7,
        "latitude": 30.46,
        "duration": 443
    }, {
        "date": "2012-01-07",
        "distance": 348,
        "townName": "New Orleans",
        "townSize": 10,
        "latitude": 29.94,
        "duration": 405
    }, {
        "date": "2012-01-08",
        "distance": 238,
        "townName": "Houston",
        "townName2": "Houston",
        "townSize": 16,
        "latitude": 29.76,
        "duration": 309
    }, {
        "date": "2012-01-09",
        "distance": 218,
        "townName": "Dalas",
        "townSize": 17,
        "latitude": 32.8,
        "duration": 287
    }, {
        "date": "2012-01-10",
        "distance": 349,
        "townName": "Oklahoma City",
        "townSize": 11,
        "latitude": 35.49,
        "duration": 485
    }, {
        "date": "2012-01-11",
        "distance": 603,
        "townName": "Kansas City",
        "townSize": 10,
        "latitude": 39.1,
        "duration": 890
    }, {
        "date": "2012-01-12",
        "distance": 534,
        "townName": "Denver",
        "townName2": "Denver",
        "townSize": 18,
        "latitude": 39.74,
        "duration": 810
    }, {
        "date": "2012-01-13",
        "townName": "Salt Lake City",
        "townSize": 12,
        "distance": 425,
        "duration": 670,
        "latitude": 40.75,
        "alpha": 0.4
    }, {
        "date": "2012-01-14",
        "latitude": 36.1,
        "duration": 470,
        "townName": "Las Vegas",
        "townName2": "Las Vegas",
        "bulletClass": "lastBullet"
    }, {
        "date": "2012-01-15"
    }];
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
            "valueField": "distance",
            "title": "distance",
            "type": "column",
            "fillAlphas": 0.9,
            // "cornerRadiusTop": 5,
            // "columnWidth": 0.3,
            "valueAxis": "a1",
            "balloonText": "[[value]] miles",
            "legendValueText": "[[value]] mi",
            "legendPeriodValueText": "total: [[value.sum]] mi",
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
            "type": "line",
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


JS;

$this->registerJs($js);

?>