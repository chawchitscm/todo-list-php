$(function(){
    $.ajax({
        url : './services/finish_todo.php',
        type : 'GET',
        success : function(data){
            var finished_date = [];
            var finished_todos = [];
            data = JSON.parse(data);
            for (var i in data) {
                finished_date.push(data[i].finished_date);
                finished_todos.push(data[i].finished_todos);
            }

            var chartdata = {
                labels : finished_date,
                datasets : [{
                    label : 'Finished To Dos Count',
                    fill : false,
                    lineTension : 0.1,
                    backgroundColor : '#49e2ff',
                    borderColor : '#46d5f1',
                    pointHoverBackgroundColor : '#CCCCCC',
                    pointHoverBorderColor : '#666666',
                    data : finished_todos    
                }]
            };
            var canvas = $('#linegraph');
            var LineGraph = new Chart(canvas, {
                type: 'line',
                data: chartdata
            });
        }
    });
});