## 构建

```bash
docker build -t image:version .
```

## 运行

```bash
docker run -it --rm -p 80:80 -v $(pwd):/home --name=test image:version sh
```

## 进入

```bash
docker exec -it test sh
```

