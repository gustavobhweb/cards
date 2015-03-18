$(function(){
    /**
    * Ajax para buscar valores para gerar os gráficos
    */
    window.analiseTotal = 0;
    window.fabricacaoTotal = 0;
    window.expedidoTotal = 0;
    window.disponivelTotal = 0;
    window.entregueTotal = 0;
    window.reprovadaTotal = 0;

    $.ajax({
        url: '/cliente/ajax-data-graph',
        type: 'POST',
        dataType: 'json',
        success: function(response){
            console.log(response);
            showPieChart(response);
            showDxChart(response);
            setDataValues(response);
            $('.labelsCharts').fadeIn();
        },
        error: function(){
            alert('Problemas na conexão! Atualize a página e tente novamente.');
        }
    });
});

/**
* Mostra gráfico de pizza de status das solicitações
* Passar os valores inteiros como parâmetro
*/
function showPieChart(data)
{
    var pieChartDataSource = new Array();

    for (i in data) {
        if (data[i].status_atual == 1 || data[i].status_atual == 2) {
            analiseTotal += data[i].count;
            pieChartDataSource[0] = {
                category: 'Análise da foto', value: analiseTotal
            };
        } else if (data[i].status_atual == 3 || data[i].status_atual == 4 || data[i].status_atual == 9 || data[i].status_atual == 10) {
            fabricacaoTotal += data[i].count;
            pieChartDataSource[1] = {
                category: 'Fabricação', value: fabricacaoTotal
            };
        } else if (data[i].status_atual == 5) {
            expedidoTotal += data[i].count;
            pieChartDataSource[2] = {
                category: 'Expedido', value: expedidoTotal
            };
        } else if (data[i].status_atual == 6) {
            disponivelTotal += data[i].count;
            pieChartDataSource[3] = {
                category: 'Disponível para entrega', value: disponivelTotal
            };
        } else if (data[i].status_atual == 7) {
            entregueTotal += data[i].count;
            pieChartDataSource[4] = {
                category: 'Entregue', value: entregueTotal
            };
        } else if (data[i].status_atual == 8) {
            reprovadaTotal += data[i].count;
            pieChartDataSource[5] = {
                category: 'Foto reprovada', value: reprovadaTotal
            };
        }
    }

    $("#pieChartContainer").dxPieChart({
        dataSource: pieChartDataSource,
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

/**
* Mostra gráfico de barras de status das solicitações
* Passar os valores inteiros como parâmetro
*/
function showDxChart(data)
{
    var dataSource = [{ state: '' }];

    for (i in data) {
        if (data[i].status_atual == 1 || data[i].status_atual == 2) {
            dataSource[0].analise = analiseTotal;
        } else if (data[i].status_atual == 3 || data[i].status_atual == 4 || data[i].status_atual == 9 || data[i].status_atual == 10) {
            dataSource[0].fabricacao = fabricacaoTotal;
        } else if (data[i].status_atual == 5) {
            dataSource[0].expedido = expedidoTotal;
        } else if (data[i].status_atual == 6) {
            dataSource[0].disponivel = disponivelTotal;
        } else if (data[i].status_atual == 7) {
            dataSource[0].entregue = entregueTotal;
        } else if (data[i].status_atual == 8) {
            dataSource[0].reprovada = reprovadaTotal;
        }
    }

    $("#chartContainer").dxChart({
        dataSource: dataSource,
        commonSeriesSettings: {
            argumentField: 'state',
            type: 'bar',
            label: {
                visible: true,
                format: "fixedPoint",
                precision: 2
            }
        },
        series: [
            { valueField: 'analise', name: 'Análise da foto' },
            { valueField: 'fabricacao', name: 'Fabricação' },
            { valueField: 'expedido', name: 'Expedido' },
            { valueField: 'disponivel', name: 'Disponível para entrega' },
            { valueField: 'entregue', name: 'Entregue' },
            { valueField: 'reprovada', name: 'Foto reprovada' }
        ],
        legend: {
            verticalAlignment: 'bottom',
            horizontalAlignment: 'center'
        },
        palette: ['#75B5D6', '#4D7AFF', '#FF7373', '#063772', '#C4141B', '#C5C5C3']
    });
}

function setDataValues(data)
{
    $('#-analise').html('0');
    $('#-fabricacao').html('0');
    $('#-expedido').html('0');
    $('#-disponivel').html('0');
    $('#-entregue').html('0');
    $('#-reprovada').html('0');
    for (i in data) {
        if (data[i].status_atual == 1 || data[i].status_atual == 2) {
            $('#-analise').html(analiseTotal);
        } else if (data[i].status_atual == 3 || data[i].status_atual == 4 || data[i].status_atual == 9 || data[i].status_atual == 10) {
            $('#-fabricacao').html(fabricacaoTotal);
        } else if (data[i].status_atual == 5) {
            $('#-expedido').html(expedidoTotal);
        } else if (data[i].status_atual == 6) {
            $('#-disponivel').html(disponivelTotal);
        } else if (data[i].status_atual == 7) {
            $('#-entregue').html(entregueTotal);
        } else if (data[i].status_atual == 8) {
            $('#-reprovada').html(reprovadaTotal);
        }
    }
}