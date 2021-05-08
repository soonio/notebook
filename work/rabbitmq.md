## Centos7安装最新版erlang

### 1.1 安erlang依赖环境

  ```bash
  yum -y install make gcc gcc-c++ kernel-devel m4 ncurses-devel openssl-devel unixODBC-devel
  ```

### 1.2 下载[最新]erlang

  ```bash
  wget http://erlang.org/download/[lastest_package]
  ```

  > 在http://erlang.org/download中搜索tar.gz,找到最新的opt_src_xx.x.tar.gz  
  > 替换[lastest_package] 为 opt_src_xx.x.tar.gz后执行命令

### 1.3 配置编译并安装

  ```bash
  ./configure \
    --prefix=/usr/local/erlang \
    --with-ssl \
    -enable-threads \
    -enable-smmp-support \
    -enable-kernel-poll \
    --enable-hipe \
    --without-javac
    
  make & make install
  ```

### 1.4 添加erlang命令到全局命令

  - vim打开 /etc/profile
  - 找到export PATH,在其上面增加一行，并添加PATH=$PATH:/usr/local/erlang/bin
  - 保存 /etc/profile
  - 执行命令`source /etc/profile`

## 安装rabbitmq

### 2.1 下载rabbitmq包

> 在https://github.com/rabbitmq/rabbitmq-server/releases中找到安装包名rabbitmq-server-generic-unix-x.x.x.tar.xz
> 复制包名对应的连接，使用wget下载
如下操作
```bash
wget https://github.com/rabbitmq/rabbitmq-server/releases/download/v3.7.5/rabbitmq-server-generic-unix-3.7.5.tar.xz

zx -d rabbitmq-server-generic-unix-3.7.5.tar.xz

tar -xvf rabbitmq-server-generic-unix-3.7.5.tar

移动文件到opt目录下
mv rabbitmq_server-3.7.5/ /opt/
```

同1.4操作，在PATH=$PATH:/usr/local/erlang/bin** 后增加 **:/opt/rabbitmq_server-3.7.5/sbin**

### 后台启动
```bash
rabbitmq-server -detached
```

### 查看状态
```bash
service rabbitmq-server status
```

### 启动网页管理工具
```bash
rabbitmq-plugins enable rabbitmq_management
```

### 重启
```bash
systemctl restart rabbitmq-server.service
```

### 查看系统日志
```bash
journalctl -xe
```

### 其他
- 通过命令安装erlang，再使用yum安装rabbitmq。
- 使用mq插件命令启动mq网页管理，修改配置可以使mq从其他机器访问
- 注意端口限制，以免外部及其无法访问
- rmq启动失败的时候，使用查看系统日志命令，注意仔细看日志，然后解决问题

### rabbitmq配置文件
/etc/rabbitmq/rabbitmq.config
```
[
 {rabbit,
    [
        %% 仅本地能访问的账户配置，设为空，其他及其才能用户账户密码登陆访问
        {loopback_users, []}    
    ]},
 {kernel,[]},
 {rabbitmq_management,[]},
 {rabbitmq_management_agent,[]},
 {rabbitmq_shovel,[{shovels,[]},
 {rabbitmq_stomp,[]},
 {rabbitmq_mqtt,[]},
 {rabbitmq_amqp1_0,[]},
 {rabbitmq_auth_backend_ldap,[]}
].
```