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
var chart = AmCharts.makeChart("benefiter_vs_doctor_type", {
    "type": "serial",
    "theme": "light",
    "fontSize": 16,
    "fontFamily": "Helvetica Neue",
    "marginRight": 70,
    "dataProvider": [
            {
            "country": "USA",
            "visits": 3025,
            //"color": "#FF0F00"
        }, {
            "country": "China",
            "visits": 1882,
            //"color": "#FF6600"
        }, {
            "country": "Japan",
            "visits": 1809,
            //"color": "#FF9E01"
        }, {
            "country": "Germany",
            "visits": 1322,
            //"color": "#FCD202"
        }, {
            "country": "UK",
            "visits": 1122,
            //"color": "#F8FF01"
        }, {
            "country": "France",
            "visits": 1114,
            //"color": "#B0DE09"
        }, {
            "country": "India",
            "visits": 984,
            //"color": "#04D215"
        }, {
            "country": "Spain",
            "visits": 711,
            //"color": "#0D8ECF"
        }, {
            "country": "Netherlands",
            "visits": 665,
            //"color": "#0D52D1"
        }, {
            "country": "Russia",
            "visits": 580,
            //"color": "#2A0CD0"
        }, {
            "country": "South Korea",
            "visits": 443,
            //"color": "#8A0CCF"
        }, {
            "country": "Canada",
            "visits": 441,
            //"color": "#CD0D74"
        }
    ],
    "valueAxes": [{
        "axisAlpha": 0,
        "position": "left",
        "title": "Visitors from country",
        "fontSize": 16
    }],
    "startDuration": 1,
    "graphs": [{
        "balloonText": "<b>[[category]]: [[value]]</b>",
        "fillColorsField": "color",
        "fillAlphas": 0.9,
        "lineAlpha": 0.2,
        "type": "column",
        "valueField": "visits"
    }],
    "chartCursor": {
        "categoryBalloonEnabled": false,
        "cursorAlpha": 0,
        "zoomable": false
    },
    "categoryField": "country",
    "categoryAxis": {
        "gridPosition": "start",
        "labelRotation": 45
    },
    "export": {
        "enabled": true
    }

});


