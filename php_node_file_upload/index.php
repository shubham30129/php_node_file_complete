<?php
$db = mysqli_connect('localhost', 'root', '' ,'nodephp');

session_start();
if(!$_SESSION['uname']) {
    header("location:login.php");
}
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
    <!-- bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- Data Tables -->
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">

    <!-- bootbox -->
    <script src="bootbox.min.js"></script>

    <!-- Custome -->
    <script type="text/javascript">
		        $(document).ready(function(){

                    function display() {
                        $.ajax({
                            type:'GET',

                            url:'http://localhost:1234/display',
                            success:function(res)
                            {

                                console.log(res);
                                $('#display').html(res);
                                $("#example").dataTable({
                                    "lengthMenu": [[5, 10,25, 50, -1], [5,10, 25, 50, "All"]]
                                });
                            }
                        });
                    }
                    display();
                    $('#btn-update').hide();
                    $('#state').on('change', function() {
                        var stateID = $(this).find('option:selected').attr('id');
                        //alert( stateID );

                        if(stateID)
                        {
                            $.ajax({
                                type:'GET',
                                url:'show_cities.php?state_id='+stateID,
                                data:state_id=+stateID,
                                success:function(html){
                                    $("#city").html(html);
                                }
                            });
                        }


                    });
                    $('#btn-insert').click(function () {
                        var fname=$('#fname').val();
                        var lname=$('#lname').val();
                        var email=$('#email').val();
                        var state=$('#state').val();
                        var city=$('#city').val();
                        var gender = [];
                        $.each($("input[name='gender']:checked"), function(){
                            gender.push($(this).val());
                        });

                        var hoby = [];
                        $.each($("input[name='hoby']:checked"), function(){
                            hoby.push($(this).val());
                        });
                        hoby.join(", ");
                        //hoby.toString();
                        var fileInput = document.getElementById('img');
                        var filename = fileInput.files[0].name;
                        var gn =gender.toString();
                        var hb=hoby.toString();
                      $.ajax({
                            type:'POST',
                            url:'http://localhost:1234/insert',
                            data:{
                                    'fname':fname,
                                    'lname':lname,
                                    'email':email,
                                    'state':state,
                                    'city':city,
                                    'gender':gn,
                                    'hobby':hb,
                                    'filename':filename
                                },
                            success:function(res)
                            {
                                <?php

                                    move_uploaded_file($_FILES['img']['tmp_name'], 'imgs/' . $_FILES['img']['name']);
                                ?>


                            }
                        });
                        alertData();
                    });


                });

	</script>
</head>
<body>
<form method="post" enctype="multipart/form-data">


    <div class="container">
        <div class="row">
            <div class="col-md-3 ">
                <ul class="">

                </ul>
            </div>
            <div class="col-md-9">
                <br><br><br>
                <div class="row">
                    <div class="col-sm-2">
                        <a href="" type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#myModal">Add New Record</a>
                    </div>
                    <div class="col-sm-8">
                        <a href="" type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#myImportModal">Import</a>
                    </div>
                    <div class="col-sm-2">
                        <a href="logout.php" type="button" class="btn btn-danger btn-sm" >Logout</a>
                    </div>
                </div>
                <!-- Trigger the modal with a button -->

                <!-- href=?id="+ v.id+"&fname="+v.fname +"&lname="+v.lname +"&email="+v.email +"&state="+v.state +"&city="+v.city +"  -->
                <!-- Modal -->
                <div class="modal fade" id="myModal" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Modal Header</h4>
                            </div>
                            <div class="modal-body">
                                <form action="" id="myform" method="post" >
                                    <div class="form-group">
                                        <label >First Name:</label>
                                        <input type="hidden" name="hid">
                                        <input type="text" class="form-control" id="fname" placeholder="Enter First Name" name="fname" required>
                                    </div>
                                    <div class="form-group">
                                        <label >Last Name:</label>
                                        <input type="text" class="form-control" id="lname" placeholder="Enter Last Name" name="lname" required>
                                    </div>
                                    <div class="form-group">
                                        <label >Email:</label>
                                        <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" required>
                                    </div>
                                    <div class="form-group">
                                        <label >State:</label>
                                        <select name="state" id="state" class="form-control" >
                                            <option>Select State</option>
                                            <?php
                                            $res = $db->query("select * from state");

                                            while ($d = $res->fetch_array()) {

                                                echo "<option id=$d[0] value=$d[1]>$d[1]</option>";
                                            }
                                            ?>
                                        </select>

                                    </div>
                                    <div class="form-group">
                                        <label >City:</label>
                                        <select name="city" id="city" class="form-control" >
                                            <option>Select City</option>


                                        </select>

                                    </div>
                                    <div class="form-group">
                                        <label >Gender:</label>
                                        <div id="g">
                                        Male <input type="radio" name="gender" class="male" value="male" id="gender">
                                        Female <input type="radio" name="gender" class="female" value="female" id="gender">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label >Hobbies:</label>
                                        <div class="h">
                                        Cricket <input type="checkbox" name="hoby" value="cricket" id="hoby">
                                        Hockey  <input type="checkbox" name="hoby" value="hockey" id="hoby">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label >Profile Pic:</label>
                                        <input type="file" id="img" name="img" accept="*.jpg" required>

                                    </div>
                                    <input type="submit" class="btn btn-default" name="insert"  id="btn-insert"   value="Insert">
                                    <input type="submit" class="btn btn-default" id="btn-update"  value="Update">
                                </form>                        </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default"  data-dismiss="modal">Close</button>
                            </div>
                        </div>
                        <?php


                        if(isset($_REQUEST['$_FILES[img]'])){
                            move_uploaded_file($_FILES['img']['tmp_name'], 'imgs/' . $_FILES['img']['name']);
                        }

                        ?>

                    </div>
                </div>

            </div>

        </div>
        <!-- The IMport Modal -->
        <div class="modal fade" id="myImportModal">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Modal Heading</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <form action="import.php" method="post" enctype="multipart/form-data">

                            <div class="form-group">
                                <label for="pwd">Import CSV:</label>
                                <input type="file" name="import_csv_file" class="form-control" id="import_csv_file">
                            </div>

                            <button type="submit" name="btn_import" class="btn btn-default">Submit</button>
                        </form>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div>


        <div id="display">

        </div>
        <script>
            function alertData() {
                bootbox.alert({
                    message: "Record is Successfully Inserted !!!",
                    size: 'small'
                });
            }
            function del(z) {
                var id = z.id;
//            alert(id);
                bootbox.confirm({
                    message: " Do you want to delete it?",
                    buttons: {
                        confirm: {
                            label: 'Yes',
                            className: 'btn-success'
                        },
                        cancel: {
                            label: 'No',
                            className: 'btn-danger'
                        }
                    },
                    callback: function (result) {
                        var a=result;
                        if(a)
                        {
                            $.ajax({
                                type:'GET',
                                url:'http://localhost:1234/delete?id='+id,
                                data:{
                                    'id':id

                                },
                                success:function(res)
                                {
                                    // alert(res);
                                    alert();

                                }
                            });
                            document.getElementById(id).classList.add("hide");
                            document.getElementById(id).classList.remove("show");

                        }

                    }
                });

            }

            function edit(id) {
                var eid=id;


                $.ajax({
                    type: "GET",
                    url: "http://localhost:1234/getdata?id="+eid,
                    success: function (data) {
                        var len=data.length;

                        for(var x in data) {
                            var hid=data[x].id;
                            var fname=data[x].fname;
                            var lname=data[x].lname;
                            var email=data[x].email;
                            var state=data[x].state;
                            var city=data[x].city;
                            var gender =data[x].gender;
                            var hoby =data[x].hobby;

                            //city
                            if(data[x].state==="gujarat")
                            {
                                var html="<option value='surat'> surat</option>"
                            }
                            else if(data[x].state=="maharashtra")
                            {
                                var html="<option value='pune'> pune</option>"
                            }
                            //gender
                            if(data[x].gender==="male")
                            {
                                var html1="Male <input type=radio name=gender class=male value=male id=gender checked>";
                                 html1 +="Female <input type=radio name=gender class=female value=female id=gender >";
                                $("#g").html(html1);
                            }
                            else if(data[x].gender=="female")
                            {
                                var html1="Male <input type=radio name=gender class=male value=male id=gender >";
                                html1 +="Female <input type=radio name=gender class=female value=female id=gender checked>";
                                $("#g").html(html1);
                            }
                            // hobies
                            if(data[x].hobby==="cricket")
                            {
                                var html2="Cricket <input type=checkbox name=hoby value=cricket id=hoby checked>";
                                html2 +="Hockey  <input type=checkbox name=hoby value=hockey id=hoby>";
                                $(".h").html(html2);
                            }
                            else if(data[x].hobby=="hockey")
                            {
                                var html2="Cricket <input type=checkbox name=hoby value=cricket id=hoby >";
                                html2 +="Hockey  <input type=checkbox name=hoby value=hockey id=hoby checked>";
                                $(".h").html(html2);
                            }
                            else if(data[x].hobby=="cricket,hockey")
                            {
                                var html2="Cricket <input type=checkbox name=hoby value=cricket id=hoby checked>";
                                html2 +="Hockey  <input type=checkbox name=hoby value=hockey id=hoby checked>";
                                $(".h").html(html2);
                            }
                            document.getElementById("fname").value=fname;
                            document.getElementById("lname").value=lname;
                            document.getElementById("email").value=email;
                            document.getElementById("state").value=state;
                            $("#city").html(html);


                        }
                    }
                });

                $('#btn-update').show();
                $('#btn-insert').hide();
                $('#btn-update').click(function () {



                    var fname=$('#fname').val();
                    var lname=$('#lname').val();
                    var email=$('#email').val();
                    var state=$('#state').val();
                    var city=$('#city').val();
                    var gender = [];
                    $.each($("input[name='gender']:checked"), function(){
                        gender.push($(this).val());
                    });

                    var hoby = [];
                    $.each($("input[name='hoby']:checked"), function(){
                        hoby.push($(this).val());
                    });
                    hoby.join(", ");
                    //hoby.toString();
                    var fileInput = document.getElementById('img');
                    var filename = fileInput.files[0].name;

                    $.ajax({
                        type:'POST',
                        url:'http://localhost:1234/edit',
                        data:{
                            'hid':eid,
                            'fname':fname,
                            'lname':lname,
                            'email':email,
                            'state':state,
                            'city':city,
                            'gender':gender.toString(),
                            'hobby':hoby.toString(),
                            'filename':filename
                        },
                        success:function(res)
                        {
                            <?php
                            move_uploaded_file($_FILES['img']['tmp_name'], 'imgs/' . $_FILES['img']['name']);
                            ?>

                        }
                    });
                    alert("Record is sucessfully updated !!!");
                });

            }



        </script>


</form>
</body>
</html>


