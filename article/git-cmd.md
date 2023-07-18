## 回退未push的commit

```bash
git reset --soft HEAD~1
```

> 保留变更

## 从其他分支检出指定文件到当前分支

```bash
git checkout main -- src/api/user.go
```