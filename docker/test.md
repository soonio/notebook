## 测试环境

小型创业公司，一般都会有一台低配的公网服务器，用于开发测试，上面可能需要部署很多运行，所以就需要在一台服务器上运行很多服务用于测试。本次构建以docker编排为基础，构建常用的服务。

## 服务内容

- Mysql8
- Redis5
- Memcache1
- RabbitMQ3
- ElasticSearch
- PHP7
- JAVA8

- 更多服务...

## 宿主机环境说明

宿主机基于centos8，安装docker，docker-compose等，具体安装方法参考文档中的其他部分

## 服务编排配置

[官方文档](https://docs.docker.com/compose/compose-file/)

1. 配置版本选择
2. 创建network
3. 配置服务

## Docker-compose常用命令



具体内容参考[env.test](https://github.com/ruoge3s/env.test)