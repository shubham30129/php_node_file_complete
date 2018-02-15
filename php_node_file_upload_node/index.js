var express = require("express");
var bodyparser=require("body-parser");

var app = express();
app.use(bodyparser.urlencoded({extended:false}));

var cors=require("cors");
app.use(cors());

var session=require('express-session');
app.use(session({secret: 'mysecretkey'}));

var mysql = require("mysql");
var db = mysql.createConnection({
    hostname:"localhost",
    user:"root",
    password:"",
    database:"nodephp"
});
db.connect((err) => {
    if(err)
    {
        throw  err;
    }
    else
    {
        console.log("connected...");
    }
});
// insert
app.post("/insert",(req,res)=>{

    var fname1=req.body.fname;
    var lname1=req.body.lname;
    var email1=req.body.email;
    var state1=req.body.state;
    var city1=req.body.city;
    var gender1=req.body.gender;
    var hoby1=req.body.hobby;
    var filename1=req.body.filename;
    console.log(fname1 +"\t"+ lname1 +"\t"+ email1 +"\t"+ state1 +"\t"+ city1 +"\t"+ gender1 +"\t"+ hoby1 +"\t"+ filename1 +"\t"+ 'yes');

    var qry ="insert into registration (fname,lname,email,state,city,gender,hobby,img,display) values('"+ fname1 +"','"+ lname1 +"','"+ email1 +"','"+ state1 +"','"+ city1 +"','"+ gender1 +"','"+ hoby1 +"','"+ filename1 +"','yes')";

    db.query(qry,(err) => {
        if(err) throw err;
        console.log("1 record is inserted...");
    });

});
// display
app.get("/display",(req,res)=>{
    console.log("recive");
    var qry = "SELECT * FROM `registration` WHERE display ='yes' order by id desc";
    db.query(qry,(err,result)=>{
        var html ="<table  id='example'><thead><tr><td>Fname</td><td>Lname</td><td>Email</td><td>State</td><td>City</td><td>Gender</td><td>Hobby</td><td>Profile</td><td>Edit</td><td>Delete</td></tr></thead>";
        html +="<tbody>";
        for(v of result)
        {

            html +="<tr id="+v.id+"><td>"+v.fname+"<input type='hidden' name='fname' value="+v.fname+"></td><td>"+v.lname+"</td><td>"+v.email+"</td><td>"+v.state+"</td><td>"+v.city+"</td><td>"+v.gender+"</td><td>"+v.hobby+"</td><td><img src=imgs/"+v.img+" height=90 width='100'></td><td><a type=button class='btn btn btn-large btn-primary' id='edit' onclick=edit("+v.id+") btn-info btn-lg data-toggle=modal data-target=#myModal >Edit</a></td><td><input type='text' style='display: none' id='did' value="+v.id+"><a  onclick='del(this)' id="+v.id+" class='del btn btn-large btn-primary' >Delete</a></td></tr>";

        }
        html +="</tbody>";
        html +="<tfoot><tr><tr><td>Fname</td><td>Lname</td><td>Email</td><td>State</td><td>City</td><td>Gender</td><td>Hobby</td><td>Profile</td><td>Edit</td><td>Delete</td></tr></tfoot>";

        html +="</table>";
        res.send(html);

    });
});
// delete
app.get('/delete',(req,res) => {
    var id =req.query.id;
    var qry="update registration set display='none' where id='"+ id +"'";
    db.query(qry,(err) => {
        if(err)
        {
            throw  err;
        }
        else
        {

            console.log("1 record deleted ...");
        }

    });
});

// update get data
app.get("/getdata",(req,res)=>{
    var id=req.query.id;

    var qry="select * from registration where id='"+ id +"'";
    db.query(qry,(err,result)=>{
        if(err){
            throw err;
        }
        //console.log(result);
        res.send(result);
    });
});
// update
app.post('/edit',(req,res) => {
    var id=req.body.hid;
    var fname1=req.body.fname;
    var lname1=req.body.lname;
    var email1=req.body.email;
    var state1=req.body.state;
    var city1=req.body.city;
    var gender1=req.body.gender;
    var hoby1=req.body.hobby;
    var filename1=req.body.filename;

    var qry="update registration set fname='"+ fname1 +"', lname='"+ lname1 +"',email='"+ email1 +"',state='"+ state1 +"',city='"+ city1 +"',gender='"+ gender1 +"',hobby='"+ hoby1 +"',img='"+ filename1 +"' where id='"+ id +"'";
    console.log(qry);



    db.query(qry,(err) => {
        if(err) throw err;
        console.log("1 record is updated...");
    });
});


app.listen(1234,()=>{
	console.log("server is start");
});