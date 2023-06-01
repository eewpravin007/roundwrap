/**
 * Charts Apex
 */

'use strict';

(function () {
    let cardColor, headingColor, axisColor, borderColor, radialTrackColor;

    function buildDataSeries(dcmnt) {
        let data_series = [];
        var data_date = document.getElementById(dcmnt).value;
        var data_date_split = data_date.split(",");
        for (var i = 0; i < data_date_split.length; i++) {
            if (data_date_split[i] !== "") {

                data_series.push(data_date_split[i]);
            }
        }
        return data_series;
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

    // Heat chart data generator


    // Line Chart
    // --------------------------------------------------------------------
    const lineChartEl = document.querySelector('#lineChart'),
            lineChartConfig = {
                chart: {
                    height: 400,
                    fontFamily: 'IBM Plex Sans',
                    type: 'line',
                    parentHeightOffset: 0,
                    zoom: {
                        enabled: false
                    },
                    toolbar: {
                        show: false
                    }
                },
                series: [
                    {
                        data: buildDataSeries("count")
                    }
                ],
                markers: {
                    strokeWidth: 7,
                    strokeOpacity: 1,
                    //strokeColors: [config.colors.white],
                    //colors: [config.colors.warning]
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'straight'
                },
                //colors: [config.colors.warning],
                grid: {
                    borderColor: borderColor,
                    xaxis: {
                        lines: {
                            show: true
                        }
                    },
                    padding: {
                        top: -20
                    }
                },
                tooltip: {
                    custom: function ( { series, seriesIndex, dataPointIndex, w }) {
                        return '<div class="px-3 py-2">' + '<span>' + series[seriesIndex][dataPointIndex] + '</span>' + '</div>';
                    }
                },
                xaxis: {
                    categories: buildDataSeries("dates"),
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    },
                    labels: {
                        style: {
                            colors: axisColor,
                            fontSize: '11px'
                        }
                    }
                },
                yaxis: {
                    labels: {
                        style: {
                            colors: axisColor,
                            fontSize: '11px'
                        }
                    }
                }
            };
    if (typeof lineChartEl !== undefined && lineChartEl !== null) {
        const lineChart = new ApexCharts(lineChartEl, lineChartConfig);
        lineChart.render();
    }

})();
