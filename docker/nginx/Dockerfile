FROM nginx:alpine

COPY ./conf.d/ /etc/nginx/

RUN chmod -R a+w /var/cache/nginx/ \
        && touch /var/run/nginx.pid \
        && chmod a+w /var/run/nginx.pid

CMD ["nginx"]
