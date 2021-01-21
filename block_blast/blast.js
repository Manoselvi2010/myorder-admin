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
		var bitcoin = require('bitcoin');
		var baddress = '';

		var client = new bitcoin.Client({
		  host: 'localhost',
		  port: 30008,
		  user: 'blastxuser',
		  pass: 'dasffds8JUDYMqtekfE8PHvE6Yq3Gf4uNJjXp2'
		});
		  if(data.method === 'create_address'){

		  	var batch = [];
			  batch.push({
			    method: 'getnewaddress',
			    params: ['myaccount']
			  });

			client.cmd(batch, function(err, address, resHeaders) {
			  if (err) return console.log(err);		

			 baddress = address;

			});	


		setTimeout(function() {

				    var obj = {
						'address' : baddress,
						'publickey' : '',
						'wif' : '',
						'privatekey' : ''
				};		 	
			res.writeHead(200);
	     	res.end(JSON.stringify(obj));
		},5000);

		}else if (data.method == 'transacrion_his') {

			 	var batch = [];
			  batch.push({
			    method: 'listtransactions',
			    params: ['myaccount']
			  });

			client.cmd(batch, function(err, history, resHeaders) {
			  if (err) return console.log(err);		

			 bhistory = history;

			});	


		setTimeout(function() {

				    var obj = {
						'transaction' : bhistory,
						
				};		 	
			res.writeHead(200);
	     	res.end(JSON.stringify(obj));
		},5000);


		}

		return false;

	
		 	res.writeHead(200);
	     	res.end(JSON.stringify(obj));
	

      // setTimeout(res.end(JSON.stringify(obj)), 1000);
    });
  } else {
    res.writeHead(404);
    res.end();
  }
});

server.listen(8340, '62.171.168.72');
