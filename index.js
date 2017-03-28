/**
 * Created by mh122354 on 3/28/2017.
 */

var app = require('express')();
var server = require('http').Server(app);
var io = require('socket.io')(server);
var morgan = require('morgan');

server.listen(80);
app.use(morgan('tiny'));

io.on('connection',function(socket){

    socket.emit('news',{hello:'world'});
});