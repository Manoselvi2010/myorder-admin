var bitcoin = require('bitcoin');
var client = new bitcoin.Client({
  host: 'localhost',
  port: 30008,
  user: 'blastxuser',
  pass: 'dasffds8JUDYMqtekfE8PHvE6Yq3Gf4uNJjXp2'
});

// client.getnewaddress(function(err, difficulty) {
//   if (err) {
//     return console.error(err);
//   }

//   console.log('Difficulty: ' + difficulty);
// });


var batch = [];

  batch.push({
    method: 'getnewaddress',
    params: ['myaccount']
  });

client.cmd(batch, function(err, address, resHeaders) {
  if (err) return console.log(err);
  console.log('Address:', address);
});



/*blastx-cli 
-rpcconnect=127.0.0.1 
-rpcpassword=dasffds8JUDYMqtekfE8PHvE6Yq3Gf4uNJjXp2 
-rpcuser=blastxuser 
getinfo*/