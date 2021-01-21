var http = require('http'),
qs = require('querystring');
var server = http.createServer(function(req, res) {
	if (req.method === 'POST') {
		var body = '';
		req.on('data', function(chunk) {
		  body += chunk;
		});
		req.on('end', function() {
			var data = JSON.parse(body);
			'use strict';
			const RippleAPI = require('ripple-lib').RippleAPI; // require('ripple-lib')
			if(data.method === 'create_address'){
				const api = new RippleAPI({
				  server: 'wss://s1.ripple.com' // Public rippled server
				});
				api.connect().then(() => {
				  /* begin custom code ------------------------------------ */
				  
				  return api.generateAddress();

				}).then(info => {
					var obj = info;

				  /* end custom code -------------------------------------- */
				}).catch(console.error);
				
			}
			else if(data.method === 'create_rawtx'){
				const address = data.fromaddr;
				const secret = data.privatekey;

				const api = new RippleAPI({
				  server: 'wss://s1.ripple.com' // Public rippled server
				});
				const instructions = {maxLedgerVersionOffset: 5};

				const payment = {
				  source: {
					address: address,
					maxAmount: {
					  value: data.amount,
					  currency: 'XRP'
					}
				  },
				  destination: {
					address: data.toaddr,
					amount: {
					  value: data.amount,
					  currency: 'XRP'
					}
				  }
				};

				function quit(message) {
                  console.log(message);
                }
                
                function fail(message) {
                  console.error(message);
                }

				api.connect().then(() => {
				  console.log('Connected...');
				  return api.preparePayment(address, payment, instructions).then(prepared => {
					console.log('Payment transaction prepared...');
					const {signedTransaction} = api.sign(prepared.txJSON, secret);
					console.log('Payment transaction signed...');
					api.submit(signedTransaction).then(quit, fail);
				  });
				}).catch(fail);
			}
			res.writeHead(200);
			//res.end(JSON.stringify(info));
		});
	} else {
		res.writeHead(404);
		res.end();
	}
});
server.listen(8085, '45.32.105.246');
