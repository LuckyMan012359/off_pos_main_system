// Draw chart
//initial blank chart assign
//Plugin is not being initialized in use strict mode, script is added here for that reason

let op_precision = $("#op_precision").val();
let op_decimals_separator = $("#op_decimals_separator").val();
let op_thousands_separator = $("#op_thousands_separator").val();

function getAmtPCustom(amount) {
    if (isNaN(amount)) {
        amount = 0;
    }

    amount = parseFloat(amount);
    
    let precision = op_precision || 0;
    let decimalsSeparator = op_decimals_separator || '.';
    let thousandsSeparator = op_thousands_separator || '';

    // Truncate the amount to the specified precision
    let factor = Math.pow(10, precision);
    amount = Math.floor(amount * factor) / factor;

    // Format the amount
    let strAmount = amount.toLocaleString(undefined, {
        minimumFractionDigits: precision,
        maximumFractionDigits: precision,
        useGrouping: !!thousandsSeparator
    });

    // Replace default decimal separator with custom one
    if (decimalsSeparator !== '.') {
        strAmount = strAmount.replace('.', decimalsSeparator);
    }

    // Replace default thousands separator with custom one
    if (thousandsSeparator !== ',') {
        strAmount = strAmount.replace(/,/g, thousandsSeparator);
    }

    return strAmount;
}




let ctx = document.getElementById("day_week_month_chart_report").getContext('2d');
const myLineChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: [],
        datasets: [{
            label: '', // Name the series
            data: [], // Specify the data values array
            fill: true,
            borderColor: '#8b5cf6', // Add custom color border (Line)
            backgroundColor: '#8b5cf61a',
            borderWidth: 3, // Specify bar border width
            animations: true
        }]
    },
    options: {
        plugins: {
            legend: {
                display: false
            }
        },
        responsive: true,
        maintainAspectRatio: false,
    }
});


$(function () {
    "use strict";
    let base_url = $("#base_url_").val();
    function show_sale_report(type,action_type) {
        let outlet_id = $("#outlet_id_dashboard").val();
        let start_date = $("#start_date").val();
        let end_date = $("#end_date").val();
        $.ajax({
            url: base_url+"Dashboard/get_sale_report_charge",
            type: "POST",
            dataType: "json",
            async: false,
            data: {
                outlet_id: outlet_id,
                start_date: start_date,
                end_date: end_date,
                type: type,
                action_type: action_type,
            },
            success: function (response) {
                $(".set_total_1").text(getAmtPCustom(parseFloat(response.set_total_1)));
                $(".set_total_2").text(getAmtPCustom(parseFloat(response.set_total_2)));
                $(".set_total_3").text(getAmtPCustom(parseFloat(response.set_total_3)));
                $(".set_total_4").text(getAmtPCustom(parseFloat(response.set_total_4)));
                if(Number(response.set_total_3)){
                    $(".set_total_5").text(getAmtPCustom(Number(response.set_total_3) / Number(response.set_total_4)))  ;
                }else{
                    $(".set_total_5").text(getAmtPCustom(0));
                }
                let json = (response.data_points);
                let data_chart = [];
                let data_label = [];
                let data_label_value = [];
                $.each(json, function (i, v) {
                    data_chart.push({ y: Number(v.y_value), yLabel: v.y_label,x:i, label:v.x_label, tmiLabel:v.x_label_tmp,});
                    data_label.push(v.x_label);
                    data_label_value.push(Number(v.y_value));
                });

                //chart js
                // assign programmatically the datasets again, otherwise data changes won't show
                myLineChart.data.labels = data_label;
                myLineChart.data.datasets[0].data = data_label_value;
                myLineChart.data.datasets[0].animations = true;
                myLineChart.update();

            },
        });
    }
    function show_sale_report_today() {
        let outlet_id = $("#outlet_id_dashboard").val();
        $.ajax({
            url: base_url+"Dashboard/get_sale_report_charge_today",
            type: "POST",
            dataType: "json",
            data: {
                outlet_id: outlet_id,
            },
            success: function (response) {
                $(".set_today_total_1").html(getAmtPCustom(parseFloat(response.set_total_1)));
                $(".set_today_total_2").html(getAmtPCustom(parseFloat(response.set_total_2)));
                $(".set_today_total_3").html(getAmtPCustom(parseFloat(response.set_total_3)));
                $(".set_today_total_4").html(getAmtPCustom(parseFloat(response.set_total_4)));
                if(Number(response.set_total_3)){
                    $(".set_today_total_5").html(getAmtPCustom(Number(response.set_total_3)/Number(response.set_total_4)));
                }else{
                    $(".set_today_total_5").html(getAmtPCustom(0));
                }
                
                $('.spincrement').spincrement({
                    from: 0.0,
                    decimalPlaces: op_decimals_separator,
                    thousandSeparator: op_thousands_separator,
                    duration: 1000,
                });
            },
        });
    }

    setTimeout(function () {
        show_sale_report("day","revenue");
        show_sale_report_today();
    }, 2000);

    $(document).on('click', '.get_graph_data', function(e) {
        e.preventDefault();
        $('.get_graph_data').removeClass('active');
        $(this).addClass('active');
        let action_type = $(this).attr('data-action_type');
        let text = $(this).attr('data-text');
        $(".sale_report_header").html(text);
        let type = "day";

        $(".get_date_by_custom_btn").each(function() {
            if($(this).hasClass("custom_td_active")){
                type = $(this).attr('data-type');
            }
        });

        show_sale_report(type,action_type);
    });
    $(document).on('click', '.get_action_prevent', function(e) {
        e.preventDefault();
    });
    $(document).on('click', '.get_date_by_custom_btn', function(e) {
        e.preventDefault();
        $('.get_date_by_custom_btn').removeClass('custom_td_active');
        $(this).addClass('custom_td_active');
        let type = $(this).attr("data-type");
        let action_type = "revenue";

        $(".get_graph_data").each(function() {
            if($(this).hasClass("active")){
                action_type = $(this).attr('data-action_type');
            }
        });

        show_sale_report(type,action_type);

    });
});
