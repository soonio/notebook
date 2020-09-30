# Linux修改内核满足高并发



## 满足入网的高并发



## 解决出网的time_out

## 查看TCP连接状态

```bash
netstat -n | awk '/^tcp/ {++S[$NF]} END {for(a in S) print a, S[a]}'
```

### 调整内核

```bash
vi /etc/sysctl.conf
```

编辑文件，加入以下内容： 

```ini
net.ipv4.tcp_syncookies = 1
net.ipv4.tcp_tw_reuse = 1
net.ipv4.tcp_tw_recycle = 1
net.ipv4.tcp_fin_timeout = 30
```

> net.ipv4.tcp_syncookies = 1表示开启SYN Cookies。当出现SYN等待队列溢出时，启用cookies来处理，可防范少量SYN攻击，默认为0，表示关闭
>
> net.ipv4.tcp_tw_reuse = 1表示开启重用。允许将TIME-WAIT sockets重新用于新的TCP连接，默认为0，表示关闭
>
> net.ipv4.tcp_tw_recycle = 1表示开启TCP连接中TIME-WAIT sockets的快速回收，默认为0，表示关闭
> net.ipv4.tcp_fin_timeout修改系統默认的TIMEOUT时间

备注说明: 服务器开启tcp_tw_recycle，则会检查客户端发来的时间戳，如果客户端关闭了tcp_timestamps，则无法检查，直接响应

