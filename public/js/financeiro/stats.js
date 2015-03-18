$(function(){
    //pie();
    chart();
});

function chart()
{
    $.ajax({
        url: '/financeiro/source',
        type: 'GET',
        dataType: 'json',
        success: function(response)
        {
            $("#chartContainer").dxChart({
                dataSource: response,
                tooltip: {
                    enabled: true,
                    format: 'currency'
                },
                series: [
                    {
                        type: 'bar',
                        argumentField: "day",
                        valueField: "value",
                        name: "Meus gastos",
                        color: '#777'
                    },
                    {
                        type: 'line',
                        argumentField: "day",
                        valueField: "value",
                        name: "Meus gastos",
                        color: '#0965AF'
                    },
                ]
            });
        },
        error: function()
        {
            console.error('Problemas na conexão!');
        }
    });
}

function pie()
{
    $("#pieChartContainer").dxPieChart({
        dataSource: [1,1,1,1],
        series: {
            argumentField: 'category',
            valueField: 'value',
            type: 'doughnut',
            label: { visible: true }
        },
        palette: ['#75B5D6', '#4D7AFF', '#FF7373', '#063772', '#C4141B', '#C5C5C3'],
        legend: {
            verticalAlignment: 'bottom',
            horizontalAlignment: 'center'
        },
    });
}