/**
* Created by cdimitzas on 16/3/2016.
*/
//$(document).ready(function(){
//    var pieData = [
//        {
//            value: $('#illiterate').val().trim(),
//            color:"#878BB6",
//            label: 'Label 1'
//        },
//        {
//            value : 40,
//            color : "#4ACAB4",
//            label: 'Label 2'
//        },
//        {
//            value : 10,
//            color : "#FF8153",
//            label: 'Label 3'
//        },
//        {
//            value : 30,
//            color : "#FFEA88",
//            label: 'Label 4'
//        }
//    ];
//
//    var pieOptions = {
//        segmentShowStroke : false,
//        animateRotate: true,
//        animateScale : false,
//        percentageInnerCutout: 50,
//        tooltipTemplate: "<%= value %>%"
//    };
//    var benefiter_vs_education = document.getElementById("benefiter_vs_education_canvas").getContext("2d");
//    var benefiter_vs_education_canvas = new Chart(benefiter_vs_education).Doughnut(pieData, pieOptions);
//    document.getElementById('benefiter-vs-education-legend').innerHTML = benefiter_vs_education_canvas.generateLegend();
//});

//    ---------- SECOND WAY --------------
$(document).ready(function(){
    var chart = AmCharts.makeChart("benefiter_vs_education", {
        "titles":[{'text':'Chart','size':22}],
        "type": "pie",
        "startDuration": 0,
        "theme": "light",
        "addClassNames": true,
        "legend":{
            "position":"right",
            "marginRight":100,
            "autoMargins":false

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
        "dataProvider": [{
            "country": "Lithuania",
            "litres": 501.9
        }, {
            "country": "Czech Republic",
            "litres": 301.9
        }, {
            "country": "Ireland",
            "litres": 201.1
        }, {
            "country": "Germany",
            "litres": 165.8
        }, {
            "country": "Australia",
            "litres": 139.9
        }, {
            "country": "Austria",
            "litres": 128.3
        }, {
            "country": "UK",
            "litres": 99
        }, {
            "country": "Belgium",
            "litres": 60
        }, {
            "country": "The Netherlands",
            "litres": 50
        }],
        "valueField": "litres",
        "titleField": "country",
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
// ------------- THIRD WAY -------------------------------

//window.onload = function () {
//    var chart = new CanvasJS.Chart("chartContainer",
//        {
//            title:{
//                text: "Top U.S Smartphone Operating Systems By Market Share, Q3 2012"
//            },
//            credits: {
//                enabled: false
//            },
//            data: [
//                {
//                    type: "doughnut",
//                    radius:  "130%",
//                    innerRadius: "40%",
//                    dataPoints: [
//                        {  y: 53.37, indexLabel: "Android" },
//                        {  y: 35.0, indexLabel: "Apple iOS" },
//                        {  y: 7, indexLabel: "Blackberry" },
//                        {  y: 2, indexLabel: "Windows Phone" },
//                        {  y: 5, indexLabel: "Others" }
//                    ]
//                }
//            ]
//        });
//
//    chart.render();
//};

