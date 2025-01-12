# PHP-Program

php开发的程序，类库，小工具，不定期更新。

## 程序目录

### 1 ~ 10

- [php 调用ffmpeg获取视频信息](./php-ffmpeg) (php-ffmpeg)

- [php 调用imagemagick实现老照片效果](./php-oldphoto) (php-oldphoto)

- [php 计算多个集合的笛卡尔积](./php-cartesian-product) (php-cartesian-product)

- [php 文件与16进制相互转换](./php-hexfile) (php-hexfile)

- [php 调用新浪API生成短链接](./php-shorturl) (php-shorturl)

- [php 利用反射API获取类信息](./php-reflection) (php-reflection)

- [php 文件内容去重及排序](./php-unisort) (php-unisort)

- [php 利用curl实现多进程下载文件](./php-batch-download) (php-batch-download)

- [php 日志类](./php-log) (php-log)

- [php 基于redis计数器类](./php-redis-counter) (php-redis-counter)

---

### 11 ~ 20

- [php 基于redis使用令牌桶算法实现流量控制](./php-trafficshaper) (php-trafficshaper)

- [php 创建二维码类](./php-qrcode) (php-qrcode)

- [php 唯一RequestID生成类](./php-requestid) (php-requestid)

- [php bucket类](./php-bucket) (php-bucket)

- [php 图片局部打马赛克](./php-mosaics) (php-mosaics)

- [php Html实体编号与非ASCII字符串相互转换类](./php-htmlentitie) (php-htmlentitie)

- [php 高亮输出数据类](./php-cli-highlight) (php-cli-highlight)

- [php 缩略图生成类](./php-thumbnail) (php-thumbnail)

- [php html标记属性过滤器](./php-html-attrib-filter) (php-html-attrib-filter)

- [php Captcha验证码类](./php-captcha) (php-captcha)

---

### 21 ~ 30

- [php 导出csv类](./php-export-csv) (php-export-csv)

- [php HttpRequest请求类](./php-http-request) (php-http-request)

- [php 数据字符集编码转换类](./php-charset-convertor) (php-charset-convertor)

- [php 根据自增id创建唯一编号类](./php-idcode) (php-idcode)

- [php 遍历文件夹处理类](./php-findfile) (php-findfile)

- [php 获取Youtube视频信息类](./php-youtube-video) (php-youtube-video)

- [php 文件断点续传下载类](./php-file-downloader) (php-file-downloader)

- [php 上下文缓存类](./php-context-cache) (php-context-cache)

- [php 计量监控类](./php-metric) (php-metric)

- [php 退避算法类](./php-backoff) (php-backoff)

---

### 31 ~ 40

- [php 还原 print_r 打印数据为原始数组](./php-restore-print) (php-restore-print)

- [php 双向队列类](./php-deque) (php-deque)

- [php 地理编码类](./php-geocoding) (php-geocoding)

- [php 爬虫机器人检测类](./php-spider-detector) (php-spider-detector)

- [php 时区转换类](./php-timezone-conversion) (php-timezone-conversion)

- [php 数据格式化类](./php-data-formatter) (php-data-formatter)

- [php 版本比对类](./php-version) (php-version)

- [php 验证类](./php-validator) (php-validator)

- [php 敏感词过滤类](./php-sensitive-word-filter) (php-sensitive-word-filter)

- [php 执行时间统计类](./php-timer) (php-timer)

---

### 41 ~ 50

- [php 文件解析类](./php-file-parser) (php-file-parser)

- [php 文件加密类](./php-file-encryptor) (php-file-encryptor)

- [php CSS 更新类](./php-css-updater) (php-css-updater)

- [php 共享数据类](./php-shared-data) (php-shared-data)

- [php 电邮发送类](./php-mailer) (php-mailer)

- [php HTML文档分析类](./php-html-analyzer) (php-html-analyzer)

- [php 密码生成类](./php-password-generator) (php-password-generator)

- [php 注解阅读器](./php-annotation-reader) (php-annotation-reader)

- [php 数据库表 Model 类](./php-db-model) (php-db-model)

- [php CSRF 组件类](./php-csrf) (php-csrf)

---

## 单元测试

部分项目增加了单元测试，运行流程如下

```shell
# 安装 composer 依赖
composer install

# 运行单元测试
./vendor/bin/phpunit -c phpunit.xml
```
