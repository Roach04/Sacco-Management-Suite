/*global $, document, Chart, LINECHART, data, options, window*/
$(document).ready(function () {

    'use strict';

    var legendState = true;
    if ($(window).outerWidth() < 576) {
        legendState = false;
    }

    /**
    ** Ajax to display members
    **/
    $.ajax({

        url: "http://sacco.co.ke/members/json",
        method: 'GET',
    }).done(function(msg) {

        //get the response.
        var response = msg['laravel'];

        //declare empty arrays for our charts.
        var labels  = [];

        var account = [];

        var number  = [];

        $.each(msg.laravel, function(laravel, lara) {

            //get the date to which the records were updated.
            var records = lara.created_at;

            //the same created at are used as labels in this case.
            labels.push(records);

            //get the ids of the records residing in our database.
            //push the ids into our chart.
            if (records == records) {

                number.push(lara.id);
            };

            //get the year in which the data was updated.
            var year = new Date(lara.updated_at).toISOString().slice(0,4);

            // ------------------------------------------------------- //
            // Line Chart
            // ------------------------------------------------------ //
            var LINECHART = $('#lineChartMemberRegistration');
            var myLineChart = new Chart(LINECHART, {
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
                                stepSize: 0,
                                displayFormats: {
                                    day: 'MMM D'
                                },
                            },
                            scaleLabel: {
                                display: true,
                                labelString: "Year   "+ year,
                                fontColor: "#796AEE",
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
                                labelString: "No Of Members",
                                fontColor: "#796AEE",
                                fontSize: 20
                            },                            
                            ticks: {
                                beginAtZero: true,
                                stepSize: 2
                            }
                        }]
                    },
                    legend: {
                        display: legendState
                    }
                },
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: "Member Registration",
                            fill: true,
                            lineTension: 0,
                            backgroundColor: "transparent",
                            borderColor: "#796AEE",
                            pointHoverBackgroundColor: "#796AEE",
                            borderCapStyle: 'butt',
                            borderDash: [],
                            borderDashOffset: 0.0,
                            borderJoinStyle: 'miter',
                            borderWidth: 1,
                            pointBorderColor: "#796AEE",
                            pointBackgroundColor: "#fff",
                            pointBorderWidth: 1,
                            pointHoverRadius: 5,
                            pointHoverBorderColor: "#fff",
                            pointHoverBorderWidth: 2,
                            pointRadius: 1,
                            pointHitRadius: 10,
                            data: number,
                            spanGaps: false
                        }
                    ]
                }
            });
        });
    });

    /**
    ** Ajax to display member deposits.
    **/
    $.ajax({

        url   : "http://sacco.co.ke/members/json",
        method: 'GET'
    }).done(function(msg) {

        //create the chart container.
        var labels = [];
        var moneys = [];

        //get the percentage of members that are active.
        var percentage = msg['percentage'] + ' %';

        console.log('percentage');

        //populate the percentage to the view.
        $('#percentage').html(percentage);

        //loop thru data from laraval.
        $.each(msg.accounts, function(accounts, account) {

            //get the time each record was created.
            var create = account.created_at;

            //push the timelines above to our chart.
            labels.push(create);

            //equally push through the money to our chart.
            moneys.push(account.money);           

            // ------------------------------------------------------- //
            // Bar Chart
            // ------------------------------------------------------ //
            var BARCHARTHOME = $('#barChartMemberDeposits');
            var barChartHome = new Chart(BARCHARTHOME, {
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
                    labels: labels,
                    datasets: [
                        {
                            label: "Deposit",
                            backgroundColor: '#796AEE',
                            borderColor: '#796AEE',
                            borderWidth: 1,
                            data: moneys
                        }
                    ]
                }
            });
        });
    });
});

$(document).ready(function() {

    console.log('Charts Home is Operational.');
});