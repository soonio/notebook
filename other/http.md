###  HTTP

超文本传输协议(HyperText Transfer Protocol，缩写HTTP)

### HTTP 状态码

- 1xx  (Informational) 信息性状态码，表示正在处理。

- 2xx  (Success) 成功状态码，表示请求正常。  
200 ok 请求被成功处理。  
204 No Content 该状态码表示服务器接收到的请求已经处理完毕，但是服务器不需要返回响应体。
206 Partial Content 该状态码表示客户端进行了范围请求，而服务器成功执行了这部分的GET请求。

- 3xx  (Redirection) 重定向状态码，表示客户端需要进行附加操作。  
301 Moved Permanently 永久性重定向。  
302 Found 临时性重定向。  

- 4xx  (Client Error) 客户端错误状态码，表示服务器无法处理请求。
400 Bad Request 指出客户端请求中的语法错误。  
401 Unauthorized 该状态码表示发送的请求需要有认证。  
403 Forbidden 该状态码表明对请求资源的访问被服务器拒绝了。  
404 Not Found 该状态码表明服务器上无法找到指定的资源。  

- 5xx  (Server Error) 服务器错误状态码，表示服务器处理请求出错。
500 Internal Server Error 该状态码表明服务器端在执行请求时发生了错误。
502 Bad Gateway 该状态码表明服务器网关错误。
503 Service Unavailable 该状态码表明服务器暂时处于超负载或正在进行停机维护，现在无法处理请求。
