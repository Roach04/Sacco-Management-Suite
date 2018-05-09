/*global $, document*/
$(document).ready(function () {

    'use strict';


    // ------------------------------------------------------- //
    // Charts Gradients
    // ------------------------------------------------------ //
    var ctx1 = $("canvas").get(0).getContext("2d");
    var gradient1 = ctx1.createLinearGradient(150, 0, 150, 300);
    gradient1.addColorStop(0, 'rgba(133, 180, 242, 0.91)');
    gradient1.addColorStop(1, 'rgba(255, 119, 119, 0.94)');

    var gradient2 = ctx1.createLinearGradient(146.000, 0.000, 154.000, 300.000);
    gradient2.addColorStop(0, 'rgba(104, 179, 112, 0.85)');
    gradient2.addColorStop(1, 'rgba(76, 162, 205, 0.85)');

    $.ajax({

        url: "http://sacco.co.ke/sacco/json",
        method: 'GET',

    }).done(function(response) {

        var credit = [];

        var debit  = [];

        var labels = [];

        $.each(response.i, function(i, v) {

            //get the credit
            credit.push(v.credit);

            //get the created at
            //var creation = new Date(v.created_at).toDateString();
            //var creation = new Date(v.created_at).toISOString().slice(0,10);
            var creation = v.updated_at;

            labels.push(creation);

            //get the debit
            debit.push(v.debit);

            //display the year in the scale label.
            var year  = new Date(v.updated_at).toISOString().slice(0,4);

            //choose to step the size by a month.
            //var month = new Date(v.created_at).toLocaleFormat('%b');

            // ------------------------------------------------------- //
            // Line Chart CREDITS & DEBITS
            // ------------------------------------------------------ //
            var LINECHARTEXMPLE   = $('#lineChartExample');
            var lineChartExample = new Chart(LINECHARTEXMPLE, {
                type: 'line',
                options: {
                    legend: {labels:{fontColor:"#777", fontSize: 12}},
                    scales: {
                        xAxes: [{
                            display: true,
                            gridLines: {
                                color: '#eee'
                            },
                            type:'time',
                            time: {
                                unit: 'month',
                                stepSize: 1,
                                displayFormats: {
                                    day: 'MMM D'
                                },
                            },
                            scaleLabel: {
                                display: true,
                                labelString: "Year   "+ year,
                                fontColor: "#ff7676",
                                fontSize: 20
                            },                                                    
                        }],
                        yAxes: [{
                            display: true,
                            gridLines: {
                                color: '#eee'
                            },
                            scaleLabel: {
                                display: true,
                                labelString: "Moneys In KES",
                                fontColor: "#54e69d",
                                fontSize: 20
                            },
                            ticks: {
                                beginAtZero: true,
                                stepSize:100000
                            }
                        }]
                    },
                },
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: "Credits",
                            fill: true,
                            lineTension: 0.3,
                            backgroundColor: "#54e69d",
                            borderColor: "#54e69d",
                            borderCapStyle: 'butt',
                            borderDash: [],
                            borderDashOffset: 0.0,
                            borderJoinStyle: 'miter',
                            borderWidth: 1,
                            pointBorderColor: "#54e69d",
                            pointBackgroundColor: "#fff",
                            pointBorderWidth: 1,
                            pointHoverRadius: 5,
                            pointHoverBackgroundColor: "#54e69d",
                            pointHoverBorderColor: "rgba(220,220,220,1)",
                            pointHoverBorderWidth: 2,
                            pointRadius: 1,
                            pointHitRadius: 10,
                            data: credit,
                            spanGaps: false
                        },
                        {
                            label: "Debits",
                            fill: true,
                            lineTension: 0.3,
                            backgroundColor: "#ff7676",
                            borderColor: "#ff7676",
                            borderCapStyle: 'butt',
                            borderDash: [],
                            borderDashOffset: 0.0,
                            borderJoinStyle: 'miter',
                            borderWidth: 1,
                            pointBorderColor: "#ff7676",
                            pointBackgroundColor: "#fff",
                            pointBorderWidth: 1,
                            pointHoverRadius: 5,
                            pointHoverBackgroundColor: "#ff7676",
                            pointHoverBorderColor: "rgba(220,220,220,1)",
                            pointHoverBorderWidth: 2,
                            pointRadius: 1,
                            pointHitRadius: 10,
                            data: debit,
                            spanGaps: false
                        },
                    ]
                }
            });

            // ------------------------------------------------------- //
            // Line Chart 1 CREDITS
            // ------------------------------------------------------ //
            var LINECHART1 = $('#lineChartExample1');
            var myLineChart = new Chart(LINECHART1, {
                type: 'line',
                options: {
                    scales: {
                        xAxes: [{
                            display: true,
                            gridLines: {
                                display: false
                            },
                            type:'time',
                            time: {
                                unit: 'month',
                                stepSize: 1,
                                displayFormats: {
                                    day: 'MMM D'
                                },
                            },
                        }],
                        yAxes: [{
                            display: false,
                            gridLines: {
                                display: false
                            }
                        }]
                    },
                    legend: {
                        display: true
                    }
                },
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: "Money In",
                            fill: true,
                            lineTension: 0,
                            backgroundColor: "transparent",
                            borderColor: '#54e69d',
                            pointBorderColor: '#54e69d',
                            pointHoverBackgroundColor: '#54e69d',
                            borderCapStyle: 'butt',
                            borderDash: [],
                            borderDashOffset: 0.0,
                            borderJoinStyle: 'miter',
                            borderWidth: 3,
                            pointBackgroundColor: "#54e69d",
                            pointBorderWidth: 0,
                            pointHoverRadius: 4,
                            pointHoverBorderColor: "#fff",
                            pointHoverBorderWidth: 0,
                            pointRadius: 4,
                            pointHitRadius: 0,
                            data: credit,
                            spanGaps: false
                        }
                    ]
                }
            });


            // ------------------------------------------------------- //
            // Line Chart 2 => DEBITS
            // ------------------------------------------------------ //
            var LINECHART1 = $('#lineChartExample2');
            var myLineChart = new Chart(LINECHART1, {
                type: 'line',
                options: {
                    scales: {
                        xAxes: [{
                            display: true,
                            gridLines: {
                                display: false,
                                color: '#eee'
                            },
                            type:'time',
                            time: {
                                unit: 'month',
                                stepSize: 1,
                                displayFormats: {
                                    day: 'MMM D'
                                },
                            },
                        }],
                        yAxes: [{
                            display: false,
                            gridLines: {
                                display: false
                            }
                        }]
                    },
                    legend: {
                        display: true
                    }
                },
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: "Money Out",
                            fill: true,
                            lineTension: 0,
                            backgroundColor: "transparent",
                            borderColor: '#ff7676',
                            pointBorderColor: '#ff7676',
                            pointHoverBackgroundColor: '#ff7676',
                            borderCapStyle: 'butt',
                            borderDash: [],
                            borderDashOffset: 0.0,
                            borderJoinStyle: 'miter',
                            borderWidth: 3,
                            pointBackgroundColor: "#ff7676",
                            pointBorderWidth: 0,
                            pointHoverRadius: 4,
                            pointHoverBorderColor: "#fff",
                            pointHoverBorderWidth: 0,
                            pointRadius: 4,
                            pointHitRadius: 0,
                            data: debit,
                            spanGaps: false
                        }
                    ]
                }
            });
        });        
    });

    var pieChartExample = {
        responsive: true
    };


    // ------------------------------------------------------- //
    // Pie Chart
    // ------------------------------------------------------ //
    var PIECHARTEXMPLE    = $('#pieChartExample');
    var pieChartExample = new Chart(PIECHARTEXMPLE, {
        type: 'pie',
        data: {
            labels: [
                "A",
                "B",
                "C",
                "D"
            ],
            datasets: [
                {
                    data: [300, 50, 100, 80],
                    borderWidth: 0,
                    backgroundColor: [
                        '#44b2d7',
                        "#59c2e6",
                        "#71d1f2",
                        "#96e5ff"
                    ],
                    hoverBackgroundColor: [
                        '#44b2d7',
                        "#59c2e6",
                        "#71d1f2",
                        "#96e5ff"
                    ]
                }]
            }
    });

    var pieChartExample = {
        responsive: true
    };

    $.ajax({

        url   : "http://sacco.co.ke/loans/json",
        method: 'GET',
    }).done(function(msg) {

        var labels = [];
        var loans  = [];

        //loop thru the database records.
        $.each(msg.laravel, function(laravel, lara) {

            //get the date the loan was created.
            var create = lara.created_at;

            //push the data above to our chart.
            labels.push(create);

            //grab the loan
            var linna = lara.loan;

            var year  = new Date(lara.created_at).toISOString().slice(0,4);

            //push the loan to the chart.
            loans.push(linna);

            // ------------------------------------------------------- //
            // Line Chart 3 => LOANS
            // ------------------------------------------------------ //
            var LINECHART3 = $('#lineChartLoans');
            var myLineChart = new Chart(LINECHART3, {
                type: 'line',
                options: {
                    scales: {
                        xAxes: [{
                            display: true,
                            gridLines: {
                                display: false,
                                color: '#eee'
                            },
                            type:'time',
                            time: {
                                unit: 'month',
                                stepSize: 1,
                                displayFormats: {
                                    day: 'MMM D'
                                },
                            },
                            scaleLabel: {
                                display: true,
                                labelString: "Year   "+ year,
                                fontColor: "#ffc36d",
                                fontSize: 20
                            }
                        }],
                        yAxes: [{
                            display: true,
                            gridLines: {
                                display: false
                            }, 
                            scaleLabel: {
                                display: true,
                                labelString: "Loans in Kes",
                                fontColor: "#ffc36d",
                                fontSize: 20
                            },                          
                            ticks: {
                                beginAtZero: true,
                                stepSize: 500000
                            },
                        }]
                    },
                    legend: {
                        display: true
                    }
                },
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: "Loan",
                            fill: true,
                            lineTension: 0,
                            backgroundColor: "transparent",
                            borderColor: '#ffc36d',
                            pointBorderColor: '#ffc36d',
                            pointHoverBackgroundColor: '#ffc36d',
                            borderCapStyle: 'butt',
                            borderDash: [],
                            borderDashOffset: 0.0,
                            borderJoinStyle: 'miter',
                            borderWidth: 3,
                            pointBackgroundColor: "#ffc36d",
                            pointBorderWidth: 0,
                            pointHoverRadius: 4,
                            pointHoverBorderColor: "#fff",
                            pointHoverBorderWidth: 0,
                            pointRadius: 4,
                            pointHitRadius: 0,
                            data: loans,
                            spanGaps: false
                        }
                    ]
                }
            });

            // ------------------------------------------------------- //
            // Doughnut Chart
            // ------------------------------------------------------ //
            var DOUGHNUTCHARTEXMPLE  = $('#doughnutChartExample');
            var pieChartExample = new Chart(DOUGHNUTCHARTEXMPLE, {
                type: 'doughnut',
                options: {
                    cutoutPercentage: 70,
                },
                data: {
                    labels: labels,
                    datasets: [
                        {
                            data: loans,
                            borderWidth: 0,
                            backgroundColor: [
                                '#3eb579',
                                '#49cd8b',
                                "#54e69d",
                                "#71e9ad"
                            ],
                            hoverBackgroundColor: [
                                '#3eb579',
                                '#49cd8b',
                                "#54e69d",
                                "#71e9ad"
                            ]
                        }]
                    }
            });
        });
    });


    // ------------------------------------------------------- //
    // Bar Chart 1
    // ------------------------------------------------------ //
    var BARCHART1 = $('#barChart1');
    var barChartHome = new Chart(BARCHART1, {
        type: 'bar',
        options:
        {
            scales:
            {
                xAxes: [{
                    display: false
                }],
                yAxes: [{
                    display: false
                }],
            },
            legend: {
                display: false
            }
        },
        data: {
            labels: ["A", "B", "C", "D", "E", "F", "G", "H"],
            datasets: [
                {
                    label: "Data Set 1",
                    backgroundColor: [
                        '#44b2d7',
                        '#44b2d7',
                        '#44b2d7',
                        '#44b2d7',
                        '#44b2d7',
                        '#44b2d7',
                        '#44b2d7',
                        '#44b2d7'
                    ],
                    borderColor: [
                        '#44b2d7',
                        '#44b2d7',
                        '#44b2d7',
                        '#44b2d7',
                        '#44b2d7',
                        '#44b2d7',
                        '#44b2d7',
                        '#44b2d7'
                    ],
                    borderWidth: 0,
                    data: [35, 55, 65, 85, 30, 22, 18, 35]
                },
                {
                    label: "Data Set 1",
                    backgroundColor: [
                        '#59c2e6',
                        '#59c2e6',
                        '#59c2e6',
                        '#59c2e6',
                        '#59c2e6',
                        '#59c2e6',
                        '#59c2e6',
                        '#59c2e6'
                    ],
                    borderColor: [
                        '#59c2e6',
                        '#59c2e6',
                        '#59c2e6',
                        '#59c2e6',
                        '#59c2e6',
                        '#59c2e6',
                        '#59c2e6',
                        '#59c2e6'
                    ],
                    borderWidth: 0,
                    data: [49, 68, 85, 40, 27, 35, 20, 25]
                }
            ]
        }
    });


    // ------------------------------------------------------- //
    // Bar Chart 2
    // ------------------------------------------------------ //
    var BARCHART2 = $('#barChart2');
    var barChartHome = new Chart(BARCHART2, {
        type: 'bar',
        options:
        {
            scales:
            {
                xAxes: [{
                    display: false
                }],
                yAxes: [{
                    display: false
                }],
            },
            legend: {
                display: false
            }
        },
        data: {
            labels: ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O"],
            datasets: [
                {
                    label: "Data Set 1",
                    backgroundColor: [
                        '#54e69d',
                        '#54e69d',
                        '#54e69d',
                        '#54e69d',
                        '#54e69d',
                        '#54e69d',
                        '#54e69d',
                        '#54e69d',
                        '#54e69d',
                        '#54e69d',
                        '#54e69d',
                        '#54e69d',
                        '#54e69d',
                        '#54e69d',
                        '#54e69d'
                    ],
                    borderColor: [
                        '#54e69d',
                        '#54e69d',
                        '#54e69d',
                        '#54e69d',
                        '#54e69d',
                        '#54e69d',
                        '#54e69d',
                        '#54e69d',
                        '#54e69d',
                        '#54e69d',
                        '#54e69d',
                        '#54e69d',
                        '#54e69d',
                        '#54e69d',
                        '#54e69d'
                    ],
                    borderWidth: 1,
                    data: [40, 33, 22, 28, 40, 25, 30, 40, 28, 27, 22, 15, 20, 24, 30]
                }
            ]
        }
    });


    // ------------------------------------------------------- //
    // Polar Chart
    // ------------------------------------------------------ //
    var POLARCHARTEXMPLE  = $('#polarChartExample');
    var polarChartExample = new Chart(POLARCHARTEXMPLE, {
        type: 'polarArea',
        options: {
            elements: {
                arc: {
                    borderWidth: 0,
                    borderColor: '#aaa'
                }
            }
        },
        data: {
            datasets: [{
                data: [
                    11,
                    16,
                    12,
                    11,
                    7
                ],
                backgroundColor: [
                    "#e05f5f",
                    "#e96a6a",
                    "#ff7676",
                    "#ff8b8b",
                    "#fc9d9d"
                ],
                label: 'My dataset' // for legend
            }],
            labels: [
                "A",
                "B",
                "C",
                "D",
                "E"
            ]
        }
    });

    var polarChartExample = {
        responsive: true
    };


    // ------------------------------------------------------- //
    // Radar Chart
    // ------------------------------------------------------ //
    var RADARCHARTEXMPLE  = $('#radarChartExample');
    var radarChartExample = new Chart(RADARCHARTEXMPLE, {
        type: 'radar',
        data: {
            labels: ["A", "B", "C", "D", "E", "C"],
            datasets: [
                {
                    label: "First dataset",
                    backgroundColor: "rgba(84, 230, 157, 0.4)",
                    borderWidth: 2,
                    borderColor: "rgba(75, 204, 140, 1)",
                    pointBackgroundColor: "rgba(75, 204, 140, 1)",
                    pointBorderColor: "#fff",
                    pointHoverBackgroundColor: "#fff",
                    pointHoverBorderColor: "rgba(75, 204, 140, 1)",
                    data: [65, 59, 90, 81, 56, 55]
                },
                {
                    label: "Second dataset",
                    backgroundColor: "rgba(255, 119, 119, 0.4)",
                    borderWidth: 2,
                    borderColor: "rgba(255, 119, 119, 1)",
                    pointBackgroundColor: "rgba(255, 119, 119, 1)",
                    pointBorderColor: "#fff",
                    pointHoverBackgroundColor: "#fff",
                    pointHoverBorderColor: "rgba(255, 119, 119, 1)",
                    data: [50, 60, 80, 45, 96, 70]
                }
            ]
        }
    });
    var radarChartExample = {
        responsive: true
    };
});
