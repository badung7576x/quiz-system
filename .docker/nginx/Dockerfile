FROM node:14-alpine

WORKDIR /app

ARG uid gid

RUN apk add --no-cache shadow \
 && groupmod -g $gid node \
 && usermod -u $uid -g node node

USER node

ENV YARN_CACHE_FOLDER="/app/.yarn"
ENV NPM_CONFIG_CACHE="/app/.npm"
ENV BUILD_ENV="dev"

CMD npm run $BUILD_ENV

#---- Nginx
FROM nginx:1.21-alpine

ARG env="dev"
COPY conf/nginx.conf /etc/nginx/nginx.conf
COPY conf/dhparam.pem /etc/nginx/dhparam.pem
COPY conf/conf.d/default.$env.conf /etc/nginx/conf.d/default.conf

ARG uid gid

RUN apk add --no-cache shadow \
 && groupmod -g $gid nginx \
 && usermod -u $uid nginx

WORKDIR /app