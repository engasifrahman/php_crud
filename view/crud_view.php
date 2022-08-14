<!DOCTYPE html>
<html lang="en">
    <head>
        <title>CRUD Operation</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    </head>

    <body>
        <div class="container">
            <div class="row">
                <div class="col-sm-12 m-auto text-center pt-3">

                <div id="success_alert" class="alert alert-success alert-dismissible fade show" role="alert" style="display: none">
                    <div id="success_msg"></div>
                    <!-- <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> -->
                </div>
                <div id="warning_alert" class="alert alert-warning alert-dismissible fade show" role="alert" style="display: none">
                    <div id="warning_msg"></div>
                    <!-- <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> -->
                </div>
                <div id="error_alert" class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none">
                    <div id="error_msg"></div>
                    <!-- <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> -->
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4 class="float-left">CRUD</h4>
                        <button class="float-right btn btn-info btn-sm" id="add" onclick="$('#list').hide(); $('#add').hide(); $('#form').show(); $('#cancel').show();">Add</button>
                        <button class="float-right btn btn-info btn-sm" id="cancel" style="display: none" onclick="$('#list').show(); $('#add').show(); $('#form').hide(); $('#cancel').hide();">Cancel</button>
                    </div>
                    <div class="card-body">
                        <div class="col-md-12" id="list">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Father</th>
                                        <th scope="col">Mother</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Phone</th>
                                        <th scope="col">Address</th>
                                        <th scope="col">Entry Date</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="list_data">
                                    
                                </tbody>
                            </table>
                        </div>

                        <div  class="col-md-12" id="form" style="display: none">
                            <form method="post" id="form_data">
                                <div class="form-row text-left">
                                    <div class="form-group col-md-4">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="father">Father</label>
                                        <input type="text" class="form-control" id="father" name="father" placeholder="Enter Father Name" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="mother">Mother</label>
                                        <input type="text" class="form-control" id="mother" name="mother" placeholder="Enter Mother Name" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email Address" required>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="phone">Phone</label>
                                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Phone Number" required>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="address">Address</label>
                                        <input type="text" class="form-control" id="address" name="address" placeholder="Enter Address" required>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label for="entry_date">Entry Date</label>
                                        <input type="date" class="form-control" id="entry_date" name="entry_date" required>
                                    </div>
                                </div>
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    </div>
            </div>
        </div>
    </body>

    <script>
        //BEGIN CUSTOMER CURD
        var id;
        //initialize the customer list
        list();

        //customer list function that will retrieve customer list
        function list(){
            $.ajax({
                type: "GET",
                url: '/list',
                data: '',
                success: function(response) {
                    var res = JSON.parse(response);
                    console.log(res);
                    $("#list_data").empty();
                    var list = res.data.list;
                    //console.log(list);

                    Object.values(list).forEach(function(item, index) {
                        //console.info(item)
                        $("#list_data").append(`
                            <tr class="text-center">
                                <td>`+(index+1)+`</td>
                                <td>`+item.name+`</td>
                                <td>`+item.father+`</td>
                                <td>`+item.mother+`</td>
                                <td>`+item.email+`</td>
                                <td>`+item.phone+`</td>
                                <td>`+item.address+`</td>
                                <td>`+item.entry_date+`</td>
                                <td>
                                    <button class="btn btn-info btn-sm" onclick="edit(`+item.id+`)">Edit</button>
                                    <button class="btn btn-danger btn-sm" onclick="destroy(`+item.id+`)">Delete</button>
                                </td>
                            </tr>
                        `);
                    });
                },
                error: function (request, status, error) {
                    console.error('request: ' +request);
                    console.error('status: ' +status);
                    console.error('error: ' +error);
                }
            });
        }

        //customer from data submit event, it will works based on id,
        //if id available means update customer
        //if not available means store customer
        $('#form_data').submit(function (e){
            e.preventDefault();
            if(id)
            {
                $.ajax({
                    type:'POST',
                    url:'/update',
                    data: $(this).serialize() + "&id=" + id,
                    success:function(response) {
                        var res = JSON.parse(response);
                        //console.log(res);
                        if(!res.data.error)
                        {
                            if(res.data.success)
                            {
                                $('#success_msg').text(res.data.success); 
                                $('#success_alert').show();
                                $('#success_alert').slideUp(3000);
                            }
                            else if(res.data.warning){
                                $('#warning_msg').text(res.data.warning); 
                                $('#warning_alert').show();
                                $('#warning_alert').slideUp(3000);
                            }

                            $('#list').show(); 
                            $('#add').show(); 
                            $('#form').hide(); 
                            $('#cancel').hide();
                            list();
                            $('#form_data')[0].reset();
                            id = null;
                        }
                        else
                        {
                            
                            $('#error_msg').text(res.error_msg+' '+res.data.error); 
                            $('#error_alert').show();
                            $('#error_alert').slideUp(5000);
                            
                        }
                    },

                    error: function (request, status, error) {
                    console.error('request: ' +request);
                    console.error('status: ' +status);
                    console.error('error: ' +error);
                    }
                });
            }
            else
            {
                $.ajax({
                    type:'POST',
                    url:'/store',
                    data: $(this).serialize(),
                    success:function(response) {
                        var res = JSON.parse(response);
                        console.log(res);
                    
                        if(!res.data.error)
                        {
                            if(res.data.success)
                            {
                                $('#success_msg').text(res.data.success); 
                                $('#success_alert').show();
                                $('#success_alert').slideUp(3000);
                            }
                            else if(res.data.warning){
                                $('#warning_msg').text(res.data.warning); 
                                $('#warning_alert').show();
                                $('#warning_alert').slideUp(3000);
                            }

                            $('#list').show(); 
                            $('#add').show(); 
                            $('#form').hide(); 
                            $('#cancel').hide();
                            list();
                            $('#form_data')[0].reset();
                            id = null;
                        }
                        else
                        {
                            
                            $('#error_msg').text(res.error_msg+' '+res.data.error); 
                            $('#error_alert').show();
                            $('#error_alert').slideUp(5000);
                            
                        }
                        
                    },

                    error: function (request, status, error) {
                    console.error('request: ' +request);
                    console.error('status: ' +status);
                    console.error('error: ' +error);
                    }
                });
            }
        });

        //edit function it will retrieve customer data based on id,
        function edit($id){
            id = $id;
            $.ajax({
                type:'POST',
                url:'/edit',
                data: {id : id},
                success:function(response) {
                    var res = JSON.parse(response);
                    console.log(res);
                    var customer = res.data.customer;
                    $('#name').val(customer.name);
                    $('#father').val(customer.father);
                    $('#mother').val(customer.mother);
                    $('#email').val(customer.email);
                    $('#phone').val(customer.phone);
                    $('#address').val(customer.address);
                    $('#entry_date').val(customer.entry_date);

                    $('#list').hide(); 
                    $('#add').hide(); 
                    $('#form').show(); 
                    $('#cancel').show();
                },

                error: function (request, status, error) {
                console.error('request: ' +request);
                console.error('status: ' +status);
                console.error('error: ' +error);
                }
            });
        }

        //destroy function it will delete customer data based on id,
        function destroy($id){
            id = $id;

            $.ajax({
                type:'POST',
                url:'/destroy',
                data: {id : id},
                success:function(response) {
                    var res = JSON.parse(response);
                    //console.log(res);

                    if(res.data.success)
                    {
                        $('#success_msg').text(res.data.success); 
                        $('#success_alert').show();
                        $('#success_alert').slideUp(3000);
                    }
                    else if(res.data.warning){
                        $('#warning_msg').text(res.data.warning); 
                        $('#warning_alert').show();
                        $('#warning_alert').slideUp(3000);
                    }

                    list();
                    id = null;
                },

                error: function (request, status, error) {
                console.error('request: ' +request);
                console.error('status: ' +status);
                console.error('error: ' +error);
                }
            });
        }

        //END CUSTOMER CURD
    </script>
</html>
