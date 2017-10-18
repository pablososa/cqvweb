<?php echo $this->Html->script('highcharts'); ?>
<?php echo $this->Html->script('jquery.politedatepicker'); ?>
<?php echo $this->element('menus/empresas', array('active' => 'estadisticas:index')) ?>
<div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    <?php echo __('Estadísticas'); ?>
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-home"></i> <?php echo __('Estadísticas'); ?>
                    </li>

                </ol>
            </div>
        </div>
        <!-- /.row -->


        <div class="panel panel-primary" style="border-color:black">
            <div class="panel-heading" style="background:black">
                <h2></h2>
            </div>
            <div class="panel-body" style="margin: 10px">

                <div class="container pt15 pb15">
                    <div class="row">

                        <section id="content" class="col-md-9">
                            <div class="row">
                                <div class="estadisticas-graph-container">
                                </div>
                            </div>
                            <div class="row form-estadisticas">
                                <?php echo $this->Form->create('Estadistica', array('url' => array('action' => 'getData'), 'class' => 'get-data')); ?>
                                <div class="col-md-6">
                                    <?php echo $this->Form->input('fecha_ini', array('class' => 'form-control lg datepicker', 'label' => __('Desde'))); ?>
                                </div>
                                <div class="col-md-6">
                                    <?php echo $this->Form->input('fecha_fin', array('class' => 'form-control lg datepicker', 'label' => __('Hasta'))); ?>
                                </div>
                                <div style="display: none;">
                                    <?php echo $this->Form->submit(__('Buscar')); ?>
                                </div>
                                <?php echo $this->Form->end(); ?>
                            </div>
                            <div class="row">
                                <div class="estadisticas-table-container">
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        function getData() {
            var options = {
                url: $('form.get-data').attr('action') + '/graph',
                type: 'POST',
                data: $('form.get-data').serialize(),
                success: function (data) {
                    $('.estadisticas-graph-container:first').highcharts({
                        chart: {
                            type: 'area'
                        },
                        title: {
                            text: "<?php echo __('Viajes por Día'); ?>"
                        },
//                        subtitle: {
//                            text: 'Source: Wikipedia.org'
//                        },
                        xAxis: {
                            categories: data.fechas,
                            tickmarkPlacement: 'on',
                            title: {
                                enabled: false
                            },
                            labels: {
                                rotation: -65,
                            }
                        },
                        yAxis: {
                            title: {
                                text: "<?php echo __('Viajes'); ?>"
                            },
//                            labels: {
//                                formatter: function () {
//                                    return this.value / 1000;
//                                }
//                            }
                        },
                        tooltip: {
                            shared: true,
                            valueSuffix: ' viajes'
                        },
                        plotOptions: {
                            area: {
                                stacking: 'normal',
                                lineColor: '#666666',
                                lineWidth: 1,
                                marker: {
                                    lineWidth: 1,
                                    lineColor: '#666666'
                                }
                            }
                        },
                        series: data.data
                    });
                }
            };
            $.ajax(options);
            var options = {
                url: $('form.get-data').attr('action') + '/table',
                type: 'POST',
                data: $('form.get-data').serialize(),
                success: function (data) {
                    $('.estadisticas-table-container').html(data);
                }
            };
            $.ajax(options);
        }

        getData();
        $('#EstadisticaFechaIni').change(getData);
        $('#EstadisticaFechaFin').change(getData);
        /**
         * Grid-light theme for Highcharts JS
         * @author Torstein Honsi
         */

// Load the fonts
//        Highcharts.createElement('link', {
//            href: 'http://fonts.googleapis.com/css?family=Dosis:400,600',
//            rel: 'stylesheet',
//            type: 'text/css'
//        }, null, document.getElementsByTagName('head')[0]);
//
//        Highcharts.theme = {
//            colors: ["#7cb5ec", "#f7a35c", "#90ee7e", "#7798BF", "#aaeeee", "#ff0066", "#eeaaee",
//                "#55BF3B", "#DF5353", "#7798BF", "#aaeeee"],
//            chart: {
//                backgroundColor: null,
//                style: {
//                    fontFamily: "Dosis, sans-serif"
//                }
//            },
//            title: {
//                style: {
//                    fontSize: '16px',
//                    fontWeight: 'bold',
//                    textTransform: 'uppercase'
//                }
//            },
//            tooltip: {
//                borderWidth: 0,
//                backgroundColor: 'rgba(219,219,216,0.8)',
//                shadow: false
//            },
//            legend: {
//                itemStyle: {
//                    fontWeight: 'bold',
//                    fontSize: '13px'
//                }
//            },
//            xAxis: {
//                gridLineWidth: 1,
//                labels: {
//                    style: {
//                        fontSize: '12px'
//                    }
//                }
//            },
//            yAxis: {
//                minorTickInterval: 'auto',
//                title: {
//                    style: {
//                        textTransform: 'uppercase'
//                    }
//                },
//                labels: {
//                    style: {
//                        fontSize: '12px'
//                    }
//                }
//            },
//            plotOptions: {
//                candlestick: {
//                    lineColor: '#404048'
//                }
//            },
//            // General
//            background2: '#F0F0EA'
//
//        };
//
//// Apply the theme
//        Highcharts.setOptions(Highcharts.theme);
    });
</script>