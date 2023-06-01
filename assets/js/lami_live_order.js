
'use strict';
(function () {
    let cardColor, headingColor, axisColor, borderColor, shadeColor;
    let lmi_order_count = [];
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
    
    var document_lmi_chart_values = document.getElementById("lmi_chart_values");
    if (document_lmi_chart_values !== undefined && document_lmi_chart_values !== null) {
        var lmi_chart_values_split = document_lmi_chart_values.value.split(",");
        lmi_order_count.push(lmi_chart_values_split[0]);
        lmi_order_count.push(lmi_chart_values_split[1]);
        lmi_order_count.push(lmi_chart_values_split[2]);
        lmi_order_count.push(lmi_chart_values_split[3]);
        lmi_order_count.push(lmi_chart_values_split[4]);
    }

    // Report Chart
    // --------------------------------------------------------------------

    // Radial bar chart functions
    // Analytics - Bar Chart
    // --------------------------------------------------------------------
    const laminateBarChartEl = document.querySelector('#laminateBarChart'),
            laminateBarChartConfig = {
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
                        data: lmi_order_count
                    }
                ],
                grid: {
                    borderColor: borderColor,
                    padding: {
                        bottom: -8
                    }
                },
                xaxis: {
                    categories: ['LAMI PRESS', 'SAW/DOOR', 'EDGE BANDING', 'LAMI CLEAN/PACK', 'PRODUCTION OUT'],
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
    if (typeof laminateBarChartEl !== undefined && laminateBarChartEl !== null) {
        const laminateBarChart = new ApexCharts(laminateBarChartEl, laminateBarChartConfig);
        laminateBarChart.render();
    }

})();
