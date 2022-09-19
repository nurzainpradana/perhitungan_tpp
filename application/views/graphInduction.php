<!DOCTYPE html>
<html lang="en">

<head>
    <!-- META SECTION -->
    <title>IOT</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="icon" href="favicon.ico" type="image/x-icon" />
    <!-- END META SECTION -->

    <!-- CSS INCLUDE -->
    <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>iot_assets/css_new/css/theme-default.css" />
    <!-- EOF CSS INCLUDE -->
    <script src="<?php echo base_url(); ?>iot_assets/js/Chart.bundle.js"></script>
    <script src="<?php echo base_url(); ?>iot_assets/js/utils.js"></script>

    <script src="<?php echo base_url(); ?>iot_assets/js/canvas/canvasjs.min.js"></script>
    <script src="<?php echo base_url(); ?>iot_assets/code/highcharts.js"></script>
    <!-- <script src="<?php echo base_url(); ?>iot_assets/code/modules/series-label.js"></script> -->
    <script src="<?php echo base_url(); ?>iot_assets/code/modules/exporting.js"></script>
    <!-- <script src="<?php echo base_url(); ?>iot_assets/code/js/themes/dark-unica.js"></script> -->

    <style>
        canvas {
            -moz-user-select: none;
            -webkit-user-select: none;
            -ms-user-select: none;
        }
    </style>
</head>


<body>
    <!-- START PAGE CONTAINER -->
    <div class="page-container">


        <!-- PAGE CONTENT -->
        <div class="page-content">


            <!-- START BREADCRUMB -->
            <ul class="breadcrumb">

                <li class="active">INDUCTION POWER 1</li>
                <li><?php echo date('d M Y'); ?></li>
                <span class="breadcrumb2"><a href="#" class="fa fa-desktop" onclick="back()"></a></span>
            </ul>





            <!-- END BREADCRUMB -->

            <!-- PAGE CONTENT WRAPPER -->
            <div class="page-content-wrap">

                <div class="row">
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="panel-title-box">
                                    <h2>POWER</h2>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="row stacked">
                                    <!-- <canvas id="canvas" height="140px"></canvas> -->
                                    <!-- <div id="chartContainer" style="height: 370px; max-width: 920px; margin: 0px auto;"></div> -->
                                    <div id="power"></div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="panel-title-box">
                                    <h2>METAL TEMPERATURE</h2>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="row stacked">
                                    <!-- <canvas id="canvas" height="140px"></canvas> -->
                                    <!-- <div id="chartContainer" style="height: 370px; max-width: 920px; margin: 0px auto;"></div> -->
                                    <div id="metaltemp"></div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="panel-title-box">
                                    <h2>BUSHING TEMPERATURE</h2>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="row stacked">
                                    <!-- <canvas id="canvas" height="140px"></canvas> -->
                                    <!-- <div id="chartContainer" style="height: 370px; max-width: 920px; margin: 0px auto;"></div> -->
                                    <div id="bushingtemp"></div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="panel-title-box">
                                    <h2>LEAK CURRENT & GR</h2>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="row stacked">
                                    <!-- <canvas id="canvas" height="140px"></canvas> -->
                                    <!-- <div id="chartContainer" style="height: 370px; max-width: 920px; margin: 0px auto;"></div> -->
                                    <div id="LeakGR"></div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
            <!-- END PAGE CONTENT WRAPPER -->
        </div>
        <!-- END PAGE CONTENT -->
    </div>
    <!-- END PAGE CONTAINER -->



    <!-- START SCRIPTS -->
    <!-- START PLUGINS -->
    <script type="text/javascript" src="<?php echo base_url(); ?>iot_assets/css_new/js/plugins/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>iot_assets/css_new/js/plugins/jquery/jquery-ui.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>iot_assets/css_new/js/plugins/bootstrap/bootstrap.min.js"></script>
    <!-- END PLUGINS -->

    <!-- START TEMPLATE -->

    <script type="text/javascript" src="<?php echo base_url(); ?>iot_assets/css_new/js/plugins.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>iot_assets/css_new/js/actions.js"></script>

    <!-- END TEMPLATE -->
    <!-- <script src="<?php echo base_url(); ?>iot_assets/js/jquery.min.js"></script> -->
    <script src="<?php echo base_url(); ?>iot_assets/js/jquery.scrollex.min.js"></script>
    <script src="<?php echo base_url(); ?>iot_assets/js/jquery.scrolly.min.js"></script>
    <script src="<?php echo base_url(); ?>iot_assets/js/skel.min.js"></script>
    <script src="<?php echo base_url(); ?>iot_assets/js/util.js"></script>
    <script src="<?php echo base_url(); ?>iot_assets/js/main.js"></script>
    <!-- END SCRIPTS -->

</body>

</html>

<script type="text/javascript">
    $(document).ready(function() {
        loadPower();
        loadMetalTemp();
        loadBushing();
        loadLeak();
    });
    setInterval(function() {
        // window.location.reload(1);
        loadPower();
        loadMetalTemp();
        loadBushing();
        loadLeak();
    }, 60000);
</script>

<script type="text/javascript">
    function back() {
        window.location.href = "<?php echo site_url(''); ?>";
    }

    function loadPower() {
        $.ajax({
            url: "<?php echo site_url('index.php/Testing/dataInductionPower1') ?>",
            type: 'GET',
            // async : false,
            // data: form_data,
            dataType: 'json',
            success: function(data) {
                // console.log(data) ;
                var chartSeriesData = [];
                var chartCatData = [];
                var chartDateData = [];
                var chartPositionsData  = [];

                var times = [];

                chartSeriesData = data.power;
                chartCatData = data.time;
                chartDateData = data.date;

                chartPositionsData  = data.positions;

                chartDateData.forEach(function(item) {
                    var item_date = new Date(item);
                    times.push(item_date.getTime());
                });

                console.log(times);


                // $.each(data, function(i,item){
                //     var series_name = item.time;
                //     var series_data = item.power;   
                //     var series_datetime = item.datetime;

                //     // var series = {data: series_data, name: series_name};
                //     chartSeriesData.push(series_data);
                //     chartCatData.push(series_name);
                //     chartDatetimeData.push(series_datetime);
                //     // chartSeriesData.push(series);
                //     // console.log(item.power) ;
                // });

                // console.log(chartSeriesData) ;

                Highcharts.setOptions({
    time: {
        useUTC: false
    }
});

                Highcharts.chart('power', {

                    title: {
                        text: ''
                    },
                    subtitle: {
                        text: ''
                    },

                    yAxis: {
                        title: {
                            text: 'Power [kW]'
                        },
                        min: 0,
                        max: 500,
                        tickInterval: 100
                    },
                    xAxis: {
                        categories: times,
        //                 type: "datetime",
        //                 crosshair: true,
        //                 tickInterval: 100,
        //                 tickPositions: ['06:16'],     
                       
                            tickPositions: chartPositionsData,
                            lineColor: '#999',
                            lineWidth: 1,
                            tickColor: '#666',
                            tickLength: 3,
                            title: {
                                    text: 'X Axis Title'
                                    },
                            labels: {
                                formatter: function() {
                                    return Highcharts.dateFormat('%H:%M', this.value);
                                }
                            },
                    },
                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'middle'
                    },
                    plotOptions: {
                        series: {
                            label: {
                                connectorAllowed: false
                            }
                        },
                        line: {
                            dataLabels: {
                                enabled: false
                            },
                            enableMouseTracking: true
                        }
                    },

                    series: [{
                        name: 'Power',
                        data: chartSeriesData
                    }],

                    responsive: {
                        rules: [{
                            condition: {
                                maxWidth: 500
                            },
                            chartOptions: {
                                legend: {
                                    layout: 'horizontal',
                                    align: 'center',
                                    verticalAlign: 'bottom'
                                }
                            }
                        }]
                    }

                });
            }
        })
    }

    function loadMetalTemp() {
        $.ajax({
            url: "<?php echo site_url('Dashboard/dataInductionMetalTemp1') ?>",
            type: 'GET',
            // async : false,
            // data: form_data,
            dataType: 'json',
            success: function(data) {
                // console.log(data) ;
                var chartSeriesData = [];
                var chartCatData = [];
                $.each(data, function(i, item) {
                    var series_name = item.time;
                    var series_data = item.MetalTemp;
                    // var series = {data: item.power};
                    chartSeriesData.push(series_data);
                    chartCatData.push(series_name);
                });

                // console.log(chartSeriesData) ;

                Highcharts.chart('metaltemp', {

                    title: {
                        text: ''
                    },
                    subtitle: {
                        text: ''
                    },

                    yAxis: {
                        title: {
                            text: 'Temperatur (Celcius)'
                        },
                        min: 800,
                        max: 1100,
                        tickInterval: 50
                    },
                    xAxis: {
                        categories: chartCatData,
                        title: {
                            text: ''
                        },
                        labels: {
                            enabled: true
                        }
                    },
                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'middle'
                    },
                    plotOptions: {
                        series: {
                            label: {
                                connectorAllowed: false
                            }
                        },
                        line: {
                            dataLabels: {
                                enabled: false
                            },
                            enableMouseTracking: false
                        }
                    },
                    series: [{
                        name: 'Metal Temp',
                        data: chartSeriesData
                    }],

                    responsive: {
                        rules: [{
                            condition: {
                                maxWidth: 500
                            },
                            chartOptions: {
                                legend: {
                                    layout: 'horizontal',
                                    align: 'center',
                                    verticalAlign: 'bottom'
                                }
                            }
                        }]
                    }

                });
            }
        })
    }

    function loadBushing() {
        $.ajax({
            url: "<?php echo site_url('Dashboard/dataInductionBushing1') ?>",
            type: 'GET',
            // async : false,
            // data: form_data,
            dataType: 'json',
            success: function(data) {
                // console.log(data) ;
                var chartSeriesData1 = [];
                var chartSeriesData2 = [];
                var chartSeriesData3 = [];
                var chartSeriesData4 = [];
                var chartCatData = [];
                $.each(data, function(i, item) {
                    var series_data1 = item.bushtemp1;
                    var series_data2 = item.bushtemp2;
                    var series_data3 = item.bushtemp3;
                    var series_data4 = item.bushtemp4;
                    var series_name = item.time;
                    chartSeriesData1.push(series_data1);
                    chartSeriesData2.push(series_data2);
                    chartSeriesData3.push(series_data3);
                    chartSeriesData4.push(series_data4);
                    chartCatData.push(series_name);
                });

                // console.log(chartSeriesData1) ;
                // console.log(chartSeriesData2) ;

                Highcharts.chart('bushingtemp', {

                    title: {
                        text: ''
                    },
                    subtitle: {
                        text: ''
                    },

                    yAxis: {
                        title: {
                            text: 'Temperatur (Celcius)'
                        },
                        min: 300,
                        max: 500,
                        tickInterval: 50
                    },
                    xAxis: {
                        categories: chartCatData,
                        title: {
                            text: ''
                        },
                        labels: {
                            enabled: true
                        }
                    },
                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'middle'
                    },
                    plotOptions: {
                        series: {
                            label: {
                                connectorAllowed: false
                            }
                        },
                        line: {
                            dataLabels: {
                                enabled: false
                            },
                            enableMouseTracking: false
                        }
                    },
                    series: [{
                            name: 'Bush Temp 1',
                            data: chartSeriesData1
                        },
                        {
                            name: 'Bush Temp 2',
                            data: chartSeriesData2
                        },
                        {
                            name: 'Bush Temp 3',
                            data: chartSeriesData3
                        },
                        {
                            name: 'Bush Temp 4',
                            data: chartSeriesData4
                        }
                    ],

                    responsive: {
                        rules: [{
                            condition: {
                                maxWidth: 500
                            },
                            chartOptions: {
                                legend: {
                                    layout: 'horizontal',
                                    align: 'center',
                                    verticalAlign: 'bottom'
                                }
                            }
                        }]
                    }

                });
            }
        })
    }

    function loadLeak() {
        $.ajax({
            url: "<?php echo site_url('Dashboard/dataInductionLeakGround') ?>",
            type: 'GET',
            // async : false,
            // data: form_data,
            dataType: 'json',
            success: function(data) {
                // console.log(data) ;
                var chartSeriesData1 = [];
                var chartSeriesData2 = [];
                var chartCatData = [];
                $.each(data, function(i, item) {
                    var series_data1 = item.leak;
                    var series_data2 = item.gr;
                    var series_name = item.time;
                    chartSeriesData1.push(series_data1);
                    chartSeriesData2.push(series_data2);
                    chartCatData.push(series_name);
                });

                // console.log(chartSeriesData1) ;
                // console.log(chartSeriesData2) ;

                Highcharts.chart('LeakGR', {

                    title: {
                        text: ''
                    },
                    subtitle: {
                        text: ''
                    },

                    yAxis: [{
                            title: {
                                text: 'GR [%]'
                            },
                            min: 0,
                            max: 100,
                            tickInterval: 20
                        },
                        {
                            title: {
                                text: 'Leak Current [mA]'
                            },
                            min: 0,
                            max: 500,
                            tickInterval: 100,
                            opposite: true
                        }
                    ],
                    xAxis: {
                        categories: chartCatData,
                        title: {
                            text: ''
                        },
                        labels: {
                            enabled: true
                        }
                    },
                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'middle'
                    },
                    plotOptions: {
                        series: {
                            label: {
                                connectorAllowed: false
                            }
                        },
                        line: {
                            dataLabels: {
                                enabled: false
                            },
                            enableMouseTracking: false
                        }
                    },
                    series: [{
                            name: 'Leak',
                            data: chartSeriesData1
                        },
                        {
                            name: 'GR',
                            data: chartSeriesData2
                        }
                    ],

                    responsive: {
                        rules: [{
                            condition: {
                                maxWidth: 500
                            },
                            chartOptions: {
                                legend: {
                                    layout: 'horizontal',
                                    align: 'center',
                                    verticalAlign: 'bottom'
                                }
                            }
                        }]
                    }

                });
            }
        })
    }
</script>