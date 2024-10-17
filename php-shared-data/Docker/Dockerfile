# 基于官方 PHP 镜像构建
FROM php:7.1-fpm

ENV NGINX_CONF_VHOST_DEFAULT    /etc/nginx/nginx.conf
ENV PHP_CONF_DEFAULT            /usr/local/etc/php-fpm.d/www.conf
ENV WEBAPP_PATH                 /data/webapp


# 安装所需的扩展
RUN apt-get update && apt-get install -y \
    nginx procps vim \
    && docker-php-ext-install shmop sysvsem sysvshm sysvmsg


# 设置时区为中国
RUN ln -sf /usr/share/zoneinfo/Asia/Shanghai /etc/localtime


# 配置 Nginx
COPY nginx.conf /etc/nginx/nginx.conf

RUN sed -i -e "1,/\/var\/www\/html/s#/var/www/html#${WEBAPP_PATH}/www#" ${NGINX_CONF_VHOST_DEFAULT}


# 配置 PHP
COPY www.conf /usr/local/etc/php-fpm.d/www.conf

RUN sed -i 's|;error_log = log/php-fpm.log|error_log = log/php-fpm.log|' /usr/local/etc/php-fpm.conf

RUN rm /usr/local/etc/php-fpm.d/docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf /usr/local/etc/php-fpm.d/www.conf.default


# 创建日志目录并设置权限
RUN mkdir -p /var/log/nginx && \
    chown www-data:www-data /var/log/nginx && \
    chmod 0777 /var/log/nginx


# 设置工作目录
WORKDIR /data/webapp


# 端口
EXPOSE 80


# 启动 Nginx 和 PHP-FPM
CMD service nginx start && php-fpm