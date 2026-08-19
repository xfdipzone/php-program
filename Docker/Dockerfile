FROM php:7.4-cli

# 安装系统依赖 + PHP扩展依赖
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    vim \
    procps \
    libzip-dev \
    libxml2-dev \
    libonig-dev \
    tzdata \
    imagemagick \
    libmagickwand-dev \
    && docker-php-ext-install \
        mbstring \
        xml \
        zip \
        shmop \
        sysvsem \
        sysvshm \
        sysvmsg \
    && rm -rf /var/lib/apt/lists/*

# 设置时区为中国上海
RUN ln -sf /usr/share/zoneinfo/Asia/Shanghai /etc/localtime \
    && echo "Asia/Shanghai" > /etc/timezone

# 安装 Xdebug (PHPUnit coverage)
RUN pecl install xdebug-3.1.6 \
    && docker-php-ext-enable xdebug

# 安装 Sync 扩展 (SyncMutex)
RUN pecl install sync-1.1.3 \
    && docker-php-ext-enable sync

# 安装 Imagick 扩展
RUN pecl install imagick-3.7.0 \
    && docker-php-ext-enable imagick

# 安装 Composer
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# PHP配置
# Xdebug coverage
RUN echo "xdebug.mode=coverage" \
    > /usr/local/etc/php/conf.d/xdebug.ini

# PHP memory limit
RUN echo "memory_limit=256M" \
    > /usr/local/etc/php/conf.d/memory.ini

WORKDIR /app

CMD ["bash"]
