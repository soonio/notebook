## 安装启动
```bash
yum install openvpn
openvpn --daemon --config client.ovpn
```

## 启动命令
> 配置文件为绝对位置  
> 使用超级权限后台运行
```bash
sudo openvpn --daemon --config /etc/openvpn/client/datu.ovpn
```


## 影梭http代理其他配置
vim /etc/polipo/config
sudo /etc/init.d/polipo restart
export http_proxy="http://127.0.0.1:8123/"
