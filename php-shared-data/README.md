# php-shared-data

php 共享数据类

## 介绍

php 实现的共享数据类，用于本地服务进程之间共享数据

基于内存共享来实现进程间数据共享

---

## 扩展依赖

基于 php 扩展实现，需要安装 `shmop` 与 `sysvsem` 扩展

### 扩展说明

**shmop** 用于进程间内存共享数据

[https://www.php.net/manual/zh/ref.shmop.php](<https://www.php.net/manual/zh/ref.shmop.php>)

**sysvsem** 用于信号量锁，控制并发

[https://www.php.net/manual/zh/ref.sem.php](<https://www.php.net/manual/zh/ref.sem.php>)

### 扩展安装

检查是否已安装 `shmop` 与 `sysvsem` 扩展

```shell
php -m | grep shmop

php -m | grep sysvsem
```

安装 `shmop` 与 `sysvsem` 扩展

```shell
pecl install shmop

pecl install sysvsem
```

### Docker 环境安装

Docker 环境安装方法，参考 [Docker](<https://github.com/xfdipzone/php-program/tree/master/php-shared-data/Docker>)

Docker 镜像已配置好 Nginx, PHP 及依赖的扩展

```yml
# 需将 /src 修改为本机目录
volumes:
      - /src:/data/webapp
```

**docker-compose-web.yml** 中，volumes `/src` 需自行修改为本机目录，并且此目录中需要包含 `www` 目录（Nginx root）

www 目录中存放可以访问的 php 文件，例如创建一个 demo.php 文件放此目录

启动，运行与关闭

```shell
# 启动 docker
docker-compose -f docker-compose-web.yml up -d

# 访问，端口可在 docker-compose-web.yml 中修改
http://localhost:8080/demo.php

# 进入容器
docker exec -it php_71_web bash

# 关闭 docker
docker-compose -f docker-compose-web.yml down
```

---

## 共享内存系统命令

查看已使用的共享内存块

```shell
ipcs -m
```

删除已使用的共享内存块

```shell
ipcrm -m [shm-id]
```

---

## 功能

- 创建共享存储并写入数据

- 读取共享数据

- 清空共享数据

- 删除共享存储

---

## 类说明

**ISharedData** `SharedData/ISharedData.php`

共享数据接口，定义共享数据实现类必须实现的方法

**SharedMemory** `SharedData/SharedMemory.php`

基于内存共享实现的共享数据类

---

## 演示

```php
$shared_key = 'test-shared-key';
$shared_size = 128;
$shared_memory = new \SharedData\SharedMemory($shared_key, $shared_size);

// 写入数据
$data = 'shared data';
$written = $shared_memory->store($data);
var_dump($written);

// 读取数据
$load_data = $shared_memory->load();
echo $load_data.PHP_EOL;

// 清空数据
$is_clear = $shared_memory->clear();
var_dump($is_clear);

// 关闭共享存储
$closed = $shared_memory->close();
var_dump($closed);
```

更多功能演示可参考单元测试代码 [SharedData Unit Test](<https://github.com/xfdipzone/php-program/tree/master/tests/SharedData>)
