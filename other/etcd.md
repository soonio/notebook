
### 测试启动

```bash
# 代理写入
etcdctl --endpoints=127.0.0.1:23793 put foo "hello etct 服务集群"
etcdctl --endpoints=127.0.0.1:23793 get foo

# 节点中查询
etcdctl --endpoints=172.28.95.187:2380 get foo
etcdctl --endpoints=172.28.95.174:2380 get foo
etcdctl --endpoints=172.28.95.173:2380 get foo

# 任意节点中删除
etcdctl --endpoints=172.28.95.173:2380 del foo
```


### 服务1 

```unit
[Unit]
Description=Etcd Server
After=network.target
After=network-online.target
Wants=network-online.target

[Service]
Type=notify
ExecStart=/usr/local/bin/etcd \
    --name=node1 \
    --data-dir=/var/lib/etcd \
    --listen-peer-urls=http://172.28.95.187:2380 \
    --listen-client-urls=http://172.28.95.187:2379,http://127.0.0.1:2379 \
    --initial-advertise-peer-urls=http://172.28.95.187:2380 \
    --advertise-client-urls=http://172.28.95.187:2379 \
    --initial-cluster=node1=http://172.28.95.187:2380,node2=http://172.28.95.174:2380,node3=http://172.28.95.173:2380 \
    --initial-cluster-token=etcd-cluster \
    --initial-cluster-state=new
Restart=on-failure
LimitNOFILE=65536

[Install]
WantedBy=multi-user.target
```

### 服务2
```unit
[Unit]
Description=Etcd Server
After=network.target
After=network-online.target
Wants=network-online.target

[Service]
Type=notify
ExecStart=/usr/local/bin/etcd \
    --name=node2 \
    --data-dir=/var/lib/etcd \
    --listen-peer-urls=http://172.28.95.174:2380 \
    --listen-client-urls=http://172.28.95.174:2379,http://127.0.0.1:2379 \
    --initial-advertise-peer-urls=http://172.28.95.174:2380 \
    --advertise-client-urls=http://172.28.95.174:2379 \
    --initial-cluster=node1=http://172.28.95.187:2380,node2=http://172.28.95.174:2380,node3=http://172.28.95.173:2380 \
    --initial-cluster-token=etcd-cluster \
    --initial-cluster-state=new
Restart=on-failure
LimitNOFILE=65536

[Install]
WantedBy=multi-user.target
```

### 服务3
```unit
[Unit]
Description=Etcd Server
After=network.target
After=network-online.target
Wants=network-online.target

[Service]
Type=notify
ExecStart=/usr/local/bin/etcd \
    --name=node3 \
    --data-dir=/var/lib/etcd \
    --listen-peer-urls=http://172.28.95.173:2380 \
    --listen-client-urls=http://172.28.95.173:2379,http://127.0.0.1:2379 \
    --initial-advertise-peer-urls=http://172.28.95.173:2380 \
    --advertise-client-urls=http://172.28.95.173:2379 \
    --initial-cluster=node1=http://172.28.95.187:2380,node2=http://172.28.95.174:2380,node3=http://172.28.95.173:2380 \
    --initial-cluster-token=etcd-cluster \
    --initial-cluster-state=new
Restart=on-failure
LimitNOFILE=65536

[Install]
WantedBy=multi-user.target
```

### 代理服务

```uint
[Unit]
Description=Etcd Server
After=network.target
After=network-online.target
Wants=network-online.target

[Service]
Type=notify
ExecStart=/usr/local/bin/etcd \
    grpc-proxy start \
    --endpoints=172.28.95.187:2380,172.28.95.174:2380,172.28.95.173:2380 \
    --listen-addr 0.0.0.0:23793 \
    --advertise-client-url=172.28.95.162:23793 \
    --resolver-prefix="___grpc_proxy_etcd_mophesto" \
    --resolver-ttl=60 \
    --debug
Restart=on-failure
LimitNOFILE=65536

[Install]
WantedBy=multi-user.target
```
