<?php

/* @var $this yii\web\View */

$this->title = t('Basic page');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-index">

    <section class="content" style="height: auto !important; min-height: 0px !important;">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>150</h3>

                        <p>New Orders</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>53<sup style="font-size: 20px">%</sup></h3>

                        <p>Bounce Rate</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>44</h3>

                        <p>User Registrations</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>65</h3>

                        <p>Unique Visitors</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
            <!-- right col (We are only adding the ID to make the widgets sortable)-->
            <section class="col-lg-5 connectedSortable ui-sortable">

                <!-- solid sales graph -->
                <div class="box box-solid bg-teal-gradient">
                    <div class="box-header ui-sortable-handle" style="cursor: move;">
                        <i class="fa fa-th"></i>

                        <h3 class="box-title">Sales Graph</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn bg-teal btn-sm" data-widget="collapse"><i
                                    class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn bg-teal btn-sm" data-widget="remove"><i
                                    class="fa fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body border-radius-none">
                        <div class="chart" id="line-chart"
                             style="height: 250px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
                            <svg height="250" version="1.1" width="416" xmlns="http://www.w3.org/2000/svg"
                                 style="overflow: hidden; position: relative; left: -0.75px; top: -0.59375px;">
                                <desc style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Created with Raphaël
                                    2.3.0
                                </desc>
                                <defs style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></defs>
                                <text x="41" y="214" text-anchor="end" font-family="Open Sans" font-size="10px"
                                      stroke="none" fill="#ffffff"
                                      style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: &quot;Open Sans&quot;; font-size: 10px; font-weight: normal;"
                                      font-weight="normal">
                                    <tspan dy="3.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">0</tspan>
                                </text>
                                <path fill="none" stroke="#efefef" d="M53.5,214H391.25" stroke-width="0.4"
                                      style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path>
                                <text x="41" y="166.75" text-anchor="end" font-family="Open Sans" font-size="10px"
                                      stroke="none" fill="#ffffff"
                                      style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: &quot;Open Sans&quot;; font-size: 10px; font-weight: normal;"
                                      font-weight="normal">
                                    <tspan dy="3.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">5,000</tspan>
                                </text>
                                <path fill="none" stroke="#efefef" d="M53.5,166.75H391.25" stroke-width="0.4"
                                      style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path>
                                <text x="41" y="119.5" text-anchor="end" font-family="Open Sans" font-size="10px"
                                      stroke="none" fill="#ffffff"
                                      style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: &quot;Open Sans&quot;; font-size: 10px; font-weight: normal;"
                                      font-weight="normal">
                                    <tspan dy="3.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">10,000
                                    </tspan>
                                </text>
                                <path fill="none" stroke="#efefef" d="M53.5,119.5H391.25" stroke-width="0.4"
                                      style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path>
                                <text x="41" y="72.25" text-anchor="end" font-family="Open Sans" font-size="10px"
                                      stroke="none" fill="#ffffff"
                                      style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: &quot;Open Sans&quot;; font-size: 10px; font-weight: normal;"
                                      font-weight="normal">
                                    <tspan dy="3.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">15,000
                                    </tspan>
                                </text>
                                <path fill="none" stroke="#efefef" d="M53.5,72.25H391.25" stroke-width="0.4"
                                      style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path>
                                <text x="41" y="25" text-anchor="end" font-family="Open Sans" font-size="10px"
                                      stroke="none" fill="#ffffff"
                                      style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: &quot;Open Sans&quot;; font-size: 10px; font-weight: normal;"
                                      font-weight="normal">
                                    <tspan dy="3.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">20,000
                                    </tspan>
                                </text>
                                <path fill="none" stroke="#efefef" d="M53.5,25H391.25" stroke-width="0.4"
                                      style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path>
                                <text x="329.2812879708384" y="226.5" text-anchor="middle" font-family="Open Sans"
                                      font-size="10px" stroke="none" fill="#ffffff"
                                      style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: &quot;Open Sans&quot;; font-size: 10px; font-weight: normal;"
                                      font-weight="normal" transform="matrix(1,0,0,1,0,5.5)">
                                    <tspan dy="3.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">2013</tspan>
                                </text>
                                <text x="179.07897934386392" y="226.5" text-anchor="middle" font-family="Open Sans"
                                      font-size="10px" stroke="none" fill="#ffffff"
                                      style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: &quot;Open Sans&quot;; font-size: 10px; font-weight: normal;"
                                      font-weight="normal" transform="matrix(1,0,0,1,0,5.5)">
                                    <tspan dy="3.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">2012</tspan>
                                </text>
                                <path fill="none" stroke="#efefef"
                                      d="M53.5,188.8063C62.93894289185905,188.5417,81.81682867557714,190.4009875,91.2557715674362,187.74790000000002C100.69471445929526,185.09481250000002,119.57260024301334,168.75624016393445,129.0115431348724,167.5816C138.34788882138517,166.41972766393442,157.02058019441068,180.6438625,166.35692588092346,178.40185C175.69327156743623,176.1598375,194.3659629404617,151.8811350409836,203.70230862697449,149.6455C213.14125151883354,147.3852975409836,232.01913730255163,158.0678125,241.45808019441068,160.4185C250.89702308626974,162.7691875,269.7749088699878,179.6189893442623,279.2138517618469,168.451C288.55019744835965,157.40440184426228,307.2228888213852,78.52883321823204,316.55923450789794,71.56015C325.7929829890644,64.66804571823204,344.2604799513973,105.24937403846155,353.4942284325638,113.00785C362.9331713244228,120.93873653846154,381.811057108141,128.9901625,391.25,134.3176"
                                      stroke-width="2" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path>
                                <circle cx="53.5" cy="188.8063" r="4" fill="#efefef" stroke="#efefef" stroke-width="1"
                                        style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                                <circle cx="91.2557715674362" cy="187.74790000000002" r="4" fill="#efefef"
                                        stroke="#efefef" stroke-width="1"
                                        style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                                <circle cx="129.0115431348724" cy="167.5816" r="4" fill="#efefef" stroke="#efefef"
                                        stroke-width="1"
                                        style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                                <circle cx="166.35692588092346" cy="178.40185" r="4" fill="#efefef" stroke="#efefef"
                                        stroke-width="1"
                                        style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                                <circle cx="203.70230862697449" cy="149.6455" r="4" fill="#efefef" stroke="#efefef"
                                        stroke-width="1"
                                        style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                                <circle cx="241.45808019441068" cy="160.4185" r="4" fill="#efefef" stroke="#efefef"
                                        stroke-width="1"
                                        style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                                <circle cx="279.2138517618469" cy="168.451" r="4" fill="#efefef" stroke="#efefef"
                                        stroke-width="1"
                                        style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                                <circle cx="316.55923450789794" cy="71.56015" r="4" fill="#efefef" stroke="#efefef"
                                        stroke-width="1"
                                        style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                                <circle cx="353.4942284325638" cy="113.00785" r="4" fill="#efefef" stroke="#efefef"
                                        stroke-width="1"
                                        style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                                <circle cx="391.25" cy="134.3176" r="4" fill="#efefef" stroke="#efefef" stroke-width="1"
                                        style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                            </svg>
                            <div class="morris-hover morris-default-style"
                                 style="left: 85.9881px; top: 100px; display: none;">
                                <div class="morris-hover-row-label">2011 Q3</div>
                                <div class="morris-hover-point" style="color: #efefef">
                                    Item 1:
                                    4,912
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer no-border">
                        <div class="row">
                            <div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4">
                                <div style="display:inline;width:60px;height:60px;">
                                    <canvas width="60" height="60"></canvas>
                                    <input type="text" class="knob" data-readonly="true" value="20" data-width="60"
                                           data-height="60" data-fgcolor="#39CCCC" readonly="readonly"
                                           style="width: 34px; height: 20px; position: absolute; vertical-align: middle; margin-top: 20px; margin-left: -47px; border: 0px; background: none; font: bold 12px Arial; text-align: center; color: rgb(57, 204, 204); padding: 0px; appearance: none;">
                                </div>

                                <div class="knob-label">Mail-Orders</div>
                            </div>
                            <!-- ./col -->
                            <div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4">
                                <div style="display:inline;width:60px;height:60px;">
                                    <canvas width="60" height="60"></canvas>
                                    <input type="text" class="knob" data-readonly="true" value="50" data-width="60"
                                           data-height="60" data-fgcolor="#39CCCC" readonly="readonly"
                                           style="width: 34px; height: 20px; position: absolute; vertical-align: middle; margin-top: 20px; margin-left: -47px; border: 0px; background: none; font: bold 12px Arial; text-align: center; color: rgb(57, 204, 204); padding: 0px; appearance: none;">
                                </div>

                                <div class="knob-label">Online</div>
                            </div>
                            <!-- ./col -->
                            <div class="col-xs-4 text-center">
                                <div style="display:inline;width:60px;height:60px;">
                                    <canvas width="60" height="60"></canvas>
                                    <input type="text" class="knob" data-readonly="true" value="30" data-width="60"
                                           data-height="60" data-fgcolor="#39CCCC" readonly="readonly"
                                           style="width: 34px; height: 20px; position: absolute; vertical-align: middle; margin-top: 20px; margin-left: -47px; border: 0px; background: none; font: bold 12px Arial; text-align: center; color: rgb(57, 204, 204); padding: 0px; appearance: none;">
                                </div>

                                <div class="knob-label">In-Store</div>
                            </div>
                            <!-- ./col -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.box-footer -->
                </div>
                <!-- /.box -->

            </section>

            <section class="col-lg-5 connectedSortable ui-sortable">

                <!-- solid sales graph -->
                <div class="box box-solid bg-teal-gradient">
                    <div class="box-header ui-sortable-handle" style="cursor: move;">
                        <i class="fa fa-th"></i>

                        <h3 class="box-title">Register Graph</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn bg-teal btn-sm" data-widget="collapse"><i
                                    class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn bg-teal btn-sm" data-widget="remove"><i
                                    class="fa fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body border-radius-none">
                        <div class="chart" id="line-chart"
                             style="height: 250px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
                            <svg height="250" version="1.1" width="416" xmlns="http://www.w3.org/2000/svg"
                                 style="overflow: hidden; position: relative; left: -0.75px; top: -0.59375px;">
                                <desc style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Created with Raphaël
                                    2.3.0
                                </desc>
                                <defs style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></defs>
                                <text x="41" y="214" text-anchor="end" font-family="Open Sans" font-size="10px"
                                      stroke="none" fill="#ffffff"
                                      style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: &quot;Open Sans&quot;; font-size: 10px; font-weight: normal;"
                                      font-weight="normal">
                                    <tspan dy="3.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">0</tspan>
                                </text>
                                <path fill="none" stroke="#efefef" d="M53.5,214H391.25" stroke-width="0.4"
                                      style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path>
                                <text x="41" y="166.75" text-anchor="end" font-family="Open Sans" font-size="10px"
                                      stroke="none" fill="#ffffff"
                                      style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: &quot;Open Sans&quot;; font-size: 10px; font-weight: normal;"
                                      font-weight="normal">
                                    <tspan dy="3.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">5,000</tspan>
                                </text>
                                <path fill="none" stroke="#efefef" d="M53.5,166.75H391.25" stroke-width="0.4"
                                      style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path>
                                <text x="41" y="119.5" text-anchor="end" font-family="Open Sans" font-size="10px"
                                      stroke="none" fill="#ffffff"
                                      style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: &quot;Open Sans&quot;; font-size: 10px; font-weight: normal;"
                                      font-weight="normal">
                                    <tspan dy="3.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">10,000
                                    </tspan>
                                </text>
                                <path fill="none" stroke="#efefef" d="M53.5,119.5H391.25" stroke-width="0.4"
                                      style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path>
                                <text x="41" y="72.25" text-anchor="end" font-family="Open Sans" font-size="10px"
                                      stroke="none" fill="#ffffff"
                                      style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: &quot;Open Sans&quot;; font-size: 10px; font-weight: normal;"
                                      font-weight="normal">
                                    <tspan dy="3.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">15,000
                                    </tspan>
                                </text>
                                <path fill="none" stroke="#efefef" d="M53.5,72.25H391.25" stroke-width="0.4"
                                      style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path>
                                <text x="41" y="25" text-anchor="end" font-family="Open Sans" font-size="10px"
                                      stroke="none" fill="#ffffff"
                                      style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: &quot;Open Sans&quot;; font-size: 10px; font-weight: normal;"
                                      font-weight="normal">
                                    <tspan dy="3.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">20,000
                                    </tspan>
                                </text>
                                <path fill="none" stroke="#efefef" d="M53.5,25H391.25" stroke-width="0.4"
                                      style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path>
                                <text x="329.2812879708384" y="226.5" text-anchor="middle" font-family="Open Sans"
                                      font-size="10px" stroke="none" fill="#ffffff"
                                      style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: &quot;Open Sans&quot;; font-size: 10px; font-weight: normal;"
                                      font-weight="normal" transform="matrix(1,0,0,1,0,5.5)">
                                    <tspan dy="3.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">2013</tspan>
                                </text>
                                <text x="179.07897934386392" y="226.5" text-anchor="middle" font-family="Open Sans"
                                      font-size="10px" stroke="none" fill="#ffffff"
                                      style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: &quot;Open Sans&quot;; font-size: 10px; font-weight: normal;"
                                      font-weight="normal" transform="matrix(1,0,0,1,0,5.5)">
                                    <tspan dy="3.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">2012</tspan>
                                </text>
                                <path fill="none" stroke="#efefef"
                                      d="M53.5,188.8063C62.93894289185905,188.5417,81.81682867557714,190.4009875,91.2557715674362,187.74790000000002C100.69471445929526,185.09481250000002,119.57260024301334,168.75624016393445,129.0115431348724,167.5816C138.34788882138517,166.41972766393442,157.02058019441068,180.6438625,166.35692588092346,178.40185C175.69327156743623,176.1598375,194.3659629404617,151.8811350409836,203.70230862697449,149.6455C213.14125151883354,147.3852975409836,232.01913730255163,158.0678125,241.45808019441068,160.4185C250.89702308626974,162.7691875,269.7749088699878,179.6189893442623,279.2138517618469,168.451C288.55019744835965,157.40440184426228,307.2228888213852,78.52883321823204,316.55923450789794,71.56015C325.7929829890644,64.66804571823204,344.2604799513973,105.24937403846155,353.4942284325638,113.00785C362.9331713244228,120.93873653846154,381.811057108141,128.9901625,391.25,134.3176"
                                      stroke-width="2" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path>
                                <circle cx="53.5" cy="188.8063" r="4" fill="#efefef" stroke="#efefef" stroke-width="1"
                                        style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                                <circle cx="91.2557715674362" cy="187.74790000000002" r="4" fill="#efefef"
                                        stroke="#efefef" stroke-width="1"
                                        style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                                <circle cx="129.0115431348724" cy="167.5816" r="4" fill="#efefef" stroke="#efefef"
                                        stroke-width="1"
                                        style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                                <circle cx="166.35692588092346" cy="178.40185" r="4" fill="#efefef" stroke="#efefef"
                                        stroke-width="1"
                                        style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                                <circle cx="203.70230862697449" cy="149.6455" r="4" fill="#efefef" stroke="#efefef"
                                        stroke-width="1"
                                        style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                                <circle cx="241.45808019441068" cy="160.4185" r="4" fill="#efefef" stroke="#efefef"
                                        stroke-width="1"
                                        style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                                <circle cx="279.2138517618469" cy="168.451" r="4" fill="#efefef" stroke="#efefef"
                                        stroke-width="1"
                                        style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                                <circle cx="316.55923450789794" cy="71.56015" r="4" fill="#efefef" stroke="#efefef"
                                        stroke-width="1"
                                        style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                                <circle cx="353.4942284325638" cy="113.00785" r="4" fill="#efefef" stroke="#efefef"
                                        stroke-width="1"
                                        style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                                <circle cx="391.25" cy="134.3176" r="4" fill="#efefef" stroke="#efefef" stroke-width="1"
                                        style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                            </svg>
                            <div class="morris-hover morris-default-style"
                                 style="left: 85.9881px; top: 100px; display: none;">
                                <div class="morris-hover-row-label">2011 Q3</div>
                                <div class="morris-hover-point" style="color: #efefef">
                                    Item 1:
                                    4,912
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer no-border">
                        <div class="row">
                            <div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4">
                                <div style="display:inline;width:60px;height:60px;">
                                    <canvas width="60" height="60"></canvas>
                                    <input type="text" class="knob" data-readonly="true" value="20" data-width="60"
                                           data-height="60" data-fgcolor="#39CCCC" readonly="readonly"
                                           style="width: 34px; height: 20px; position: absolute; vertical-align: middle; margin-top: 20px; margin-left: -47px; border: 0px; background: none; font: bold 12px Arial; text-align: center; color: rgb(57, 204, 204); padding: 0px; appearance: none;">
                                </div>

                                <div class="knob-label">Mail-Orders</div>
                            </div>
                            <!-- ./col -->
                            <div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4">
                                <div style="display:inline;width:60px;height:60px;">
                                    <canvas width="60" height="60"></canvas>
                                    <input type="text" class="knob" data-readonly="true" value="50" data-width="60"
                                           data-height="60" data-fgcolor="#39CCCC" readonly="readonly"
                                           style="width: 34px; height: 20px; position: absolute; vertical-align: middle; margin-top: 20px; margin-left: -47px; border: 0px; background: none; font: bold 12px Arial; text-align: center; color: rgb(57, 204, 204); padding: 0px; appearance: none;">
                                </div>

                                <div class="knob-label">Online</div>
                            </div>
                            <!-- ./col -->
                            <div class="col-xs-4 text-center">
                                <div style="display:inline;width:60px;height:60px;">
                                    <canvas width="60" height="60"></canvas>
                                    <input type="text" class="knob" data-readonly="true" value="30" data-width="60"
                                           data-height="60" data-fgcolor="#39CCCC" readonly="readonly"
                                           style="width: 34px; height: 20px; position: absolute; vertical-align: middle; margin-top: 20px; margin-left: -47px; border: 0px; background: none; font: bold 12px Arial; text-align: center; color: rgb(57, 204, 204); padding: 0px; appearance: none;">
                                </div>

                                <div class="knob-label">In-Store</div>
                            </div>
                            <!-- ./col -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.box-footer -->
                </div>
                <!-- /.box -->

            </section>
        </div>
        <!-- /.row (main row) -->
    </section>

</div>
