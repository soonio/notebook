## 拉取镜像
```
docker pull gitlab/gitlab-ce:11.11.5-ce.0
```
> 如果要进行恢复，需要gitlab版本和备份文件的版本完全一致

## 当前目录 /data/gitlab
```
docker run --detach \
    --hostname gitlab.example.com \
    --publish 443:443 --publish 80:80 --publish 220:22 \
    --name gitlab \
    --restart always \
    --volume $(pwd)/config:/etc/gitlab \
    --volume $(pwd)/logs:/var/log/gitlab \
    --volume $(pwd)/data:/var/opt/gitlab \
    gitlab/gitlab-ce
```

关联备份文件
```
--volume $(pwd)/1556615134_2019_04_30_9.5.0_gitlab_backup.tar:/var/opt/gitlab/backups/1556615134_2019_04_30_9.5.0_gitlab_backup.tar \
```

## 配置域名
```
127.0.0.1 gitlab.example.com
```

## 等待服务启动

稍等几分钟，就能访问gitlab.example.com

## 备份
```
gitlab-rake gitlab:backup:create
```

## 恢复备份
备份文件

/var/opt/gitlab/backups/1556615134_2019_04_30_9.5.0_gitlab_backup.tar

```
cd /var/opt/gitlab/backups
gitlab-rake gitlab:backup:restore BACKUP=1556615134_2019_04_30_9.5.0
```
> 不需要写文件名后面的部分

## gitlab升级

[gitlab官网查找对应的版本](https://packages.gitlab.com/gitlab/gitlab-ce)
或者[在清华大学镜像](https://mirror.tuna.tsinghua.edu.cn/gitlab-ce/yum/)里查找

最后使用清华的gitlab镜像
https://mirrors.tuna.tsinghua.edu.cn/gitlab-ce/yum/ + 系统 + rpm

```bash
wget https://mirrors.tuna.tsinghua.edu.cn/gitlab-ce/yum/el6/gitlab-ce-10.8.4-ce.0.el6.x86_64.rpm

gitlab-ctl stop

yum install -y policycoreutils-python

rpm -Uvh gitlab-ce-10.8.4-ce.0.el6.x86_64.rpm

gitlab-ctl reconfigure
```

-Uvh -U 升级模式 -v 输出升级细节信息 -h 打印hash标记

关闭注册功能
```
Admin-->settings --> Sign-in Restrictions

Sign-upenbaled  关闭注册功能

Sign-inenbaled  关闭注册登录功能
```
配置域名绑定
vim  /etc/gitlab/gitlab.rb

编辑：external_url '你的网址'

例如：external_url 'http://192.168.1.100'

编辑完成后，再sudo gitlab-ctl reconfigure一下，使配置生效
