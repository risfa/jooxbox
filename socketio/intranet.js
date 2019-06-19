/**
 * Created by kai303 on 2017-04-17.
 */
var app = require('express')();
var server = require('http').Server(app);
var io = require('socket.io')(server);
var mysql = require('mysql');
var nodemailer = require('nodemailer');
var port = 8088;
var db_config = {
    host		: "5dapps.com",
    user		:	"dapps",
    password	:	"admin5D",
    database	:	"dapps_intranet",
    port		: 3306,
};

var connection = mysql.createConnection(db_config);
var pool = mysql.createPool(db_config);

io.on('connection', function (socket) {
    // join chat group
    socket.on("joinGroup",function(data) {
        socket.join(data.chatgroup);
        // join to assign group
    });
    socket.on("sendMessage", function(data) {
       //insert chat
       insertChat(data);
    });
});
server.listen(port);
function insertChat(data) {
    pool.getConnection(function(erPoll,connection) {
        if(erPoll) {
            console.log(erPoll);
            insertChat(data);
            // on error re-insert data
        } else {
            var q = "insert into chat_l (message,user_id,message_date,cg_id) values (" +
                "'"+data.message+"',"+
                "'"+data.user_id+"',"+
                "'"+data.message_date+"',"+
                "'"+data.cg_id+"'" +
                ")";
            connection.query(q,function(err,result) {
                if(!err) {
                    connection.query("SELECT * FROM chatdetail_v " +
                        "where chat_id = '"+result.insertId+"'", function(err,rows) {
                        if (err) {
                            console.log(err);
                            insertChat(data);
                            // on error re-insert data
                        }else{
                            var result = JSON.stringify(rows);
                            io.in(data.chatgroup).emit("newMessage", result);
                        }
                    });
                } else {
                    console.log(err);
                    insertChat(data);
                    // on error re-insert data
                }
            });
            connection.release();
        }
    });
}
