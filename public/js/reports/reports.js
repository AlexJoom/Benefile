/**
 * Created by cdimitzas on 16/3/2016.
 */
$(document).ready(function(){
    var pieData = [
        {
            value: $('#illiterate').val().trim(),
            color:"#878BB6",
            label: ''
        },
        {
            value : 40,
            color : "#4ACAB4",
            label: ''
        },
        {
            value : 10,
            color : "#FF8153",
            label: ''
        },
        {
            value : 30,
            color : "#FFEA88",
            label: ''
        }
    ];

    var pieOptions = {
        segmentShowStroke : false,
        animateScale : true
    };
    var countries= document.getElementById("benefiter_vs_education_canvas").getContext("2d");
    new Chart(countries).Doughnut(pieData, pieOptions);
});

