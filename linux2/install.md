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



Update At : {docsify-updated}