//Image Upload Preview
//=======================================================
var loadFile = function (event) {
    var reader = new FileReader();
    reader.onload = function () {
        var output = document.getElementById('output');
        output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
    document.getElementById('upload_btn').style.display = "block";
};

// Delete Confirmation
//=======================================================
function ConfirmDelete() {
    var x = confirm("Are you sure you want to delete?");
    if (x)
        return true;
    else
        return false;
}

$(document).ready(function () { //Document ready function Start
    // Data Table
    //============================================================
    $('#investmebt_all_table').DataTable({
        "paging": false,
        "info": false,
        "bFilter": false,
        fixedHeader: true
    });

    $('#admin_table').dataTable({
        "paging": false,
        "info": false,
        "bFilter": false

    });

    $('#income_table').dataTable({
        "paging": false,
        "info": false,
        "bFilter": false

    });

    // Top Bar Search Result
    //============================================================
    // fetch_customer_data();

    // function fetch_customer_data(query = '') {
    //     $.ajax({
    //         url: "/admin/search",
    //         method: 'GET',
    //         data: {
    //             query: query
    //         },
    //         dataType: 'json',
    //         success: function (data) {
    //             $('#search_result').html(data.table_data);
    //             $('#total_records').text(data.total_data);
    //         }
    //     })
    // }

    // $(document).on('change keyup paste', '#search', function () {
    //     var query = $(this).val();
    //     fetch_customer_data(query);
    // });

    // Search Member for select
    //============================================================
    $("#select_user_for_salary").change(function () {
        // alert($(this).val());
        var id = $(this).val();
        $.ajax({
            url: "/admin/salary/user",
            method: 'GET',
            data: {
                id: id,
            },
            dataType: 'json',
            success: function (data) {
                document.getElementById("user_image").src = data.image;
                document.getElementById("user_link").href = data.link;
                $('#username').text(data.name);
                $('#user_email').text(data.email);
                $('#user_phone').text(data.phone);
                $('#user_role').text(data.role);
                $('#user_address').text(data.address);
                $('#user_member').text(data.member_since);
                $('#total').text(data.total);
                $('#last_received').text(data.last_received);
                $('#last_date').text(data.last_date);
                $('#monthly_salary').text(data.monthly_salary);
                $('#due_amount').text(data.due_amount);
                document.getElementById("history_link").href = data.history_link;
                document.getElementById("user_info").style.display = "block";
                document.getElementById("user_history").style.display = "block";
            }
        })
    });

    // Search Member for Investment
    //============================================================
    $("#select_user_for_investment").change(function () {
        // alert($(this).val());
        var id = $(this).val();
        $.ajax({
            url: "/admin/investment/user",
            method: 'GET',
            data: {
                id: id,
            },
            dataType: 'json',
            success: function (data) {
                document.getElementById("user_image").src = data.image;
                document.getElementById("user_link").href = data.link;
                $('#username').text(data.name);
                $('#user_email').text(data.email);
                $('#user_phone').text(data.phone);
                $('#user_role').text(data.role);
                $('#user_address').text(data.address);
                $('#user_member').text(data.member_since);
                $('#total_investment').text(data.total_investment);
                $('#last_investment').text(data.last_investment);
                $('#last_investment_date').text(data.last_investment_date);
                document.getElementById("history_link").href = data.history_link;
                document.getElementById("user_link").href = data.user_link;
                document.getElementById("user_info").style.display = "block";
                document.getElementById("user_history").style.display = "block";
            }
        })
    });


    //Ajax alert Setting
    //==============================================================
    var $alertMsg = $("#ajax-success");

    $alertMsg.on("close.bs.alert", function () {
        $alertMsg.hide();
        return false;
    });


    //Report Table Setting
    //==============================================================

    // var expense_all_table = document.getElementById('expense_all_table');

    // if (expense_all_table) {
    //     var tableCont = document.querySelector('#expense_all_table')

    //     function scrollHandle(e) {
    //         var scrollTop = this.scrollTop;
    //         this.querySelector('thead').style.transform = 'translateY(' + scrollTop + 'px)';
    //     }
    //     tableCont.addEventListener('scroll', scrollHandle)
    // }


    // Date Range Setting
    //==============================================================
    var report_date = document.getElementById('report_date');

    if (report_date) {
        $('#report_date').daterangepicker({
            opens: 'left'
        });
    }

}); //Document ready function End
