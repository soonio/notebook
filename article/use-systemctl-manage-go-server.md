
```conf
[Unit]
Description=blog admin's api

[Service]
Type=simple
Restart=always
RestartSec=5s
ExecStart=/var/www/blog/api/blog
ExecReload=/bin/kill -s HUP $MAINPID
WorkingDirectory=/var/www/blog/api
KillMode=process
Delegate=yes

[Install]
WantedBy=multi-user.target
```