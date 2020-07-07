## Gitlab安装及配置

## 官方教程

[CentOS8安装](https://about.gitlab.com/install/#centos-8)



## 提前配置好域名解析

> gitlab.guyinmedia.com  ->A-> 192.168.1.110



## 安装

```bash
sudo dnf install -y curl policycoreutils openssh-server

sudo dnf install -y postfix
sudo systemctl enable postfix
sudo systemctl start postfix

# 官方教程安装，默认安装最新版本的
# 官网默认使用的是gitlab-ee,需要改为gitlab-ce(社区版)
curl https://packages.gitlab.com/install/repositories/gitlab/gitlab-ce/script.rpm.sh | sudo bash
sudo EXTERNAL_URL="https://gitlab.guyinmedia.com" dnf install -y gitlab-ce:

# 手动安装指定版本(有时候官方源快，有时候清华大学源快)
## 清华大学源
wget https://mirrors.tuna.tsinghua.edu.cn/gitlab-ce/yum/el8/gitlab-ce-12.9.0-ce.0.el8.x86_64.rpm
## 官方源(在阿里云上官方源很快)
wget --content-disposition https://packages.gitlab.com/gitlab/gitlab-ce/packages/el/8/gitlab-ce-12.9.0-ce.0.el8.x86_64.rpm/download.rpm
## 安装下载包
rpm -ivh gitlab-ce-12.9.0-ce.0.el8.x86_64.rpm

## yum直接安装
sudo yum install gitlab-ce-12.9.0-ce.0.el8.x86_64

# 卸载
dnf remove -y gitlab-ce
```

## 配置

- 两个文件需要同步

  `vim /etc/gitlab/gitlab.rb`

  `vim /etc/gitlab/gitlab-secrets.json`

```ruby
# 设置域名
external_url "https://gitlab.guyinmedia.com"

# 使用lets encrypt生成免费证书
letsencrypt['enable'] = true
letsencrypt['contact_emails'] = ['ruoge3s@qq.com']

# 设置自动更新证书
letsencrypt['auto_renew'] = true
letsencrypt['auto_renew_hour'] = "12"
letsencrypt['auto_renew_minute'] = "30"
letsencrypt['auto_renew_day_of_month'] = "*/7"

# 邮箱设置
gitlab_rails['gitlab_email_enabled'] = true
gitlab_rails['gitlab_email_from'] = 'notice@guyin.onaliyun.com'
gitlab_rails['gitlab_email_display_name'] = '谷音&乐店GITLAB'
gitlab_rails['gitlab_email_reply_to'] = 'notice@guyin.onaliyun.com'

# 发邮件设置
gitlab_rails['smtp_enable'] = true
gitlab_rails['smtp_address'] = "smtp.mxhichina.com"
gitlab_rails['smtp_port'] = 465
gitlab_rails['smtp_user_name'] = "notice@guyin.onaliyun.com"
gitlab_rails['smtp_password'] = "Gy2019.mail!co"
gitlab_rails['smtp_domain'] = "smtp.mxhichina.com"
gitlab_rails['smtp_authentication'] = "login"
gitlab_rails['smtp_enable_starttls_auto'] = true
gitlab_rails['smtp_tls'] = true

# 备份设置
gitlab_rails['manage_backup_path'] = true
gitlab_rails['backup_path'] = "/var/opt/gitlab/backups"
gitlab_rails['backup_archive_permissions'] = 0644
gitlab_rails['backup_keep_time'] = 604800
```

```bash
scp /data/gitlab/data/backups/1594122997_2020_07_07_12.9.0_gitlab_backup.tar  root@192.168.140.105:/var/opt/gitlab/backups

scp /data/gitlab/config/gitlab-secrets.json root@192.168.140.105:/etc/gitlab/gitlab-secrets.json
```

## 生效配置

[官方文档](https://docs.gitlab.com/ce/raketasks/backup_restore.html#backup-restore)

```bash


sudo gitlab-ctl stop unicorn
sudo gitlab-ctl stop puma
sudo gitlab-ctl stop sidekiq
sudo gitlab-ctl status

gitlab-rake gitlab:backup:restore BACKUP=1556615134_2019_04_30_9.5.0

# 生效配置
sudo gitlab-ctl reconfigure
sudo gitlab-ctl restart
sudo gitlab-rake gitlab:check SANITIZE=true

# 重新生成证书
sudo gitlab-ctl renew-le-certs

# runner
```

## 关联runner

```bash
# 启动runner容器
docker run -d \
    --name=tt \
    --restart=always \
    -v /data/gitlab-runner/tt/config:/etc/gitlab-runner \
    -v /var/run/docker.sock:/var/run/docker.sock \
  gitlab/gitlab-runner

# 配置runner容器
docker exec -it tt gitlab-ci-multi-runner register
```

## 重启

```bash
# 关闭
sudo gitlab-ctl stop

# 重启全部
sudo gitlab-ctl restart

# 重启nginx
/opt/gitlab/embedded/sbin/nginx -t
gitlab-ctl restart nginx
```

## 安全配置

- nginx配置

- 登录注册

  ```
  Admin-->settings --> Sign-in Restrictions
  Sign-up enbaled  关闭注册功能
  Sign-in enbaled  关闭注册登录功能
  ```

- ip限制



## 卸载

```

```




Update At : {docsify-updated}
