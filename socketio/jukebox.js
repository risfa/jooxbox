var app = require('express')();
var server = require('http').Server(app);
var io = require('socket.io')(server);
var mysql = require('mysql');
// var nodemailer = require('nodemailer');
var whosLogin = [];
var port = 8080;
var db_config = {
	host			: "localhost",
	user			:	"dapps",
	password	:	"l1m4d1g1t",
	database	:	"dapps_xeniel_jukebox5d.com",
	port			: 3306,
};

var connection = mysql.createConnection(db_config);
// connection.connect(function(err) {
    // if (err) throw err;
// });

var pool = mysql.createPool(db_config);

// app.get('/', function (req, res) {
  // res.sendFile(__dirname + '/index.html');
// });

// var smtpConfig = {
//     host: 'smtp.gmail.com',
//     port: 587,
//     // secure: true, // use SSL
//     auth: {
//         user: 'explore@limadigit.com',
//         pass: '5d3xpl0r3'
//     }
// };

process.on('uncaughtException', function (err) {
	// var transporter = nodemailer.createTransport('smtps://error%405dapps.com:alanmr33@5dapps.com');
	// var transporter = nodemailer.createTransport(smtpConfig);
	// var mailOptions = {
	//     from: '"Error Report jkt01" <error@5dapps.com>', // sender address
	//     to: 'alan@limadigit.com, arwin@limadigit.com ,herospalada@limadigit.com, tommy@limadigit.com', // list of receivers
	//     subject: 'Jukebox Server Error ', // Subject line
	//     text: err.stack + err.toString(), // plaintext body
	//     html: err.stack + err.toString() // html body
	// };
	// // send mail with defined transport object
	// transporter.sendMail(mailOptions, function(error, info){
	//     if(error){
	//         return console.log(error);
	//     }
	//     console.log('Message sent: ' + info.response);
	// });
});

io.on('connection', function (socket) {
	socket.on("adduser",function(data) {
		socket.join(data.username);
		socket.join(data.loc);
		socket.join(data.userid);
		socket.id = data.userid;
		socket.username = data.username;
		socket.location = data.loc;
		if(typeof(whosLogin[socket.location]) == "undefined" || socket.location==socket.id) whosLogin[socket.location] = new Array();
		var index = whosLogin[socket.location].indexOf(socket.username+'•♪•'+socket.id);
		if(index > -1) {
			whosLogin[socket.location].splice(index,1);
		}
		whosLogin[socket.location].push(socket.username+'•♪•'+socket.id);
		var result = JSON.stringify(whosLogin[socket.location]);
		io.to(socket.location).emit("whosLogin",result);
	});
	socket.on('disconnect', function() {
		socket.leave(socket.id);
		socket.leave(socket.username);
		socket.leave(socket.location);
		if(typeof(whosLogin[socket.location]) == "undefined") whosLogin[socket.location] = new Array();
		var index = whosLogin[socket.location].indexOf(socket.username);
		if(index > -1) {
			whosLogin[socket.location].splice(index,1);
		}
		var result = JSON.stringify(whosLogin[socket.location]);
		io.to(socket.location).emit("whosLogin",result);
	});
	socket.on("getChatFileWeb",function(data) {
		pool.getConnection(function(erPoll,connection) {
			if(erPoll) {
				console.log(erPoll);return;
			} else {
				connection.query("SELECT * FROM tbl_chat where location_id = '"+data.loc+"' order by chat_id asc", function(err,rows) {
					if (err) {
						console.log(err);
						return;
					}
					rows.push("flagFirstTime");
					var result = JSON.stringify(rows);
					socket.emit("getAllMessage", result);
				});
				connection.release();
			}
		});
	});
	socket.on("getSongPlaylistDaily",function(data) {
		pool.getConnection(function(erPoll,connection) {
			if(erPoll) {
				console.log(erPoll);return;
			} else {
				connection.query("SELECT * FROM tbl_list_playlist_daily where playlist_daily_id = "+data.id+" and location = '"+data.loc+"'",function(err,rows) {
					if (err) {
						console.log(err);
						return;
					}
					var result = JSON.stringify(rows);
					io.to(data.loc).emit("songDaily",result);
				});
				connection.release();
			}
		});
	});
	socket.on("insertSong",function(data) {
		var link="";
		var rowResult = 0;
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth()+1; //January is 0!
		var yyyy = today.getFullYear();
		if(dd<10) {
			dd='0'+dd
		}
		if(mm<10) {
			mm='0'+mm
		}
		today = yyyy+'/'+mm+'/'+dd;
		pool.getConnection(function(erPoll,connection) {
			if(erPoll) {
				console.log(erPoll);return;
			} else {
				connection.query("SELECT * FROM tbl_playlist_daily where from_date <= '" + today + "' and to_date >= '" + today + "' and location = '" + data.loc + "'", function(err,rows) {
					if (err) {
						console.log(err);
						return;
					}
					rowResult = rows.length;
					if(rowResult > 0) {
						if(data.flag == 1) {
							link = data.link;
							var tags = "";
								connection.query("insert into tbl_playlist(user_id,link,title,genre,track_id,location,tag,twitter_image,caption,created,createby) values('"+data.userid+"','"+link+"','"+data.title+"','"+data.genre+"','"+data.id+"','"+data.loc+"','"+tags+"','"+decodeURIComponent(data.img)+"','"+decodeURIComponent(data.cap.replace(/'/g, "\\'"))+"',NOW(),'"+data.username+"')");
								connection.query("SELECT * FROM tbl_top10mostplayed where location = '"+data.loc+"' ORDER BY counter DESC LIMIT 10",function(err,rows) {
									if (err) {
											console.log(err);
											return;
									}
									var result = JSON.stringify(rows);
									io.to(data.loc).emit("mostPlayed",result);
								});
								connection.query("SELECT * FROM tbl_top10player tp, tbl_user tu WHERE tp.user_id = tu.user_id and location = '"+data.loc+"' and tu.register_as != 'admin' and name != 'sponsor' ORDER BY counter DESC LIMIT 10",function(err,rows) {
									if (err) {
											console.log(err);
											return;
									}
									var result = JSON.stringify(rows);
									io.to(data.loc).emit("mostRequest",result);
								});
								connection.query("SELECT * from tbl_playlist where play = 0 and location = '"+data.loc+"' order by playlist_id asc",function(err,rows) {
									if (err) {
											console.log(err);
											return;
									}
									var returnData = {};
									returnData.data = rows;
									returnData.status = true;
									var result = JSON.stringify(returnData);
									io.to(data.loc).emit("playlist",result);
								});
						} else {
							var result = {};
							result.error = 1;
							result.status = false;
							result.statusError = "Please type all and choose your track."
							io.to(data.username).emit("playlist",JSON.stringify(result));
						}
					} else {
						link = data.link;
						var tags = "";
						connection.query("insert into tbl_playlist(user_id,link,title,genre,track_id,location,tag,twitter_image,caption,created,createby) values('"+data.userid+"','"+link+"','"+data.title+"','"+data.genre+"','"+data.id+"','"+data.loc+"','"+tags+"','"+decodeURIComponent(data.img)+"','"+decodeURIComponent(data.cap.replace(/'/g, "\\'"))+"',NOW(),'"+data.username+"')");
						connection.query("SELECT * FROM tbl_top10mostplayed where location = '"+data.loc+"' ORDER BY counter DESC LIMIT 10",function(err,rows) {
							if (err) {
								console.log(err);
								return;
							}
							var result = JSON.stringify(rows);
							io.to(data.loc).emit("mostPlayed",result);
						});
						connection.query("SELECT * FROM tbl_top10player tp, tbl_user tu WHERE tp.user_id = tu.user_id and location = '"+data.loc+"' and tu.register_as != 'admin' and name != 'sponsor' ORDER BY counter DESC LIMIT 10",function(err,rows) {
							if (err) {
								console.log(err);
								return;
							}
							var result = JSON.stringify(rows);
							io.to(data.loc).emit("mostRequest",result);
						});
						connection.query("SELECT * from tbl_playlist where play = 0 and location = '"+data.loc+"' order by playlist_id asc",function(err,rows) {
							if (err) {
								console.log(err);
								return;
							}
							var returnData = {};
							returnData.data = rows;
							returnData.status = true;
							var result = JSON.stringify(returnData);
							io.to(data.loc).emit("playlist",result);
						});
					}
				});
				connection.release();
			}
		});
	});
	socket.on("jukeboxLocation",function(data) {
		pool.getConnection(function(erPoll,connection) {
			if(erPoll) {
				console.log(erPoll);return;
			} else {
				connection.query("SELECT * FROM tbl_top10mostplayed where location = '"+data+"'  ORDER BY counter DESC LIMIT 10",function(err,rows) {
					if (err) {
						console.log(err);
						return;
					}
					var result = JSON.stringify(rows);
					io.to(data).emit("mostPlayed",result);
				});
				connection.query("SELECT * FROM tbl_top10player tp, tbl_user tu WHERE tp.user_id = tu.user_id and location = '"+data+"' and tu.register_as != 'admin' and name != 'sponsor' ORDER BY counter DESC LIMIT 10",function(err,rows) {
					if (err) {
						console.log(err);
						return;
					}
					var result = JSON.stringify(rows);
					io.to(data).emit("mostRequest",result);
				});
				connection.query("SELECT * from tbl_playlist where play = 0 and location = '"+data+"' order by playlist_id asc",function(err,rows) {
					if (err) {
						console.log(err);
						return;
					}
					var returnData = {}
					returnData.data = rows;
					returnData.status = true;
					var result = JSON.stringify(returnData);
					io.to(data).emit("playlist",result);
				});
				connection.release();
			}
		});
	});
	socket.on("jukeboxLocationAdmin",function(data) {
		pool.getConnection(function(erPoll,connection) {
			if(erPoll) {
				console.log(erPoll);return;
			} else {
				connection.query("SELECT * from tbl_playlist where play = 0 and location = '"+data+"' order by playlist_id asc",function(err,rows) {
					if (err) {
						console.log(err);
						return;
					}
					var returnData = {}
					returnData.data = rows;
					returnData.status = true;
					var result = JSON.stringify(returnData);
					io.to(data).emit("playlist",result);
				});
				connection.release();
			}
		});
	});

// 	// new
// 		socket.on("test",function(data) {
// 			console.log(data);
// 		pool.getConnection(function(errPoll,connection) {
// 			if(errPoll) {
// 				console.log(errPoll);return;
// 			} else {
// 					var result = 'test';
// 					io.to(data.loc).emit("test",result);

// 			}
// 		});
// 	})
// //
	socket.on("getNowPlaying",function(data) {
		pool.getConnection(function(errPoll,connection) {
			if(errPoll) {
				console.log(errPoll);return;
			} else {
				connection.query("SELECT * from tbl_playlist where play = 0 and location = '"+data.loc+"' order by playlist_id asc limit 2",function(err1,rows1) {
					if (err1) {
						console.log(err1);
						return;
					}
					var result = JSON.stringify(rows1);
					io.to(data.loc).emit("nowPlaying",result);
				});
				connection.release();
			}
		});
	})

	// test

	socket.on("getNowPlaying2",function(data) {
		pool.getConnection(function(errPoll,connection) {
			if(errPoll) {
				console.log(errPoll);return;
			} else {
				connection.query("SELECT * from tbl_playlist where play = 0 and location = '"+data.loc+"' order by playlist_id asc limit 2",function(err1,rows1) {
					if (err1) {
						console.log(err1);
						return;
					}
					var result = JSON.stringify(rows1);
					io.to(data.loc).emit("nowPlaying2",result);
				});
				connection.release();
			}
		});
	})


	// end
	socket.on("updateSong",function(data) {
		pool.getConnection(function(errPoll,connection) {
			if(errPoll) {
				console.log(errPoll);return;
			} else {
				connection.query("UPDATE tbl_playlist set play = 1 where playlist_id = "+data.id,function(err,rows) {
					if (err) {
						console.log(err);
						return;
					}
					connection.query("SELECT * from tbl_playlist where play = 0 and location = '"+data.loc+"' order by playlist_id asc limit 2",function(err1,rows1) {
						if (err1) {
							console.log(err1);
							return;
						}
						var result = JSON.stringify(rows1);
						io.to(data.loc).emit("nowPlaying",result);
					});
				});
				connection.release();
			}
		});
	});
	socket.on("getPlaylistAdmin",function(data) {
		pool.getConnection(function(errPoll,connection) {
			if(errPoll) {
				console.log(errPoll);return;
			} else {
				connection.query("SELECT * FROM tbl_playlist_daily where location = '"+data.loc+"' ",function(err,rows) {
					if (err) {
						console.log(err);
						return;
					}
					var result = JSON.stringify(rows);
					io.to(data.loc).emit("managePlaylist",result);
				});
				connection.release();
			}
		});
	})
	socket.on("getRecentSong",function(data) {
		pool.getConnection(function(erPoll,connection) {
			if(erPoll) {
				console.log(erPoll);return;
			} else {
				connection.query("SELECT * FROM (SELECT * FROM `tbl_playlist` WHERE play = 1 and user_id = '"+data.userid+"' and location = '"+data.loc+"' ORDER BY playlist_id DESC) AS t GROUP BY title ORDER BY playlist_id DESC LIMIT 10",function(err,rows) {
					if (err) {
						console.log(err);
						return;
					}
					var result = JSON.stringify(rows);
					io.to(data.userid).emit('recentSong', result);
				});
				connection.release();
			}
		});
	});
	socket.on("likedislike",function(data) {
		var like,dislike; 
		pool.getConnection(function(erPoll,connection) {
			if(erPoll) {
				console.log(erPoll);return;
			} else {
				connection.query("SELECT * FROM tbl_playlist where playlist_id = "+data.playlist_id, function(err,rows) {
					if (err) {
						console.log(err);
						return;
					}
					if(data.option == "like") {
						if(rows[0].like !== null) {
							like = rows[0].like;
							like += data.userid+"#";
						} else {
							like = data.userid+"#";
						}
						connection.query("UPDATE tbl_playlist a set a.like = '"+like+"' where playlist_id = "+data.playlist_id+"", function(errs,row) {
							if (err) {
								console.logg(err);
								return;
							}
							connection.query("SELECT * from tbl_playlist where play = 0 and location = '"+data.loc+"' order by playlist_id asc", function(e,r) {
								if (e) {
									console.log(e);
									return;
								}
								var returnData = {}
								returnData.data = r;
								returnData.status = true;
								var result = JSON.stringify(returnData);
								io.to(data.loc).emit("playlist",result);
							});
						});
					} else if(data.option == "dislike") {
						if(rows[0].dislike !== null) {
							dislike = rows[0].dislike;
							dislike += data.userid+"#";
						} else {
							dislike = data.userid+"#";
						}
						connection.query("UPDATE tbl_playlist a set a.dislike = '"+dislike+"' where playlist_id = "+data.playlist_id+"", function(errs,row) {
							if (errs) {
								console.logg(errs);
								return;
							}
							connection.query("SELECT * from tbl_playlist where play = 0 and location = '"+data.loc+"' order by playlist_id asc", function(e,r) {
								if (e) {
									console.log(e);
									return;
								}
								var returnData = {}
								returnData.data = r;
								returnData.status = true;
								var result = JSON.stringify(returnData);
								io.to(data.loc).emit("playlist",result);
							});
							connection.query("SELECT * from tbl_playlist where play = 0 and location = '"+data.loc+"' and playlist_id = "+data.playlist_id, function(e1,r1) {
								if (e1) {
									console.log(e1);
									return;
								}
								var result = JSON.stringify(r1);
								io.to(data.loc).emit("getDislike",result);
							})
						});
					}
				});
				connection.release();
			}
		});
	});
	socket.on("deleteMySong",function(data) {
		pool.getConnection(function(erPoll,connection) {
			if(erPoll) {
				console.log(erPoll);return;
			} else {
				connection.query("SELECT * from tbl_playlist where play = 0 and location = '"+data.loc+"' order by playlist_id asc limit 2",function(err1,rows) {	
					if (err1) {
						console.log(err1);
						return;
					}
					if(typeof rows[0]!="undefined") {
						var status=false;
						if(rows[0].playlist_id==data.playlist_id){
							status=true;
						}
						connection.query("UPDATE tbl_playlist a set a.play = '1' where playlist_id = "+data.playlist_id+"", function(errs,row) {
							if (errs) {
								console.logg(errs);
								return;
							}
							connection.query("SELECT * from tbl_playlist where play = 0 and location = '"+data.loc+"' order by playlist_id asc", function(e,r) {
								if (e) {
									console.log(e);
									return;
								}
								if(status==true){
									connection.query("SELECT * from tbl_playlist where play = 0 and location = '"+data.loc+"' order by playlist_id asc limit 2",function(err1,rows1) {
										if (err1) {
											console.log(err1);
											return;
										}
										var result = JSON.stringify(rows1);
										io.to(data.loc).emit("nowPlaying",result);
									});
								}
								var returnData = {}
								returnData.data = r;
								returnData.status = true;
								var result = JSON.stringify(returnData);
								io.to(data.loc).emit("playlist",result);
							});
						});
					}
				});
				connection.release();
			}
		});
	});
	socket.on("message2", function(data) {
		pool.getConnection(function(erPoll,connection) {
			if(erPoll) {
				console.log(erPoll);return;
			} else {
				var q = "INSERT INTO tbl_chat(chat_id,created,user_id,username,images,chat,location_id) values('DEFAULT','"+data.time+"','"+data.userid+"','"+data.username+"','"+data.image+"','"+data.chat+"','"+data.loc+"')";
				connection.query(q,function(err,result) {
					if(!err) {
						connection.query("SELECT * FROM tbl_chat where chat_id = '"+result.insertId+"'", function(err,rows) {
							if (err) {
								console.log(err);
								return;
							}
							var result = JSON.stringify(rows);
							io.in(data.loc).emit("message2", result);
						});
					} else {
						console.log(q);
						console.log("message: "+err);
					}
				});
				connection.release();
			}
		});
	});
});

server.listen(port);
