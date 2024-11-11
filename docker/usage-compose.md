
```yaml

name: center

services:
  mysql:
    container_name: mysql
    image: mysql:9
    volumes:
      - ./db/mysql/data:/var/lib/mysql
      - ./db/mysql/backup:/data
      - ./db/mysql/conf.d:/etc/mysql/conf.d
    ports:
      - "3306:3306"
    environment:
      MYSQL_ROOT_PASSWORD: RC2021db0k
      TZ: Asia/Shanghai
    command: [
      '--character-set-server=utf8mb4',
      '--collation-server=utf8mb4_unicode_ci',
      '--skip-log-bin', # 禁用二进制日志
      '--default-time_zone=+8:00',
      '--sql-mode='
    ]
    networks:
      union:
        aliases:
          - mysql.services.com
    restart: unless-stopped
  mongodb:
    image: mongo:latest
    container_name: mongo
    environment:
      MONGO_INITDB_ROOT_USERNAME: root
      MONGO_INITDB_ROOT_PASSWORD: mongo2024
    ports:
      - "27017:27017"
    volumes:
      - ./db/mongo/db:/data/db
    networks:
      union:
        aliases:
          - mongo.services.com
  redis:
    image: redis:alpine
    container_name: redis
    volumes:
      - ./db/redis/data:/data
    networks:
      union:
        aliases:
          - redis.services.com
    ports:
      - "6379:6379"
    command: [ "redis-server", "--save 60 1", "--loglevel warning", "--requirepass 123456" ]
    restart: unless-stopped
  zookeeper:
    image: bitnami/zookeeper:3.8
    container_name: zookeeper
    ports:
      - "2181:2181"
    volumes:
      - "./db/zookeeper:/bitnami"
    environment:
      - ALLOW_ANONYMOUS_LOGIN=yes
    restart: unless-stopped
  kafka:
    image: bitnami/kafka:3.4
    container_name: kafka
    ports:
      - "9092:9092"
      - "9093:9093"
    volumes:
      - "./db/kafka:/bitnami"
    environment:
      - KAFKA_CFG_ZOOKEEPER_CONNECT=zookeeper:2181
      - ALLOW_PLAINTEXT_LISTENER=yes
      - KAFKA_CFG_LISTENER_SECURITY_PROTOCOL_MAP=CLIENT:PLAINTEXT,EXTERNAL:PLAINTEXT
      - KAFKA_CFG_LISTENERS=CLIENT://:9092,EXTERNAL://:9093
      - KAFKA_CFG_ADVERTISED_LISTENERS=CLIENT://kafka:9092,EXTERNAL://localhost:9093
      - KAFKA_CFG_INTER_BROKER_LISTENER_NAME=CLIENT
    depends_on:
      - zookeeper
    restart: unless-stopped
  kafka-ui:
    container_name: kafka-ui
    image: provectuslabs/kafka-ui
    ports:
      - 9811:8080
    environment:
      - KAFKA_CLUSTERS_0_NAME=Center
      - KAFKA_CLUSTERS_0_BOOTSTRAPSERVERS=kafka:9092
    depends_on:
      - kafka
    restart: unless-stopped
networks:
  union:
    driver: bridge

```
