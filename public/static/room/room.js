var wsServer = 'ws://shikii.cc';
if( window.location.host='www.xdd.cn')
    wsServer = 'ws://127.0.0.1:8088';

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