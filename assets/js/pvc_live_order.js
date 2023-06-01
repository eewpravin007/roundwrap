/**
 * Analytics Dashboard
 */

'use strict';

(function () {
    let cardColor, headingColor, axisColor, borderColor, shadeColor;
    let pvc_order_count = [];

//    var pvc_chart_values = document.getElementById("pvc_chart_values").value;

    if (isDarkStyle) {
        cardColor = config.colors_dark.cardColor;
        headingColor = config.colors_dark.headingColor;
        axisColor = config.colors_dark.axisColor;
        borderColor = config.colors_dark.borderColor;
        shadeColor = 'dark';
    } else {
        cardColor = config.colors.white;
        headingColor = config.colors.headingColor;
        axisColor = config.colors.axisColor;
        borderColor = config.colors.borderColor;
        shadeColor = 'light';
    }

    var document_pvc_chart_values = document.getElementById("pvc_chart_values");
    if (document_pvc_chart_values !== undefined && document_pvc_chart_values !== null) {
        var pvc_chart_values_split = document_pvc_chart_values.value.split(",");
        pvc_order_count.push(pvc_chart_values_split[0]);
        pvc_order_count.push(pvc_chart_values_split[1]);
        pvc_order_count.push(pvc_chart_values_split[2]);
        pvc_order_count.push(pvc_chart_values_split[3]);
        pvc_order_count.push(pvc_chart_values_split[4]);
    }
 
    // Radial bar chart functions
    function radialBarChart(color, value) {
        const radialBarChartOpt = {
            chart: {
                height: 50,
                width: 50,
                type: 'radialBar'
            },
            plotOptions: {
                radialBar: {
                    hollow: {
                        size: '25%'
                    },
                    dataLabels: {
                        show: false
                    },
                    track: {
                        background: borderColor
                    }
                }
            },
            stroke: {
                lineCap: 'round'
            },
            colors: [color],
            grid: {
                padding: {
                    top: -8,
                    bottom: -10,
                    left: -5,
                    right: 0
                }
            },
            series: [value],
            labels: ['Progress']
        };
        return radialBarChartOpt;
    }

    const ReportchartList = document.querySelectorAll('.chart-report');
    if (ReportchartList) {
        ReportchartList.forEach(function (ReportchartEl) {
            const color = config.colors[ReportchartEl.dataset.color],
                    series = ReportchartEl.dataset.series;
            const optionsBundle = radialBarChart(color, series);
            const reportChart = new ApexCharts(ReportchartEl, optionsBundle);
            reportChart.render();
        });
    }

    // Analytics - Bar Chart
    // --------------------------------------------------------------------
    const pvcBarChartEl = document.querySelector('#pvcBarChart'),
            pvcBarChartConfig = {
                chart: {
                    height: 250,
                    type: 'bar',
                    toolbar: {
                        show: true
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '40%',
                        borderRadius: 5,
                        startingShape: 'rounded'
                    }
                },
                dataLabels: {
                    enabled: true
                },
                colors: [config.colors.primary, config.colors_label.primary],
                series: [
                    {
                        name: '25-09-2022',
                        data: pvc_order_count
                    }
                ],
                grid: {
                    borderColor: borderColor,
                    padding: {
                        bottom: -8
                    }
                },
                xaxis: {
                    categories: ['CNC', 'SAND/CLEAN', 'GLUE', 'VINYL PRESS', 'PRODUCTION OUT'],
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: true
                    },
                    labels: {
                        style: {
                            colors: axisColor
                        }
                    }
                },
                yaxis: {
                    min: 0,
                    max: 900,
                    tickAmount: 3,
                    labels: {
                        style: {
                            colors: axisColor
                        }
                    }
                },
                legend: {
                    show: true
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return ' ' + val + ' doors';
                        }
                    }
                }
            };

    if (typeof pvcBarChartEl !== undefined && pvcBarChartEl !== null) {
        const pvcBarChart = new ApexCharts(pvcBarChartEl, pvcBarChartConfig);
        pvcBarChart.render();
    }


})();
