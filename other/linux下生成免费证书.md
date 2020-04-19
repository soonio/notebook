# 用letsencrypt.sh脚本为nginx 配置免费https证书

## STEP 1 下载文件
```
wget https://raw.githubusercontent.com/xdtianyu/scripts/master/lets-encrypt/letsencrypt.conf

wget https://raw.githubusercontent.com/xdtianyu/scripts/master/lets-encrypt/letsencrypt.sh
```

## STEP 2 修改letsencrypt.conf文件的参数为以下参数
```
# only modify the values, key files will be generated automaticly.
ACCOUNT_KEY="letsencrypt-account.key"
DOMAIN_KEY="xxx.key" # 自己命名
DOMAIN_DIR="/usr/local/nginx/html"  #网站的根目录
DOMAINS="DNS:mtian.net,DNS:www.mtian.net" #你的网站域名，多个域名用,号分隔
#ECC=TRUE
#LIGHTTPD=TRUE
```
## STEP 3 配置nginx serve config
配置以下内容到当前要生成的doman的server配置中，让letsencrypt发起http请求认证，注意以下配置为网站根目录
```
location ^~ /.well-known/acme-challenge/ {
       alias [web root]/.well-known/acme-challenge/;
       try_files $uri =404;
}
```

重启nginx或者 nginx -s reload

## STEP 4 执行文件，生成https所需要的ssl证书文件
添加执行权限并执行
```
chmod +x letsencrypt.sh

./letsencrypt.sh letsencrypt.conf
```
运行完成后会在当前目录生成证书文件

## STEP 4 修改nginx.conf 加入https配置
加入以下配置
```
server {
    listen       443 ssl;
    server_name  www.xxx.com;

    ssl on;

    ssl_certificate /usr/local/nginx/conf/mtian.chained.crt;
    ssl_certificate_key /usr/local/nginx/conf/mtian.net.key;

    # 以下配置类似普通http配置

    location / {
        root   html;
        index  index.html index.htm;
    }
}
```


## 附录相关文件原文
### letsencrypt.conf
```
# only modify the values, key files will be generated automaticly.
ACCOUNT_KEY="letsencrypt-account.key"
DOMAIN_KEY="pre-weapp.datuhongan.com.key"
DOMAIN_DIR="/data/www/fangyuan/branches/1.1/web/"
DOMAINS="DNS:pre-weapp.datuhongan.com"
#ECC=TRUE
#LIGHTTPD=TRUE
```

### letsencrypt.sh

```
#!/bin/bash

# Usage: /etc/nginx/certs/letsencrypt.sh /etc/nginx/certs/letsencrypt.conf

CONFIG=$1
ACME_TINY="/tmp/acme_tiny.py"
DOMAIN_KEY=""

if [ -f "$CONFIG" ];then
    . "$CONFIG"
    DIRNAME=$(dirname "$CONFIG")
    cd "$DIRNAME" || exit 1
else
    echo "ERROR CONFIG."
    exit 1
fi

KEY_PREFIX="${DOMAIN_KEY%%.*}"
DOMAIN_CRT="$KEY_PREFIX.crt"
DOMAIN_PEM="$KEY_PREFIX.pem"
DOMAIN_CSR="$KEY_PREFIX.csr"
DOMAIN_CHAINED_CRT="$KEY_PREFIX.chained.crt"

if [ ! -f "$ACCOUNT_KEY" ];then
    echo "Generate account key..."
    openssl genrsa 4096 > "$ACCOUNT_KEY"
fi

if [ ! -f "$DOMAIN_KEY" ];then
    echo "Generate domain key..."
    if [ "$ECC" = "TRUE" ];then
        openssl ecparam -genkey -name secp256r1 | openssl ec -out "$DOMAIN_KEY"
    else
        openssl genrsa 2048 > "$DOMAIN_KEY"
    fi
fi

echo "Generate CSR...$DOMAIN_CSR"

OPENSSL_CONF="/etc/ssl/openssl.cnf"

if [ ! -f "$OPENSSL_CONF" ];then
    OPENSSL_CONF="/etc/pki/tls/openssl.cnf"
    if [ ! -f "$OPENSSL_CONF" ];then
        echo "Error, file openssl.cnf not found."
        exit 1
    fi
fi

openssl req -new -sha256 -key "$DOMAIN_KEY" -subj "/" -reqexts SAN -config <(cat $OPENSSL_CONF <(printf "[SAN]\nsubjectAltName=%s" "$DOMAINS")) > "$DOMAIN_CSR"

wget https://raw.githubusercontent.com/diafygi/acme-tiny/master/acme_tiny.py --no-check-certificate -O $ACME_TINY -o /dev/null

if [ -f "$DOMAIN_CRT" ];then
    mv "$DOMAIN_CRT" "$DOMAIN_CRT-OLD-$(date +%y%m%d-%H%M%S)"
fi

DOMAIN_DIR="$DOMAIN_DIR/.well-known/acme-challenge/"
mkdir -p "$DOMAIN_DIR"

python $ACME_TINY --account-key "$ACCOUNT_KEY" --csr "$DOMAIN_CSR" --acme-dir "$DOMAIN_DIR" > "$DOMAIN_CRT"

if [ "$?" != 0 ];then
    exit 1
fi

if [ ! -f "lets-encrypt-x3-cross-signed.pem" ];then
    wget https://letsencrypt.org/certs/lets-encrypt-x3-cross-signed.pem --no-check-certificate -o /dev/null
fi

cat "$DOMAIN_CRT" lets-encrypt-x3-cross-signed.pem > "$DOMAIN_CHAINED_CRT"

if [ "$LIGHTTPD" = "TRUE" ];then
    cat "$DOMAIN_KEY" "$DOMAIN_CRT" > "$DOMAIN_PEM"
    echo -e "\e[01;32mNew pem: $DOMAIN_PEM has been generated\e[0m"
fi

echo -e "\e[01;32mNew cert: $DOMAIN_CHAINED_CRT has been generated\e[0m"

#service nginx reload


```