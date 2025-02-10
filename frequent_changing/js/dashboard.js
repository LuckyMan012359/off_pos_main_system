$(function () {
    "use strict";
    let base_url_ = $("#base_url_").val();
    let i_sale = $("#i_sale_").val();
    let purchase = Number($("#purchase_").val());
    let sale = Number($("#sale_").val());
    let waste = Number($("#waste_").val());
    let expense = Number($("#expense_").val());
    let cust_rcv = Number($("#cust_rcv_").val());
    let supp_pay = Number($("#supp_pay_").val());
    let down_payment = Number($("#down_payment_").val());
    let installment_paid_amount = Number($("#installment_paid_amount_").val());
    //BAR CHART
    if (i_sale == "No") {
        let bar = new Morris.Bar({
            element: 'operational_comparision',
            resize: true,
            data: [
                { y: 'Purchase', a: purchase },
                { y: 'Sale', a: sale },
                { y: 'Damage', a: waste },
                { y: 'Expense', a: expense },
                { y: 'Cust Rec', a: cust_rcv },
                { y: 'Supp Pay', a: supp_pay }
            ],
            barColors: ['#00a65a', '#f56954'],
            xkey: 'y',
            ykeys: ['a'],
            labels: ['Amount'],
            hideHover: 'auto'
        });
    } else {
        let bar = new Morris.Bar({
            element: 'operational_comparision',
            resize: true,
            data: [
                { y: 'Purchase', a: purchase },
                { y: 'Sale', a: sale },
                { y: 'Damage', a: waste },
                { y: 'Expense', a: expense },
                { y: 'Cust Rec', a: cust_rcv },
                { y: 'Supp Pay', a: supp_pay },
                { y: 'Down Payment', a: down_payment },
                { y: 'Installment Paid Amt', a: installment_paid_amount }
            ],
            barColors: ['#8b5cf6', '#f56954'],
            xkey: 'y',
            ykeys: ['a'],
            labels: ['Amount'],
            hideHover: 'auto'
        });
    }


    $('#low_stock_items, .top_ten_food_menu, #top_ten_customer, #customer_receivable, #supplier_payable').slimscroll({
        height: '220px'
    });


    function selectMonth(value) {
        $.ajax({
            url: base_url_ + 'Ajax/comparison_sale_report_ajax_get',
            type: 'get',
            datatype: 'json',
            data: { months: value},
            success: function (response) {
                let json = $.parseJSON(response);
                google.charts.load('current', { 'packages': ['corechart', 'bar'] });
                google.charts.setOnLoadCallback(drawStuff);
                function drawStuff() {
                    let chartDiv = document.getElementById('chart_div');
                    let data = '';
                    let dataArray = [];
                    let dataArrayValue = [];
                    dataArrayValue = [];
                    dataArrayValue.push('');
                    dataArrayValue.push('');
                    dataArray.push(dataArrayValue);

                    $.each(json, function (i, v) {
                        window['monthName' + i] = v.month;
                        window['collection' + i] = v.saleAmount;
                        dataArrayValue = [];
                        dataArrayValue.push(v.month);
                        dataArrayValue.push(v.saleAmount);
                        dataArray.push(dataArrayValue);
                    });
                    data = google.visualization.arrayToDataTable(dataArray);
                    let options = {
                        legend: { position: "none" },
                        colors: ['#8b5cf6', '#8b5cf6', '#8b5cf6'],
                        axes: {
                            y: {
                                all: {
                                    format: {
                                        pattern: 'decimal'
                                    }
                                }
                            }
                        },
                        series: {
                            0: { axis: '0' }
                        }
                    };

                    function drawMaterialChart() {
                        let materialChart = new google.charts.Bar(chartDiv);
                        materialChart.draw(data, options);
                    }
                    function drawClassicChart() {
                        let classicChart = new google.visualization.ColumnChart(chartDiv);
                        classicChart.draw(data, classicOptions);

                    }
                    drawMaterialChart();
                }
            }
        });

    }
    selectMonth(12);
    $('#operational_coparision_range').on('click', function () {
        $('#operation_comparision_range_fields').show();
    });
    $('#operation_comparision_cancel').on('click', function () {
        $('#operation_comparision_range_fields').hide();
    })
    $('#operation_comparision_input').daterangepicker({
        opens: 'left',
        locale: {
            format: 'YYYY-MM-DD'
        }
    });

    $(document).on('click', '#operation_comparision_submit', function () {
        let date_range = $('#operation_comparision_input').val();
        let date_range_array = date_range.split(" - ");
        let from_this_day = date_range_array[0];
        let to_this_day = date_range_array[1];
        $.ajax({
            url: base_url_ + 'Dashboard/operation_comparision_by_date_ajax"',
            method: "POST",
            data: {
                from_this_day: from_this_day,
                to_this_day: to_this_day,
                id: f_menu_id,
            },
            success: function (response) {
                response = JSON.parse(response);
                //BAR CHART
                let bar = new Morris.Bar({
                    element: 'operational_comparision',
                    resize: true,
                    data: [
                        { y: 'Purchase', a: response.purchase_sum.purchase_sum },
                        { y: 'Sale', a: response.sale_sum.sale_sum },
                        { y: 'Damage', a: response.waste_sum.waste_sum },
                        { y: 'Expense', a: response.expense_sum.expense_sum },
                        { y: 'Cust Rcv', a: response.customer_due_receive_sum.customer_due_receive_sum },
                        { y: 'Supp Pay', a: response.supplier_due_payment_sum.supplier_due_payment_sum }
                    ],
                    barColors: ['#00a65a', '#f56954'],
                    xkey: 'y',
                    ykeys: ['a'],
                    labels: ['Amount'],
                    hideHover: 'auto'
                });

            },
            error: function () {
                alert("error");
            }
        });
        $('#operation_comparision_range_fields').hide();
    });
    
    
    function date_wise_dashboard_report() {
        let start_date = $("#start_date").val();
        let end_date = $("#end_date").val();
        $.ajax({
            url: base_url_ + 'Ajax/date_wise_dashboard_report_ajax_get',
            type: 'get',
            datatype: 'json',
            data: { start_date: start_date, end_date: end_date },
            success: function (response) {
                let dash_value = JSON.parse(response);
                let currency_sign = $("#currency_sign").val();
                $("#total_purchase").html(currency_sign + parseFloat(dash_value.total_purchase).toFixed(2));
                $("#total_sales").html(currency_sign + parseFloat(dash_value.total_sales).toFixed(2));
                $("#purchase_due").html(currency_sign + parseFloat(dash_value.purchase_due).toFixed(2));
                $("#sales_due").html(currency_sign + parseFloat(dash_value.sales_due).toFixed(2));
                $("#total_purchase_return").html(currency_sign + parseFloat(dash_value.total_purchase_return).toFixed(2));
                $("#total_sales_return").html(currency_sign + parseFloat(dash_value.total_sales_return).toFixed(2));
                $("#total_expense").html(currency_sign + parseFloat(dash_value.expense).toFixed(2));
                $("#total_income").html(currency_sign + parseFloat(dash_value.income).toFixed(2));
            }
        });

    }
    date_wise_dashboard_report();
    $(document).on('click','#dashboard_search', function () {
        date_wise_dashboard_report();
    });
    


});