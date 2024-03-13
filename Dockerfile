FROM webdevops/php-apache:8.2

RUN rm -rf /app/* /app/.[!.]*

WORKDIR /app
ENV WEB_DOCUMENT_ROOT=/app/public

RUN apt-get update \
    && apt-get install -qqy curl libfontconfig \
    && curl -sL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Get Composer
RUN curl -sS https://getcomposer.org/installer | \
    php -- --version=2.0.9 --install-dir=/usr/local/bin/ --filename=composer

CMD ["supervisord"]
