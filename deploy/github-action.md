.github/workflow/main.yaml

```
name: deploy-into-TencentCloud

on:
    push:
        branches: [ "main" ]
        paths-ignore:
            - .github

jobs:
    deploy:
        runs-on: ubuntu-latest
        steps:
            - uses: actions/checkout@v3
            
            - name: 设置密钥
                run: |
                    mkdir "$HOME/.ssh"
                    echo "${{secrets.IO_PRIVATE_KEY}}" > "$HOME/.ssh/deploy_key"
                    chmod 600 "$HOME/.ssh/deploy_key"
            
            - name: 发送文件
                run: |
                    rsync -rzvt -e "ssh -i $HOME/.ssh/deploy_key -o StrictHostKeyChecking=no" $(pwd)/* ${{secrets.IO_USER}}@${{secrets.IO_HOST}}:${{secrets.WORK_DIR}}
                    curl https://api.day.app/${{secrets.BARK_TOKEN}}/NoteBook/发布成功
```
