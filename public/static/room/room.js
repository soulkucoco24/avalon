var wsServer = 'ws://127.0.0.1:8089';
var websocket = new WebSocket(wsServer); 
websocket.onopen = function (evt) { 
	console.log("Connected to WebSocket server.");
}; 

websocket.onclose = function (evt) { 
	console.log(evt);
	console.log("Disconnected"); 
}; 

websocket.onmessage = function (evt) { 

	console.log('Retrieved data from server: ' + evt.data); 
}; 

websocket.onerror = function (evt, e) {
	console.log('Error occured: ' + evt.data);
};

function objProperty(Obj) 
{ 
var PropertyList=''; 
var PropertyCount=0; 
for(i in Obj){ 
if(Obj.i !=null) 
PropertyList=PropertyList+i+'属性：'+Obj.i+'\r\n'; 
else 
PropertyList=PropertyList+i+'方法\r\n'; 
}
console.log(PropertyList);
};

function newWS(){
	console.log('sf');
};