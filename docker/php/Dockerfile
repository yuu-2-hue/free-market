FROM php:7.4.9-fpm

COPY php.ini /usr/local/etc/php/

RUN apt update \
  && apt install -y default-mysql-client zlib1g-dev libzip-dev unzip curl gnupg \
  && docker-php-ext-install pdo_mysql zip

# Composer
RUN curl -sS https://getcomposer.org/installer | php \
  && mv composer.phar /usr/local/bin/composer \
  && composer self-update

# Node.js
RUN curl -sL https://deb.nodesource.com/setup_14.x | bash - \
  && apt-get install -y nodejs

# 新しいユーザーを作成（bash付き）
RUN useradd -ms /bin/bash homumaru

# npm キャッシュフォルダ用意 + 権限設定
RUN mkdir -p /home/homumaru/.npm && \
    chown -R homumaru:homumaru /home/homumaru/.npm

# 作業ディレクトリ作成 + 所有者変更
WORKDIR /var/www

# コードをコピー（この後に chown が必要！）
COPY . /var/www

# 所有者変更（ここが最重要）
RUN chown -R homumaru:homumaru /var/www

# homumaru ユーザーに切り替え
USER homumaru

# NPM が使うキャッシュの場所を設定
ENV NPM_CONFIG_CACHE=/home/homumaru/.npm
ENV HOME=/home/homumaru


