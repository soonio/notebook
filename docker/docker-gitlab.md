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

## 等待服务启动

稍等几分钟，就能访问gitlab.example.com

