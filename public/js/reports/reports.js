/**
* Created by cdimitzas on 16/3/2016.
*/
// -------------------------------------------------------------------------------------------------------- //
// -------- REPORT: Benefiters vs education (script) -------------------------------------------------------//
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
            // "groupPercent": 10,
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
            "outlineAlpha": 0.4,
            "depth3D": 15,
            "balloonText": "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>",
            "angle": 30,
            "fontSize": 16,
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


// -------------------------------------------------------------------------------------------------------- //
// -------- REPORT: Benefiters vs doctor type needed (script) ----------------------------------------------//
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


// -------------------------------------------------------------------------------------------------------- //
// -------- REPORT: Benefiters vs clinical condition type (script) -----------------------------------------//
var clinicalConditionsData = [];

function fetchClinicalConditionsDataReport() {
    $.ajax({
        url: $('body').attr('data-url') + "/benefites-VS-ClinicalConditions-Report-get-data",
        success: function (response) {
            clinicalConditionsData = response;
        }
    }).done(function () {
        var chart = AmCharts.makeChart( "benefiter_vs_clinical_conditions", {
            "type": "serial",
            "theme": "dark",
            "fontSize": 14,
            fontFamily: "Helvetica Neue",
            "dataProvider": clinicalConditionsData,
            "gridAboveGraphs": true,
            "startDuration": 1,
            "graphs": [ {
                "balloonText": "[[category]]: <b>[[value]]</b>",
                "fillAlphas": 0.8,
                "lineAlpha": 0.2,
                "type": "column",
                "valueField": "clinical_condition_count"
            } ],
            "chartCursor": {
                "categoryBalloonEnabled": false,
                "cursorAlpha": 0,
                "zoomable": false
            },
            "rotate": true,
            "categoryField": "clinical_condition_name",
            "categoryAxis": {
                "gridPosition": "start",
                "gridAlpha": 0,
                "tickPosition": "start",
                "tickLength": 20,
                "fontSize": 14
            },
            "valueAxes": [{
                "axisAlpha": 0,
                "position": "left",
                "title": "Αριθμός ωφελουμένων"
            }],
            "export": {
                "enabled": true
            }
        } );
    });
}
fetchClinicalConditionsDataReport();


// -------------------------------------------------------------------------------------------------------- //
// -------- REPORT: Number of visits per month (script) ----------------------------------------------------//
var medicalVisitsPerMonth = [];

function fetchmedicalVisitsPerMonthDataReport() {
    $.ajax({
        url: $('body').attr('data-url') + "/medical_visits-PER-month-Report-get-data",
        success: function (response) {
            medicalVisitsPerMonth = response;
        }
    }).done(function () {
        var chart = AmCharts.makeChart( "medical_visits_per_month", {

            type: "stock",
            "theme": "light",

            dataSets: [ {
                color: "#b0de09",
                fieldMappings: [ {
                    fromField: "visits_per_month",
                    toField: "visits_per_month"
                } ],
                dataProvider: medicalVisitsPerMonth,
                categoryField: "per_month_date"
            } ],

            panels: [ {
                showCategoryAxis: true,
                title: "Αριθμός Ιατρικών Επισκέψεων",
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
                    valueField: "visits_per_month",
                    useDataSetColors: false,
                    "bullet": "round"
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
    });
}
fetchmedicalVisitsPerMonthDataReport();


// -------------------------------------------------------------------------------------------------------- //
// -------- REPORT: Benefiters vs phycological support ---------------------------------------------------- //
var phycologicalSupportType = [];

function fetchBenefitersVSphycologicalSupportType(){
    $.ajax({
        url: $('body').attr('data-url') + "/benefites-VS-phycological-support-type",
        success: function (response) {
            phycologicalSupportType = response;
        }
    }).done(function () {
        var chart = AmCharts.makeChart( "benefiter_vs_phycological_support", {
            "type": "serial",
            "theme": "light",
            "dataProvider": phycologicalSupportType,
            "fontSize": 16,
            "valueAxes": [ {
                "gridColor": "#FFFFFF",
                "gridAlpha": 0.2,
                "dashLength": 0,
                //"fontSize": 16,
                "position": "left",
                "title": "Αριθμός ωφελουμένων"

            } ],
            "gridAboveGraphs": true,
            "startDuration": 1,
            "graphs": [ {
                "balloonText": "[[category]]: <b>[[value]]</b>",
                "fillAlphas": 0.8,
                "lineAlpha": 0.2,
                "type": "column",
                "valueField": "type_count"
            } ],
            "chartCursor": {
                "categoryBalloonEnabled": false,
                "cursorAlpha": 0,
                "zoomable": false
            },
            "rotate": true,
            "categoryField": "$phycological_support_type",
            "categoryAxis": {
                "gridPosition": "start",
                "gridAlpha": 0,
                "tickPosition": "start",
                "tickLength": 20,
                "fontSize": 16
            },
            "export": {
                "enabled": true
            }

        } );
    });
}
fetchBenefitersVSphycologicalSupportType();

// -------------------------------------------------------------------------------------------------------- //
// -------- REPORT: Registrations per month ---------------------------------------------------- //
var benefitersRegistrationsPerMonth = [];

function fetchBenefitersRegistrationsPerMonthDataReport() {
    $.ajax({
        url: $('body').attr('data-url') + "/registrations-PER-month-Report-get-data",
        success: function (response) {
            benefitersRegistrationsPerMonth = response;
        }
    }).done(function () {
        var chart = AmCharts.makeChart( "registrations_per_month", {

            type: "stock",
            "theme": "light",
            "fontSize": 16,
            dataSets: [ {
                color: "#b0de09",
                fieldMappings: [ {
                    fromField: "registrations_per_month",
                    toField: "registrations_per_month"
                } ],
                dataProvider: benefitersRegistrationsPerMonth,
                categoryField: "per_month_date"
            } ],

            panels: [ {
                showCategoryAxis: true,
                title: "Αριθμός Εγγραφών",
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
                    valueField: "registrations_per_month",
                    useDataSetColors: false,
                    "bullet": "round"
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
    });
}
fetchBenefitersRegistrationsPerMonthDataReport();
