## 安装方式

- `pecl` 

  ```bash
  yum install php-pear php-devel -y # 要先安装才能使用pecl
  ```

- 源码安装

  要确保编译环境OK哦 `yum install gcc-y autoconf -y `

  

## PECL

- 安装swoole

  ```bash
  pecl install swoole
  ```

## 源码安装

- 安装swoole

  - [swoole发布页面](https://github.com/swoole/swoole-src/releases)，下载解压

  - 安装

    ```bash
    yum install glibc-headers
    yum install gcc-c++
    cd swoole && phpize && ./configure && make && make install
    ```

  - 启用 找到`php.ini`, 搜索";extension=",在最后一个被搜索到的地方添加extension=swoole.so

  - 检查是否安装成功

    ```bash
    php -ir | grep swoole
    ```

    

Update At : {docsify-updated}