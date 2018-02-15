<?php
$db = mysqli_connect('localhost', 'root', '' ,'nodephp');

session_start();
if(!$_SESSION['uname']) {
    header("location:login.php");
}
?>

<html>
<head>
    <link rel="stylesheet" href="css/bootstrap.css">
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>

    <!-- Data Tables -->
    <script src="js/dataTables.js"></script>
    <script src="js/dataTables.bootstrap.js"></script>

    <link rel="stylesheet" href="css/dataTables.css">

    <!-- bootbox -->
    <script src="bootbox.min.js"></script>
    <script>

        // display
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

        // delete
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


        $(document).ready(function () {
            $('#btn-update').hide();

            // insert
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

                    }
                });
                alertData();
            });




        });
    </script>
</head>
<body>


    <div class="container">
        <div class="row">
            <div class="col-md-3 ">
            </div>
            <div class="col-md-9">
                <br><br><br>
                <div class="row">
                    <div class="col-sm-2">
                        <a href="" type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#myModal">Add New Record</a>
                    </div>
                    <div class="col-sm-8">
                        <a href="" type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#myImportModal">Import</a>
                        <a href="" type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#myExportModal">Export</a>
                    </div>
                    <div class="col-sm-2">
                        <a href="logout.php" type="button" class="btn btn-danger btn-sm" >Logout</a>
                    </div>
                </div>
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
                        <form action="" method="post" enctype="multipart/form-data">

                            <div class="form-group">
                                <label for="pwd">Import CSV:</label>
                                <input type="file" name="import_csv_file" class="form-control" id="import_csv_file">
                            </div>

                            <input type="submit" name="btn_import" class="btn btn-default" value="import">
                        </form>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div>


        <!--The Export Modal -->
        <div class="modal fade" id="myExportModal">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Export Data</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <form action="" method="post" enctype="multipart/form-data">

                            <div class="form-group">
                                <label for="pwd">Export With:</label>
                                <select name="export" class="form-control">
                                    <option>---SELECT---</option>
                                    <option value="Export.csv">CSV</option>
                                    <option value="Export.pdf">PDF</option>
                                    <option value="Export.txt">TEXT</option>
                                </select>
                            </div>

                            <input type="submit" name="btn_export" class="btn btn-default" value="Export">
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
    </div>

<script>
    //edit
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


                }
            });
            alert("Record is sucessfully updated !!!");
        });

    }
</script>
</body>
</html>
<?php
if(isset($_REQUEST['btn_import']))
{
    $f=$_FILES["import_csv_file"]["tmp_name"];
    $f1=fopen($f,"r");

    while (($d = fgetcsv($f1, 1000, ",")) !== FALSE)
    {

   @     $import="insert into registration(fname,lname,email,state,city,gender,hobby,img,display) values('$d[0]','$d[1]','$d[2]','$d[3]','$d[4]','$d[5]','$d[6]','$d[7]','$d[8]')";

        $db->query($import);
    }
    fclose($f1);
    echo "<script>
 bootbox.alert({
                    message: 'Your File is Successfully Imported !!!',
                    size: 'small'
                });

</script>";
}

if(isset($_REQUEST['btn_export']))
{

    //echo "export";
    $fname=$_REQUEST['export'];
    $export="select * from registration";
    $result=$db->query($export);
    $file = fopen($fname,"w");
    header('Content-Type: application/csv');
    header('Content-Disposition: attachment; filename="'.$file.'";');
    fwrite($file, '"ID","Fname","Lname","Email","State","City","Gender","Hobby","Image_name"\n');
    while($d=$result->fetch_array())
    {

        foreach ($d as $line)
        {

            //fputcsv($file,explode('\t',$line));
            fwrite($file,$line);
            fwrite($file,",");

        }
        fwrite($file,"\n");
    }

    fclose($file);
    echo "<script>
 bootbox.alert({
                    message: 'Your File is Successfully Exported !!!',
                    size: 'small'
                });

</script>";
}
?>


