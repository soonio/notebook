## 基于network的构建

```bash
# 创建TNet网络
docker network create unet

# 使用
## 构建mysql容器环境
docker run -d \
    -p 3306:3306 \
    -e MYSQL_ROOT_PASSWORD=123456 \
    --privileged=true \
    --restart unless-stopped \
    --name mysql \
    --network unet \
    --network-alias mysql.net \
    mysql --default-authentication-plugin=mysql_native_password
## 进入mysql
docker exec -it mysql bash
## 通过network联通php环境测试
apt update -y && apt install -y iputils-ping && ping psve.net
	
## 构建PHP环境
docker run -itd \
    --rm \
    --privileged=true \
    --restart unless-stopped \
    --name php \
    --network unet \
    --network-alias psve.net \
    php:7.4-cli /bin/bash
## 进入PHP容器
docker exec -it php bash
## 通过network联通mysql环境测试
apt update -y && apt install -y iputils-ping vim && ping mysql.net
```

### PHP测试脚本

```bash
# 需要在php的容器环境中安装pdo和pdo_mysql扩展
docker-php-source extract && docker-php-ext-install pdo pdo_mysql
# 执行脚本，会发现输出两行数据
php script.php 
```

```php
# script.php 
<?php
$pdo = new PDO("mysql:host=mysql.net:3306;dbname=mysql", 'root', '123456'); 
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$res=$pdo->query('select Host,Db from db limit 10');
foreach ($res as $key => $value) {
    print_r([$key, $value]);
}
```

