var ctx = document.getElementById('appOverviewChart').getContext('2d');
var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'line',

    // The data for our dataset
    data: {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
        datasets: [{
            label: 'Approved Apps.',
            backgroundColor: 'rgb(26,246,40)',
            borderColor: 'rgb(26,246,40)',
            data: [0, 10, 5, 2, 20, 30, 45],
            fill: false
        },
            {
                label: 'Denied Apps.',
                backgroundColor: 'rgb(247, 43, 43)',
                borderColor: 'rgb(247, 43, 43)',
                data: [0, 10, 20, 0, 20, 14, 10],
                fill: false
            }]
    },

    // Configuration options go here
    options: {
        elements: {
            point:{
                radius: 0
            }
        },
        scales: {
            xAxes: [{
                gridLines: {
                    display:false
                }
            }],
            yAxes: [{
                gridLines: {
                    display:false
                }
            }]
        }
    }
});
