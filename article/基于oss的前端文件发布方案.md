
## 配置文件

```bash
/usr/bin/ossutil config \
    --config-file=/home/gitlab-runner/.pai-ali-oss \
    --language=CH \
    --endpoint=oss-cn-shanghai.aliyuncs.com \
    --access-key-id=AAA \
    --access-key-secret=BBB
```

## 上传

```bash
/usr/bin/ossutil cp -r ./ oss://mini-video-home/AAA -c /home/gitlab-runner/.pai-ali-oss --acl=public-read
```

## OSS配置防盗链

  - index.html所在域名需要加入白名单
  - 静态资源域名需要加入白名单

## OSS配置跨域

  - index.html所在域名配置跨域请求

## CI模版样例

```yaml
.vars:prod:
  variables:
    secret: $PROD_secret
    ecs: deploy@192.168.10.10 # 金石榴生产服务器
    wDir: /var/www/xx-admin
  before_script:
    - chmod 0600 $secret

build:prod:
  extends:
    - .vars:prod
  stage: build
  when: always
  script:
    - docker pull node:21.5.0
    - docker run --name=mini-player-admin-front --rm -v $(pwd):/var/www -w /var/www node:21.5.0 sh -c "npm install --registry=https://registry.npmmirror.com && npm run build:prod -- --base=https://oss-proxy.iosoon.com/static/$CI_PIPELINE_ID && chmod -R 777 dist"
    - /usr/bin/ossutil cp -r dist oss://mini-video-home/static/$CI_PIPELINE_ID -c /home/gitlab-runner/.pai-ali-oss --acl=public-read
    - |
      for remote in $ecs
      do
        scp -i $secret -o "StrictHostKeyChecking no" -r dist/index.html $remote:$wDir/index.html
      done
  only:
    - main
  tags:
    - apple
  allow_failure: false

#### 清除Docker因为目录映射造成的文件权限问题
after_script:
  - docker run --name=mini-player-admin-front --rm -v $(pwd):/var/www -w /var/www node:21.5.0 sh -c "rm -rf node_modules && rm -rf .git/hooks"

```