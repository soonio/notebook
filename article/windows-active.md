## 安装过程
  - 镜像下载(itellyou)
  - 系统安装(wepe)
  - 系统启动(开机断网初始化)
    搜索windows11如何在激活过程中断开联网

## windows11专业版激活码

  `YC7N8-G7WR6-9WR4H-6Y2W4-KBT6X`

## 激活

  ```bash
  slmgr /ipk YC7N8-G7WR6-9WR4H-6Y2W4-KBT6X
  slmgr /skms kms.03k.org
  # slmgr /skms kms.xspace.in
  slmgr /ato
  ```

> 激活失败的时候，可以换一下kms服务地址

## 查看激活详情

  ```bash
  slmgr.vbs -xpr
  ```