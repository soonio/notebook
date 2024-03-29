## 概述

有时候需要调试链接远程服务器上的数据库，缓存等服务，但是由于远程服务器的限制，这些服务被限制在本地连接。所以需要使用跳板机进行连接

## 资源准备

- 跳板机
  - 跳板机能够连接目标服务器
  - (jumper_host, jumper_username, jumper_password)
- 服务一台(xx_host, xx_port)
- 本地项目机器(可以使用ssh命令)

## 示例命令
```bash
ssh -N -f -L 6380:100.100.100.123:6379 root@200.200.200.200
```

> ssh ssh -N -f -L 本地端口:服务IP:服务端口 用户名@跳板IP  
> 把本地端口通过跳板机(jumper)映射到服务机(redis，MySql等)

## 运行状态查看
```bash
ps -ef | grep ssh 
```

## python实例
```python
from redis import Redis

# 本地只需要像访问本地服务一样访问访问远程内网的服务
ri = Redis(host='127.0.0.1', password='123456', port=6380, db=0, decode_responses=True)
print(ri.get('name'))
```

## 应用场景

- 需要使用线上数据，而线上数据不开放
- 本地开发，映射其他服务到本地，始终保持配置不变
