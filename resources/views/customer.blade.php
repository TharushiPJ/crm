<?php
/**
 * Created by PhpStorm.
 * User: Tharushi
 * Date: 4/19/2017
 * Time: 3:03 PM
 */

?>

        <!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CRM - Customer</title>

{!!Html::style('css/app.css')!!}
{!!Html::script('js/app.js')!!}
{!!Html::style('css/styles.css')!!}
{!!Html::script('js/bootstrap-table.js')!!}

{!!Html::style('css/bootstrap-table.css')!!}


    {!!Html::script('js/bootstrap-notify.js')!!}

</head>

<body>

@include ('navBar')
@include ('sidebar')

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">


    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Customer Details</h1>
        </div>
    </div><!--/.row-->


    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">

                    {!! Form::open(['id'=>'frm-customer','method'=>'post','url'=>'insertcustomer'])!!}
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                {!! form::label('company name','Company Name') !!}
                                {!! form::text('companyName',null,['id'=>'name','class'=>'form-control']) !!}
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                {!! form::label('address','Address') !!}
                                {!! form::text('address',null,['id'=>'address','class'=>'form-control']) !!}
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                {!! form::label('business regNo','Business Registration No') !!}
                                {!! form::text('bRegNo',null,['id'=>'bRegNo','class'=>'form-control']) !!}
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                {!! form::label('website','Website') !!}
                                {!! form::text('website',null,['id'=>'website','class'=>'form-control']) !!}
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                {!! form::submit('Save',['class'=>'btn btn-primary']) !!}
                            </div>
                        </div>

                    </div>

                    {!! Form::close() !!}

                    <div class="panel-heading">Existing Customers</div>


                    <table id="tbl_customer" data-toggle="table"  data-show-refresh="true"
                           data-show-toggle="true" data-show-columns="true" data-search="true"
                           data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name"
                           data-sort-order="desc">
                        <thead>
                        <tr>
                            <th data-field="state" data-checkbox="true"></th>
                            <th data-field="companyName" data-sortable="true">Company Name</th>
                            <th data-field="address" data-sortable="true">Address</th>
                            <th data-field="bRegNo" data-sortable="true">Business Reg No</th>
                            <th data-field="website" data-sortable="true">Website</th>
                            <th data-field="edit" data-sortable="true">Edit</th>
                            <th data-field="deleteBtn" data-sortable="true">Delete</th>
                        </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>
    </div><!--/.row-->


</div><!--/.main-->

<script>
    !function ($) {
        $(document).on("click", "ul.nav li.parent > a > span.icon", function () {
            $(this).find('em:first').toggleClass("glyphicon-minus");
        });
        $(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
    }(window.jQuery);

    $(window).on('resize', function () {
        if ($(window).width() > 768) $('#sidebar-collapse').collapse('show')
    })
    $(window).on('resize', function () {
        if ($(window).width() <= 767) $('#sidebar-collapse').collapse('hide')
    })


    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        getAllCustomer();

    });


    function validateCustomer() {
        if ($('#name').val() == "") {
            $('#name').parent('div').addClass('has-error');
            alert("Please enter the Comapny Name!");
            return false;
        }
        else if ($('#address').val() == "") {
            $('#address').parent('div').addClass('has-error');
            alert("Please enter the Address !");
            return false;
        }
        else if ($('#bRegNo').val() == "") {
            $('#bRegNo').parent('div').addClass('has-error');
            alert("Please enter the Business Registration No !");
            return false;
        }
        else if ($('#website').val() == "") {
            $('#website').parent('div').addClass('has-error');
            alert("Please enter the Website !");
            return false;
        }
        else {
            return true;
        }
    }



    var savemode = 'new';
    var customerid=null;
    var url=null;
    var message=null;

    $('#frm-customer').on('submit', function (e) {
//        alert(savemode);
//        alert(url);
        if (savemode == 'new') {
            url = 'insertcustomer';
            message='Successfully Inserted.... Thank You... !';
        }
        else if (savemode == 'edit') {
            url = 'updatecustomer/'+customerid;
            message='Successfully Updated.... Thank You... !';
        }
        e.preventDefault();
        var data = $(this).serialize();

        if(validateCustomer()==true){
            $.ajax({
                type: 'POST',
                url: url,
                data: data,

                success: function (data) {
                    console.log(data)
                    msg(message);
                }

            });
            resetForm();
            getAllCustomer();
        }


    });

    function getCustomer(cid) {
        savemode='edit';
        customerid=cid;

        $.ajax({
            type: 'POST',
            url: 'getcustomer/'+cid,
            dataType: 'json',

            success: function (data) {
                //alert (data);

                $('#name').val(data[0]['companyName']);
                $('#address').val(data[0]['address']);
                $('#bRegNo').val(data[0]['bRegNo']);
                $('#website').val(data[0]['website']);
                $("html, body").animate({ scrollTop: 0 }, "slow");
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }

        });
    }


    function getAllCustomer() {

        $.ajax({
            type: 'POST',
            url: 'getallcustomer',
            dataType: 'json',

            success: function (data) {
               // alert (data);

                $('#tbl_customer').bootstrapTable('removeAll');

                for (var i = 0; i < data.length; i++) {

                    var editButton = '<button id="' + data[i]['id'] + '" class="btn btn-primary editbtn" onclick="getCustomer('+data[i]['id']+')">Edit</button>';
                    var deleteButton = '<button id="' + data[i]['id'] + '" class="btn btn-danger deletebtn" onclick="deleteCustomer('+data[i]['id']+')">Delete</button>';

                    newRow(data[i]['companyName'], data[i]['address'], data[i]['bRegNo'], data[i]['website'],editButton,deleteButton);

                }

            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }

        });
    }

    function newRow(companyName,address,bRegNo,website,editBtn,deleteBtn) {

        $('#tbl_customer').bootstrapTable('insertRow', {
            index: 0,
            row: {
                state: '',
                companyName: companyName,
                address: address,
                bRegNo:bRegNo,
                website:website,
                edit:editBtn,
                deleteBtn:deleteBtn
            }
        });

    }


function deleteCustomer(cid) {
    customerid=cid;

    $.ajax({
        type: 'POST',
        url: 'deletecustomer/'+cid,
        //dataType: 'json',

        success: function (data) {
            getAllCustomer();
            msg('Successfully Deleted.... Thank You... !');
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
        }

    });
}

    function resetForm() {
        $('#frm-customer')[0].reset();

    }

    function msg(msg) {

        $.notify(msg, {
            placement: {
                from: "top",
                align: "center"

            },
            type: 'success',
            offset: 60
        });
        setTimeout(function () {
            $.notifyClose();
        }, 2000);

    }



</script>
</body>

</html>
