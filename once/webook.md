
## 说明

在github上的一些小项目，想要在提交的时候自动部署个人服务器上。经过调研，发现[webhook](https://github.com/adnanh/webhook)这是一款不错的工具。

## 安装

```shell
curl -SL https://github.com/adnanh/webhook/releases/download/2.8.0/webhook-linux-amd64.tar.gz -o webhook.tar.gz \
&& tar -xf webhook.tar.gz -C /usr/local/bin/ --strip-components=1 \
&& chmod +x /usr/local/bin/webhook
```

## 定义配置

### /data/auto-deploy/www.sh
```shell
#!/bin/bash

date >> a.txt
# shellcheck disable=SC2048
echo "$*" >> a.txt
```

### 配置文件
```json
[
  {
    "id": "www",
    "execute-command": "/data/auto-deploy/www.sh",
    "command-working-directory": "/data/web",
    "http-methods": ["POST"],
    "pass-arguments-to-command":
    [
      {
        "source": "payload",
        "name": "head_commit.id"
      },
      {
        "source": "payload",
        "name": "pusher.name"
      },
      {
        "source": "payload",
        "name": "pusher.email"
      }
    ],
    "trigger-rule": {
      "and": [
        {
          "match": {
            "type": "payload-hmac-sha256",
            "secret": "和github中设置相同",
            "parameter":
            {
              "source": "header",
              "name": "X-Hub-Signature-256"
            }
          }
        },
        {
          "match": {
            "type": "value",
            "value": "refs/heads/main",
            "parameter": {
              "source": "payload",
              "name": "ref"
            }
          }
        }
      ]
    }
  }
]
```

## 启动

```shell
webhook -ip 127.0.0.1 -port 9600 -hotreload -hooks /data/auto-deploy/config.json
```
> 因为我用nginx代理webhook服务，所以设置ip为本机

## nginx 代理

```nginx
server {
    listen 80;
    server_name  hook.iosoon.cn;
    rewrite ^(.*)$ https://$host$1 permanent;
}
server {
    listen       443 ssl;
    server_name hook.iosoon.cn;

    ssl_certificate  cert/hook.iosoon.cn_bundle.crt;
    ssl_certificate_key  cert/hook.iosoon.cn.key;
    ssl_session_timeout 5m;
    ssl_ciphers ECDHE-RSA-AES128-GCM-SHA256:ECDHE:ECDH:AES:HIGH:!NULL:!aNULL:!MD5:!ADH:!RC4;
    ssl_protocols TLSv1 TLSv1.1 TLSv1.2;
    ssl_prefer_server_ciphers on;

    location / {
        proxy_set_header Host $http_host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_pass http://127.0.0.1:9600/;
    }
}
```

## 访问

```shell
curl https://hook.iosoon.cn/hooks/www
#输出 Hook rules were not satisfied.% 
```

## 基于supervisor的启动