http = require("http");
http.createServer(function(request,response){
  console.log("Executing server...");
  response.writeHeader(200, {"Content-Type": "text/html"});
  response.write("<h1>Hello World !!!!</h1>");
  response.end();
}).listen(8080);
console.log("Server Running on 8080");
