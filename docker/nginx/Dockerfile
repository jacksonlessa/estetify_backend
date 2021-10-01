# production stage
FROM nginx:stable-alpine as production-stage
COPY ./default.conf /etc/nginx/conf.d/
EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]