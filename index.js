/**
 * Created by mh122354 on 3/28/2017.
 */

var app = require('express')();
var morgan = require('morgan');

var server = app.listen(3000);

app.use(morgan('tiny'));
var io = require('socket.io').listen(server);
var clientData={
    customerId:0,
     orderId:'',
    prodId:''
};

io.sockets.on('connection',function(socket){

    socket.emit('hello',{hello:socket.id});


    socket.on('customer',function(data){
        clientData.customerId = data.hello;
    });

    socket.on('completed',function(data){

        if(clientData.customerId.length==0){
            console.log("No Client Yet");
        }else{
            if(io.sockets.connected[clientData.customerId]) {
                clientData.prodId=data[0];
                clientData.orderId=data[1];
                console.log(JSON.stringify(clientData));
                io.sockets.connected[clientData.customerId].emit('updateStatus', clientData);
            }

        }
    });

});




