<?php
/**
 * Created by PhpStorm.
 * User: Tharushi
 * Date: 4/19/2017
 * Time: 10:50 PM
 */
?>

        <!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CRM - Contact</title>

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
            <h1 class="page-header">Contact Details</h1>
        </div>
    </div><!--/.row-->


    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">

                    {!! Form::open(['id'=>'frm-contact','method'=>'post','url'=>'insertcontact'])!!}

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                {!! form::label('name','Name') !!}
                                {!! form::text('name',null,['id'=>'name','class'=>'form-control']) !!}
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                {!! form::label('email','Email') !!}
                                {!! form::text('email',null,['id'=>'email','class'=>'form-control']) !!}
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                {!! form::label('contact no','Contact No') !!}
                                {!! form::text('contactNo',null,['id'=>'contactNo','class'=>'form-control']) !!}
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                {!! form::label('customer','Customer') !!}
                                {!!Form::select('customer', $cus,null,['id'=>'customer','class'=>'form-control'])  !!}
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                {!! form::submit('Save',['class'=>'btn btn-primary']) !!}
                            </div>
                        </div>

                    </div>


                    {!! Form::close() !!}

                    <div class="panel-heading">Existing Contacts</div>


                    <table id="tbl_contact" data-toggle="table"  data-show-refresh="true" data-show-toggle="true" data-show-columns="true"
                           data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name"
                           data-sort-order="desc">
                        <thead>
                        <tr>
                            <th data-field="state" data-checkbox="true" >Item ID</th>
                            <th data-field="name" data-sortable="true">Name</th>
                            <th data-field="email"  data-sortable="true">Email</th>
                            <th data-field="contactNo" data-sortable="true">Contact No</th>
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

        getAllContacts();

    });


    function validateContact() {
        if ($('#name').val() == "") {
            $('#name').parent('div').addClass('has-error');
            alert("Please enter the Name!");
            return false;
        }
        else if ($('#email').val() == "" || (!isValidEmailAddress($('#email').val()))) {
            $('#email').parent('div').addClass('has-error');
            alert("Invalid Email !");
            return false;
        }
        else if ($('#contactNo').val() == "") {
            $('#contactNo').parent('div').addClass('has-error');
            alert("Please enter the Contact No !");
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
    var contactid=null;
    var url=null;

    $('#frm-contact').on('submit', function (e) {

        if (savemode == 'new') {
            var url = 'insertcontact';
            message='Successfully Inserted.... Thank You... !';
        }
        else if (savemode == 'edit') {
            var url = 'updatecontact/'+contactid;
            message='Successfully Updated.... Thank You... !';
        }

        e.preventDefault();
        var data = $(this).serialize();

        if(validateContact()==true){

            $.ajax({
                type: 'POST',
                url: url,
                data: data,

                success: function (data) {
                    console.log(data);
                    msg(message);
                    resetForm();
                    getAllContacts();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            })
        }



    });





    function getContact(con_id) {
        savemode='edit';
        contactid=con_id;

        $.ajax({
            type: 'POST',
            url: 'getcontact/'+con_id,
            dataType: 'json',

            success: function (data) {
                //alert (data);

                $('#name').val(data[0]['name']);
                $('#email').val(data[0]['email']);
                $('#contactNo').val(data[0]['contactNo']);
                $('#customer').val(data[0]['customer']);
                $("html, body").animate({ scrollTop: 0 }, "slow");
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }

        });
    }

    function getAllContacts() {

        $.ajax({
            type: 'POST',
            url: 'getallcontacts',
            dataType: 'json',

            success: function (data) {
//alert (data);
                $('#tbl_contact').bootstrapTable('removeAll');

                for (var i = 0; i < data.length; i++) {

                    var editButton = '<button id="' + data[i]['con_id'] + '" class="btn btn-primary editbtn" onclick="getContact('+data[i]['con_id']+')">Edit</button>';
                    var deleteButton = '<button id="' + data[i]['con_id'] + '" class="btn btn-danger deletebtn" onclick="deleteContact('+data[i]['con_id']+')">Delete</button>';

                    newRow(data[i]['name'], data[i]['email'], data[i]['contactNo'], data[i]['companyName'],editButton,deleteButton);

                }

            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }

        });
    }

    function newRow(name,email,contactNo,customer,editBtn,deleteBtn) {

        $('#tbl_contact').bootstrapTable('insertRow', {
            index: 0,
            row: {
                state: '',
                name: name,
                email: email,
                contactNo: contactNo,
                customer: customer,
                edit:editBtn,
                deleteBtn:deleteBtn
            }
        });

    }

    function deleteContact(con_id) {
        contactid=con_id;

        $.ajax({
            type: 'POST',
            url: 'deletecontact/'+con_id,
            //dataType: 'json',

            success: function (data) {
                msg('Successfully Deleted.... Thank You... !');
                getAllContacts();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }

        });
    }



    function resetForm() {
        $('#frm-contact')[0].reset();
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


    function isValidEmailAddress(emailAddress) {
        var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
        return pattern.test(emailAddress);
    };


</script>
</body>

</html>

