var url_get_datatables = base_api + "/contract/all/v1?token="+_token;
var url_detail_contract = base_url + "/contract/detail/";
var table_contract_medical;
var table_contract_element = '.table-contract-medical';
var filter_text = '',
    filter_plan = '',
    filter_payment = '',
    filter_status = 'under',
    length_contract = '15';

$(function () {
    'use strict';

    // load table contract
    loadTableContract();

    // load event filter
    loadEventFilter();

    $(window).keydown(function(event){
        if(event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
    });

    // view detail user
    $(document).on("click", "#table_contract_medical tbody tr", function () {
        var id = $(this).attr('data-id');
        if (id) {
            run_waitMe('.wait-containter');
            window.location.href = url_detail_contract + id;
        }
    });
});

var loadTableContract = function() {
    run_waitMe('.wait-containter');
    if ($.fn.DataTable.isDataTable(table_contract_element)) {
        $(table_contract_element).DataTable().destroy();
        $('.table-contract-medical tbody').empty();
    }

    var urlRequest = url_get_datatables;

    urlRequest += "&filter_text=" + $('#filter_text').val();

    if (filter_plan && filter_plan != '') {
        urlRequest += "&filter_plan=" + filter_plan;
    }

    if (filter_payment && filter_payment != '') {
        urlRequest += "&filter_payment=" + filter_payment;
    }

    if (filter_status && filter_status != '') {
        urlRequest += "&filter_status=" + filter_status;
    }

    table_contract_medical = $(table_contract_element).DataTable({
        "pageLength": length_contract,
        "autoWidth": false,
        "serverSide": true,
        "ajax": urlRequest,
        "searching": false,
        "bSort" : false,
        "pagingType": "numbers",
        "dom": '<"d-flex justify-content-end flex-column flex-sm-row align-items-end align-items-sm-start"<"mr-0 mr-sm-2 mb-2 mb-sm-0"i>l>rt<p>',
        "language": {
            "paginate": {
                "first": '最初',
                "previous": '前',
                "next": '次',
                "last": '最終',
            },
            "lengthMenu": "_MENU_",
            "emptyTable": 'テーブル内のデータなし',
            "info": "検索結果／_TOTAL_件",
            "infoEmpty": "",
            "infoFiltered": "",
            "zeroRecords": "一致する検索結果がありません",
        },
        "lengthMenu": [[15, 50, 100], [15 + '件表示', 50 + '件表示', 100 + '件表示']],
        "sLengthSelect": "select2",
        "responsive": true,
        "columns": [
            {
                "data": "id",
                "searchable": false
            },
            {
                "data": "mCompany.corp_id",
            },
            {
                "data": "mCompany.name",
            },
            {
                "data": "mCompany.office_name",
            },
            {
                "data": "status_contract", // hop dong/ huy bo
                "searchable": false
            },
            {
                "data": "mPlan.name",
                "searchable": false
            },
            {
                "data": "mPlan.amount",
                render: function (data, type, row) {
                    if (row.is_trial == 1) {
                        return '0円';
                    } else {
                        return parseInt(data).toLocaleString() + '円';
                    }

                },
                "searchable": false
            },
            {
                "data": "status_charge", // thanh toan/ chua thanh toan
                "searchable": false
            }
        ],
        "columnDefs": [
            {
                targets: [0, 1, 4, 5, 6, 7],
                class: 'text-center',
            },
            {
                targets: [2, 3],
                class: 'multi-line'
            },
        ],
        "initComplete": function (settings, json) {
            $('.dataTables_length select').val(length_contract).trigger('change.select2');
            $('.slim-body .slim-mainpanel .container').addClass('d-block');
            run_waitMe('.wait-containter', true);
        },
        "fnCreatedRow": function (nRow, aData, iDataIndex) {
            $(nRow).attr('data-id', aData.company_id);
        }
    }).on('processing.dt', function (e, settings, processing) {
        if (processing) {
            run_waitMe('.wait-containter');
        } else {
            $('.slim-body .slim-mainpanel .container').addClass('d-block');
            run_waitMe('.wait-containter', true);
        }
    }).on( 'draw.dt', function () {
        var PageInfo = $(this).DataTable().page.info();
        table_contract_medical.column(0, { page: 'current' }).nodes().each( function (cell, i) {
            cell.innerHTML = i + 1 + PageInfo.start;
        });
    });

    table_contract_medical.clear().draw();

    if ($('.dataTables_length select').length > 0) {
        $('.dataTables_length select').select2({
            minimumResultsForSearch: Infinity,
            dropdownCssClass : 'z-index-900'
        }).on("select2:select", function (e) {
            length_contract = $(this).val();
            changePageLength('.table-contract-medical', table_contract_medical, length_contract);
        });
    }
}

var loadEventFilter = function() {
    // filter plan
    $.ajax({
        url: base_api + "/contract/plans/v1?token="+_token,
        type: "GET",
        success: function(response) {
            if (response.data) {
                var plans = response.data;
                $('.filter-plans').empty();
                plans.forEach(function(plan, index) {
                    $('.filter-plans').append('\
                        <div class="col-12 col-sm-4 mt-2 mt-sm-0">\
                            <button class="btn btn-light rounded-7 btn-cus-hm btn-search-plan font-bold" data-search="'+ plan.id +'" type="button">\
                                '+ plan.name +'\
                            </button>\
                        </div>\
                    ');

                    $('.summary-plans').append('\
                        <span class="icon_slash">／</span>'+ plan.name +' : <span class="number-contract-'+plan.id+'">0件</span>\
                    ');
                });
            }
        },
        error: function(error) {
            Swal.fire({
                text: error.responseJSON.msg
            });
        }
    });
    
    //summary text
    $.ajax({
        url: base_api + "/contract/summary/v1?token=" +_token,
        type: "GET",
        success: function(response) {
            if (response.data) {
                var summary = response.data.summary;
                var total = response.data.total;

                $('.number-contract').html(total + '件');
                summary.forEach(function(plan, index) {
                    $('.number-contract-'+plan.plan_id).html(plan.total +'件');
                });
            }
        },
        error: function(error) {
            Swal.fire({
                text: error.responseJSON.msg
            });
        }
    });

    $(document).on("click", '.btn-search-plan', function () {
        $('.btn.btn-search-plan.btn-cus-hm').removeClass('active');
        $(this).addClass('active');
        filter_plan = $(this).attr('data-search');
        loadTableContract();
    });

    // filter payment
    $(document).on("click", '.btn-search-payment', function () {
        $('.btn.btn-search-payment.btn-cus-hm').removeClass('active');
        $(this).addClass('active');
        filter_payment = $(this).attr('data-search');
        loadTableContract();
    });

    // filter status
    $(document).on("click", '.btn-search-status', function () {
        $('.btn.btn-search-status.btn-cus-hm').removeClass('active');
        $(this).addClass('active');
        filter_status = $(this).attr('data-search');
        loadTableContract();
    });

    // filter text
    $(document).on("keypress", '#filter_text', function (event) {
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '13') {
            filter_text = $('#filter_text').val();
            loadTableContract();
        }
    });

    $(document).on("click", '#filter_text_btn', function () {
        filter_text = $('#filter_text').val();
        loadTableContract();
    });

    // filter search all
    $(document).on("click", '#btn_search_all', function () {
        $('.btn.btn-search-plan.btn-cus-hm').removeClass('active');
        $('.btn.btn-search-payment.btn-cus-hm').removeClass('active');
        $('.btn.btn-search-status.btn-cus-hm').removeClass('active');
        $('#filter_text').val('');

        filter_plan = '';
        filter_payment = '';
        filter_status = '';
        filter_text = '';

        loadTableContract();
    });
}
