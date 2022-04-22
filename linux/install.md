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
  - 操作流程
    - 获取源码包(从官网，github...等等地方回去放在要安装的宿主机上就好)
    - 解压源码包(参考其他模块的解压命令)
    - 查看源码包中的`readme`或者`install`文件(熟练的话就跳过吧)
    - 检测并配置`./configure options ...`
    - 编译`make`
    - 安装`make install`

  > 中间可能会make失败，使用`make clean`清除编译的内容，还有`make test/make check`检查`make`的结果是否正常

## 其他

  ```shell
  yum install epel-release
  ```
  > 什么是EPEL?  
  > EPEL的全称叫 Extra Packages for Enterprise Linux 。EPEL是由 Fedora 社区打造，为 RHEL 及衍生发行版如 CentOS、Scientific Linux 等提供高质量软件包的项目。装上了 EPEL之后，就相当于添加了一个第三方源。  
  > 如果你知道rpmfusion.org的话，拿 rpmfusion 做比较还是很恰当的，rpmfusion 主要为桌面发行版提供大量rpm包，而EPEL则为服务器版本提供大量的rpm包，而且大多数rpm包在官方 repository 中是找不到的。
