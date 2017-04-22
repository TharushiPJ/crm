<?php
/**
 * Created by PhpStorm.
 * User: Tharushi
 * Date: 4/19/2017
 * Time: 11:14 PM
 */

?>

        <!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CRM - Activities</title>


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
            <h1 class="page-header">Activities</h1>
        </div>
    </div><!--/.row-->


    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">

                    {!! Form::open(['id'=>'frm-activity','method'=>'post','url'=>'insertactivity'])!!}
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">


                                {!! form::label('date','Date') !!}
                                {!!  Form::input('date', 'date', null, ['id'=>'date','class' => 'form-control', 'placeholder' => 'Date']) !!}
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                {!! form::label('activity type','Activity Type') !!}<br>
                                {!! Form::label('call', 'Call') !!}
                                {!! Form::radio('actType', 'c', false, array('id'=>'call')) !!}
                                {!! Form::label('email', 'Email') !!}
                                {!! Form::radio('actType', 'e', false, array('id'=>'email')) !!}
                                {!! Form::label('meeting', 'Meeting') !!}
                                {!! Form::radio('actType', 'm', false, array('id'=>'meeting')) !!}
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                {!! form::label('outcome','Outcome') !!}
                                {!! form::text('outcome',null,['id'=>'outcome','class'=>'form-control']) !!}
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                {!! form::label('sales person name','Sales Person Name') !!}
                                {!! form::text('personName',null,['id'=>'personName','class'=>'form-control']) !!}
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                {!! form::label('company','Customer') !!}
                                {!!Form::select('customer', $cus,null,['id'=>'customer','class'=>'form-control']) !!}
                            </div>
                        </div>



                    </div>
<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            {!! form::submit('Save',['class'=>'btn btn-primary']) !!}
        </div>
    </div>
</div>

                    {!! Form::close() !!}

                    <div class="panel-heading">Existing Activities</div>


                    <table id="tbl_activity" data-toggle="table"  data-show-refresh="true" data-show-toggle="true"
                           data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true"
                           data-sort-name="name" data-sort-order="desc">
                        <thead>
                        <tr>
                            <th data-field="state" data-checkbox="true" >Item ID</th>
                            <th data-field="date" data-sortable="true">Date</th>
                            <th data-field="type"  data-sortable="true">Activity Type</th>
                            <th data-field="outcome" data-sortable="true">Outcome</th>
                            <th data-field="salesPerson" data-sortable="true">Sales Person Name</th>
                            <th data-field="customer" data-sortable="true">Company Name</th>
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
        $(document).on("click","ul.nav li.parent > a > span.icon", function(){
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

        getAllActivities();
        $('#call').attr('checked',true);
    });



    function validateActivity() {
        if ($('#date').val() == "") {
            $('#date').parent('div').addClass('has-error');
            alert("Please select the date!");
            return false;
        }
        else if ($('#outcome').val() == "") {
            $('#outcome').parent('div').addClass('has-error');
            alert("Please enter the Outcome !");
            return false;
        }
        else if ($('#personName').val() == "") {
            $('#personName').parent('div').addClass('has-error');
            alert("Please enter the Person Name !");
            return false;
        }
        else if ($('#customer').val() == "") {
            $('#customer').parent('div').addClass('has-error');
            alert("Please select the Customer !");
            return false;
        }
        else {
            return true;
        }
    }




    var savemode = 'new';
    var activityid=null;
    var url=null;

    $('#frm-activity').on('submit', function (e) {

        if (savemode == 'new') {
            var url = 'insertactivity';
            message='Successfully Inserted.... Thank You... !';
        }
        else if (savemode == 'edit') {
            var url = 'updateactivity/'+activityid;
            message='Successfully Updated.... Thank You... !';
        }

        e.preventDefault();
        var data = $(this).serialize();

        if(validateActivity()== true){

            $.ajax({
                type: 'POST',
                url: url,
                data: data,

                success: function (data) {
                    console.log(data);

                    if(data=="1"){
                        resetForm();
                        getAllActivities();
                    }

                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            })
            resetForm();
            getAllActivities();
        }




    });


    function getActivity(act_id) {
        savemode='edit';
        activityid=act_id;

        $.ajax({
            type: 'POST',
            url: 'getactivity/'+act_id,
            dataType: 'json',

            success: function (data) {
                //alert (data);

                $('#date').val(data[0]['date']);


                if((data[0]['type'])== 'c'){
                    $('#call').attr('checked',true);
                }
                else if((data[0]['type'])== 'e'){
                    $('#email').attr('checked',true);
                }
                else if((data[0]['type'])== 'm'){
                    $('#meeting').attr('checked',true);
                }

                $('#outcome').val(data[0]['outcome']);
                $('#personName').val(data[0]['salesPerson']);
                $('#customer').val(data[0]['customer']);
                $("html, body").animate({ scrollTop: 0 }, "slow");
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }

        });
    }

    function getAllActivities() {

        $.ajax({
            type: 'POST',
            url: 'getallactivities',
            dataType: 'json',

            success: function (data) {
//alert (data);
                $('#tbl_activity').bootstrapTable('removeAll');

                for (var i = 0; i < data.length; i++) {

                    var editButton = '<button id="' + data[i]['act_id'] + '" class="btn btn-primary editbtn" onclick="getActivity('+data[i]['act_id']+')">Edit</button>';
                    var deleteButton = '<button id="' + data[i]['act_id'] + '" class="btn btn-danger deletebtn" onclick="deleteActivity('+data[i]['act_id']+')">Delete</button>';

                    newRow(data[i]['date'], data[i]['type'], data[i]['outcome'], data[i]['salesPerson'], data[i]['companyName'],editButton,deleteButton);

                }

            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }

        });
    }

    function newRow(date,type,outcome,salesPerson,customer,editBtn,deleteBtn) {

        $('#tbl_activity').bootstrapTable('insertRow', {
            index: 0,
            row: {
                state: '',
                date: date,
                type: type,
                outcome: outcome,
                salesPerson:salesPerson,
                customer:customer,
                edit:editBtn,
                deleteBtn:deleteBtn
            }
        });

    }

    function deleteActivity(act_id) {
        activityid=act_id;

        $.ajax({
            type: 'POST',
            url: 'deleteactivity/'+act_id,
            //dataType: 'json',

            success: function (data) {
                msg('Successfully Deleted.... Thank You... !');
                getAllActivities();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }

        });
    }



    function resetForm() {
        $('#frm-activity')[0].reset();
        $('#call').attr('checked',true);
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


