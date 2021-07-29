<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <h1 class="mt-5"><?= $title; ?></h1>

        <a href="#form" data-toggle="modal" class="btn btn-primary mt-3" onclick="submit('add')">Create Contact</a>

        <div class="py-4">
            <nav>
                <form class="form-inline float-left">
                    <input class="form-control mr-sm-2" type="text" name="search-text" id="search-text" placeholder="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form>
                <div class="float-right" id="pagination_link"></div>
            </nav>
        </div>

        <table class="table mt-5" id="contact_table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Contact Number</th>
                    <th>Action</th>
                    </tr>
            </thead>
            <tbody id="target">

            </tbody>
        </table>

        <div class="modal fade" id="form" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="container">
                        <div class="modal-header">
                            <h1 id="create-title">Create Contact</h1>
                            <h1 id="edit-title">Edit Contact</h1>
                        </div>
                        <div class="p-2">
                            <center>
                                <font color ='red'>
                                    <p id="message"></p>
                                </font>
                            </center>
                            <table class="table table-borderless">
                                <tr>
                                    <td>Name: </td>
                                    <td>
                                        <input type="text" name="name" class="form-control">
                                        <input type="hidden" name="phone_id" value="">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Contact Number: </td>
                                    <td><input type="text" name="contact" class="form-control"></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        <button type="button" id="add-btn" onclick="addData()" class="btn btn-primary mr-2">Add Contact</button>
                                        <button type="button" id="edit-btn" onclick="updateData()" class="btn btn-primary mr-2">Update</button>
                                        <button type="button" data-dismiss="modal" class="btn btn-danger">Cancel</button>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
           
        getData(1);

        function getData(page, query){
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url()."index.php/page/getData/" ?>'+page,
                data:{query:query},
                dataType: 'json',
                success: function(data){
                    // var rows = '';
                    // for(var i=0; i<data.length; i++){
                    //     rows += '<tr>'+
                    //                 '<td>' + (i+1) + '</td>' +
                    //                 '<td>' + data[i].name + '</td>' +
                    //                 '<td>' + data[i].contact_num + '</td>' +
                    //                 '<td><a href="#form" data-toggle="modal" class="btn btn-primary" onclick="submit('+ data[i].phone_id +')">Edit</a><a class="btn btn-danger ml-3" onclick="deleteData('+data[i].phone_id+')">Delete</a></td>' +
                    //             '</tr>';
                    // }
                    // $('#target').html(rows);
                    $('#target').html(data.contact_table);
                    $('#pagination_link').html(data.pagination_link);
                }
            });
        }

        $('#search-text').keyup(function(){
            var search = $(this).val();
            if(search !== '') {
                getData(1, search);
            } else {
                getData(1);
            }
        })

        $(document).on("click", ".pagination li a", function(event){
            event.preventDefault();
            var page = $(this).data("ci-pagination-page");
            getData(page);
        });

        function addData(){
            var name = $("[name = 'name']").val();
            var contact_num = $("[name = 'contact']").val();

            $.ajax({
                type: 'POST',
                data: 'name='+name+'&contact_num='+contact_num,
                url: '<?php echo base_url().'index.php/page/addData' ?>',
                dataType: 'json',
                success: function(data){
                    $("#message").html(data.message);

                    if (data.message == '') {
                        $("#form").modal('hide');
                        getData(1);


                        $("[name = 'name']").val('');
                        $("[name = 'contact']").val('');
                    }
                }
            });
        }

        function submit(x){
            if(x == 'add'){
                $('#add-btn').show();
                $('#create-title').show();
                $('#edit-btn').hide();
                $('#edit-title').hide();
            } else{
                $('#add-btn').hide();
                $('#create-title').hide();
                $('#edit-btn').show();
                $('#edit-title').show();

                $.ajax({
                    type: 'POST',
                    data: 'phone_id=' + x,
                    url: '<?= base_url()."index.php/page/getId" ?>',
                    dataType: 'json',
                    success: function(data){    
                        $('[name = "name"]').val(data[0].name);
                        $('[name = "phone_id"]').val(data[0].phone_id);
                        $('[name = "contact"]').val(data[0].contact_num);
                    }
                });
            }
        }

        function updateData(){
            var name = $("[name = 'name']").val();
            var phone_id = $("[name = 'phone_id']").val();
            var contact_num = $("[name = 'contact']").val();

            $.ajax({
                type: 'POST',
                data: 'name='+name+'&phone_id='+phone_id+'&contact_num='+contact_num,
                url: '<?php echo base_url().'index.php/page/updateData' ?>',
                dataType: 'json',
                success: function(data){
                    $("#message").html(data.message);

                    if (data.message == '') {
                        $("#form").modal('hide');
                        getData(1);
                    }
                }
            });
        }

        function deleteData(phone_id){

            var question = confirm('Are you sure you want to delete this data?');

            if(question){
                $.ajax({
                    type: 'POST',
                    data: 'phone_id=' + phone_id,
                    url: '<?php echo base_url()."index.php/page/deleteData" ?>',
                    success: function(){
                        getData(1);
                    }

                });
            }
        }

    </script>
</body>
</html>