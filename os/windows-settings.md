## 修改执行策略
  
  > 需要在管理员身份下打开windows powershell，执行以下命令，不然无权限模拟设置alias命令

  - 查看策略
  ```powershell
  get-executionpolicy
  ```

  - 修改策略
  ```powershell
  set-executionpolicy remotesigned
  ```



## 模拟alias命令

  - 查看是否存在 `$PROFILE` 文件
  ```powershell
  echo $PROFILE
  Test-Path -Path $PROFILE -PathType Leaf
  ```
  > 返回 `True` 时则文件存在， `False`文件不存在

  - 创建文件
  ```powershell
  New-Item -Path $PROFILE -Type File -Force
  ```

  - 编辑 $PROFILE
  ```powershell
  $ubt = "root@192.168.10.128"
  function ssubt { ssh $ubt }
  ```

  - 在 windows powershell中就可以直接使用 `ssubt` 命令了
  - 在使用 scp rsync等命令时，可以直接使用 `$ubt` 变量了

  