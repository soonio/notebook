## rpm/yum/dnf

> dnf是centos8新增加的包管理工具

- `yum` Yellowdog Updater Modified
- `rpm` RPM Package Manager 递归名称

## 软件包及安装

- 二进制包
  - 安装快，自动解决依赖但是无法自定义安装位置等
  - 常用命令
    - 安装`rpm  -ivh package-name.rpm`
    - 升级`rpm  -Uvh package-name.rpm`
    - 卸载`rpm  -e packgae-name`
    - 查询安装信息 `rpm  -qil nginx`
    - 参数意思参考`man rpm`
- 源码包
  - 能够自由配置但需要自行编译、配置，也容易出错



Update At : {docsify-updated}