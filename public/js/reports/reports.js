/**
* Created by cdimitzas on 16/3/2016.
*/

// -------- REPORT: Benefiters vs education (script) --------------------------------------------//
var educationData = [];

function fetchEducationDataReport(){
    $.ajax({
        url: $('body').attr('data-url') + "/benefites-VS-education-Report-get-data",
        success:function(response){
            educationData = response;
        }
    }).done(function(){
        var chart = AmCharts.makeChart("benefiter_vs_education", {
            "type": "pie",
            "startDuration": 0,
            "theme": "light",
            "addClassNames": true,
            "legend":{
                "position":"right",
                "marginRight":100,
                "autoMargins":false,
                "fontSize": 16
            },
            "innerRadius": "30%",
            "defs": {
                "filter": [{
                    "id": "shadow",
                    "width": "200%",
                    "height": "200%",
                    "feOffset": {
                        "result": "offOut",
                        "in": "SourceAlpha",
                        "dx": 0,
                        "dy": 0
                    },
                    "feGaussianBlur": {
                        "result": "blurOut",
                        "in": "offOut",
                        "stdDeviation": 5
                    },
                    "feBlend": {
                        "in": "SourceGraphic",
                        "in2": "blurOut",
                        "mode": "normal"
                    }
                }]
            },
            "dataProvider":educationData,
            "valueField": "benefiters_count_with_this_education_title",
            "titleField": "education_title",
            "export": {
                "enabled": true
            }
        });

        chart.addListener("init", handleInit);

        chart.addListener("rollOverSlice", function(e) {
            handleRollOver(e);
        });

        function handleInit(){
            chart.legend.addListener("rollOverItem", handleRollOver);
        }

        function handleRollOver(e){
            var wedge = e.dataItem.wedge.node;
            wedge.parentNode.appendChild(wedge);
        }
    });
}
fetchEducationDataReport();

// -------- END REPORT: Benefiters vs education (script) -------------------------------------------//


// ------------------------------------------------------------------------------------------------ //


// -------- REPORT: Benefiters vs doctor type needed (script) --------------------------------------//
var doctorData = [];

function fetchPerDoctorDataReport(){
    $.ajax({
        url: $('body').attr('data-url') + "/benefites-VS-doctor-Report-get-data",
        success:function(response){
            doctorData = response;
        }
    }).done(function(){
        var chart = AmCharts.makeChart("benefiter_vs_doctor_type", {
            "type": "serial",
            "theme": "light",
            "fontSize": 20,
            "fontFamily": "Arial",
            "marginRight": 70,
            "dataProvider": doctorData,
            "valueAxes": [{
                "axisAlpha": 0,
                "position": "left",
                //"title": Lang.get('reports.benefiters-Vs-doctors-tile'),
                "title": Lang.get('reports.benefiters-Vs-doctors-tile'),
                "fontSize": 16
            }],
            "startDuration": 1,
            "graphs": [{
                "balloonText": "<b>[[category]]: [[value]]</b>",
                "fillColorsField": "color",
                "fillAlphas": 0.9,
                "lineAlpha": 0.2,
                "type": "column",
                "valueField": "count_benefiters_with_same_doctor"
            }],
            "chartCursor": {
                "categoryBalloonEnabled": false,
                "cursorAlpha": 0,
                "zoomable": false
            },
            "categoryField": "doctor",
            "categoryAxis": {
                "gridPosition": "start",
                "labelRotation": 0,
                "fontSize": 16
            },
            "export": {
                "enabled": true
            }

        });
    });
}
fetchPerDoctorDataReport();
// -------- END REPORT: Benefiters vs doctor type needed (script) --------------------------------------//


// ---------------------------------------------------------------------------------------------------- //



// -------- REPORT: Benefiters vs clinical condition type (script) -------------------------------------//
var clinicalConditionsData = [];

function fetchClinicalConditionsDataReport() {
    $.ajax({
        url: $('body').attr('data-url') + "/benefites-VS-ClinicalConditions-Report-get-data",
        success: function (response) {
            clinicalConditionsData = response;
        }
    }).done(function () {
        var chart = AmCharts.makeChart( "benefiter_vs_clinical_conditions", {
            "type": "radar",
            "theme": "none",
            "fontSize": 8,
            "dataProvider": clinicalConditionsData,
            "valueAxes": [ {
                "axisTitleOffset": 20,
                "minimum": 0,
                "axisAlpha": 0.15
            } ],
            "startDuration": 2,
            "graphs": [ {
                "balloonText": "[[value]] ωφελούμενοι",
                "bullet": "round",
                "valueField": "clinical_condition_count"
            } ],
            "categoryField": "clinical_condition_name",
            "export": {
                "enabled": true
            }
        } );
    });
}
fetchClinicalConditionsDataReport();

// -------- END REPORT: Benefiters vs clinical condition type (script) -------------------------------------//



// -------------------------------------------------------------------------------------------------------- //



// -------- REPORT: Number of visits per month (script) ----------------------------------------------------//

var chartData = generateChartData();

function generateChartData() {
    var chartData = [];
    var firstDate = new Date( 2012, 0, 1 );
    firstDate.setDate( firstDate.getDate() - 500 );
    firstDate.setHours( 0, 0, 0, 0 );

    for ( var i = 0; i < 500; i++ ) {
        var newDate = new Date( firstDate );
        newDate.setDate( newDate.getDate() + i );

        var value = Math.round( Math.random() * ( 40 + i ) ) + 100 + i;

        chartData.push( {
            date: newDate,
            value: value
        } );
    }
    console.log(chartData);
    return chartData;
}


var chart = AmCharts.makeChart( "medical_visits_per_month", {

    type: "stock",
    "theme": "light",

    dataSets: [ {
        color: "#b0de09",
        fieldMappings: [ {
            fromField: "value",
            toField: "value"
        } ],
        dataProvider: chartData,
        categoryField: "date"
    } ],

    panels: [ {
        showCategoryAxis: true,
        title: "Value",
        eraseAll: false,
        allLabels: [ {
            x: 0,
            y: 115,
            //text: "Click on the pencil icon on top-right to start drawing",
            text: "",
            align: "center",
            size: 16
        } ],

        stockGraphs: [ {
            id: "g1",
            valueField: "value",
            useDataSetColors: false
        } ],


        stockLegend: {
            valueTextRegular: " ",
            markerType: "none"
        },

        drawingIconsEnabled: true
    } ],

    chartScrollbarSettings: {
        graph: "g1"
    },
    chartCursorSettings: {
        valueBalloonsEnabled: true
    },
    periodSelector: {
        position: "bottom",
        periods: [ {
            period: "DD",
            count: 10,
            label: "10 days"
        }, {
            period: "MM",
            count: 1,
            label: "1 month"
        }, {
            period: "YYYY",
            count: 1,
            label: "1 year"
        }, {
            period: "MAX",
            label: "MAX"
        } ]
    }
} );

// -------- END REPORT: Number of visits per month (script) ----------------------------------------------------//
