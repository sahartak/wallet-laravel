Highcharts.chart('container', {
    chart: {
        type: 'spline'
    },
    title: {
        text: 'Monthly transaction chart'
    },
    subtitle: {
        text: ''
    },
    xAxis: {
        categories: dates
    },
    yAxis: {
        title: {
            text: 'Amount'
        }
    },
    plotOptions: {
        line: {
            dataLabels: {
                enabled: true
            },
            enableMouseTracking: false
        }
    },
    series: [{
        name: 'Income',
        data: income
    }, {
        name: 'Expenses',
        data: expense
    }]
});