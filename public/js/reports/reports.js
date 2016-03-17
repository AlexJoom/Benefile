/**
* Created by cdimitzas on 16/3/2016.
*/

// -------- REPORT: Benefiters vs education (script) --------------------------------------//
var educationData = [];
fetchEducationDataReport();
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

// -------- END REPORT: Benefiters vs education (script) --------------------------------------//

