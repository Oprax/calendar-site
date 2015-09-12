(function($) {
    $charts = $('#charts');

    for (var i = 0; i < monthly.categories.length; i++) {
        monthly.categories[i] = months[monthly.categories[i] - 1];
    }

    $charts.append('<div id="monthly"></div>');
    $monthly = $('#monthly');

    $monthly.css('margin', '0 auto');
    $monthly.css('min-width', '310px');
    $monthly.css('width', '100%');
    $monthly.css('height', '400px');
    $monthly.highcharts({
        title: { 
            text: year,
            x: -20
        },
        xAxis: {
            categories: monthly.categories
        },
        yAxis: {
            title: {
                text: 'Pourcent (%)'
            },
            min: 0,
            max: 100,
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: '%'
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
        series: [{
            name: year,
            data: monthly.data
        }]
    });

    for(var index in daily)
    {
        console.log(daily[index]);

        var month = months[index - 1];

        $charts.append('<div id="' + index + '"></div>');
        $month = $('#' + index);

        $month.css('margin', '0 auto');
        $month.css('min-width', '310px');
        $month.css('width', '100%');
        $month.css('height', '400px');
        $month.highcharts({
            title: { 
                text: month,
                x: -20
            },
            xAxis: {
                categories: daily[index].categories
            },
            yAxis: {
                title: {
                    text: 'Pourcent (%)'
                },
                min: 0,
                max: 100,
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                valueSuffix: '%'
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                borderWidth: 0
            },
            series: [{
                name: month,
                data: daily[index].data
            }]
        });
    }

})(jQuery);