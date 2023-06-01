/**
 * Charts Apex
 */

'use strict';

(function () {


    let cardColor, headingColor, axisColor, borderColor, radialTrackColor;

    if (isDarkStyle) {
        cardColor = config.colors_dark.cardColor;
        headingColor = config.colors_dark.headingColor;
        axisColor = config.colors_dark.axisColor;
        borderColor = config.colors_dark.borderColor;
        radialTrackColor = '#36435C';
    } else {
        cardColor = config.colors.white;
        headingColor = config.colors.headingColor;
        axisColor = config.colors.axisColor;
        borderColor = config.colors.borderColor;
        radialTrackColor = config.colors_label.secondary;
    }

    // Color constant
    const chartColors = {
        column: {
            series1: '#826af9',
            series2: '#d2b0ff',
            bg: '#f8d3ff'
        },
        donut: {
            series1: '#fee802',
            series2: '#3fd0bd',
            series3: '#826bf8',
            series4: '#2b9bf4'
        },
        area: {
            series1: '#29dac7',
            series2: '#60f2ca',
            series3: '#a5f8cd'
        }
    };


    function buildDataSeries(date, value) {
        var data_date = document.getElementById("" + date).value;
        var data_value = document.getElementById("" + value).value;
//        var data_date = document.getElementById("data_date").value;
//        var data_value = document.getElementById("data_value").value;

        var data_date_split = data_date.split(",");
        var data_value_split = data_value.split(",");

        let data_series = [];
        for (var i = 0; i < data_date_split.length; i++) {

            data_series.push({
                x: data_date_split[i],
                y: data_value_split[i]
            });
        }
        return data_series;
    }



    // Heat map chart
    // --------------------------------------------------------------------
    const heatMapEl = document.querySelector('#pvcHeatMapChart'),
            pvcHeatMapChartConfig = {
                chart: {
                    height: 350,
                    fontFamily: 'IBM Plex Sans',
                    type: 'heatmap',
                    parentHeightOffset: 0,
                    toolbar: {
                        show: true
                    }
                },
                plotOptions: {
                    heatmap: {
                        enableShades: false,

                        colorScale: {
                            ranges: [
                                {
                                    from: 0,
                                    to: 200,
                                    name: '0-200',
                                    color: '#ff7c7d'
                                },
                                {
                                    from: 201,
                                    to: 400,
                                    name: '201-400',
                                    color: '#fdac41'
                                },
                                {
                                    from: 401,
                                    to: 600,
                                    name: '401-600',
                                    color: '#39da8a'
                                },
                                {
                                    from: 601,
                                    to: 800,
                                    name: '601-800',
                                    color: '#39da8a'
                                },
                                {
                                    from: 801,
                                    to: 1500,
                                    name: '801-1500',
                                    color: '#39da8a'
                                }
                            ]
                        }
                    }
                },
                dataLabels: {
                    enabled: true
                },
                grid: {
                    show: true
                },
                legend: {
                    show: true,
                    position: 'top',
                    horizontalAlign: 'start',
                    labels: {
                        colors: axisColor,
                        useSeriesColors: true
                    }
                },
                stroke: {
                    curve: 'smooth',
                    width: 5,
                    lineCap: 'round',
                    colors: [cardColor]
                },
                series: [
                    {
                        name: 'CNC',
                        data: buildDataSeries('cnc_date', 'cnc_value')
                    },
                    {
                        name: 'SAND/CLEAN',
                        data: buildDataSeries('sandclean_date', 'sandclean_value')
                    },
                    {
                        name: 'GLUE',
                        data: buildDataSeries('glue_date', 'glue_value')
                    },
                    {
                        name: 'VINYL PRESS',
                        data: buildDataSeries('vinylpress_date', 'vinylpress_value')
                    },
                ],
                xaxis: {
                    labels: {
                        show: true,
                        style: {
                            colors: axisColor,
                            fontSize: '13px'
                        }
                    },
                    axisBorder: {
                        show: true
                    },
                    axisTicks: {
                        show: true
                    }
                },
                yaxis: {
                    labels: {
                        style: {
                            colors: axisColor,
                            fontSize: '13px'
                        }
                    }
                }
            };
    if (typeof heatMapEl !== undefined && heatMapEl !== null) {
        const pvcHeatMapChart = new ApexCharts(heatMapEl, pvcHeatMapChartConfig);
        pvcHeatMapChart.render();
    }

})();
