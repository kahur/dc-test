# Use this docker to build final image
# Stage 1 build
FROM node:10-alpine as build-angular

COPY ./ /app
WORKDIR /app

RUN npm install

RUN npm run build --prod

# Stage 2 create docker to deploy
FROM nginx:1.17.1-alpine
COPY --from=build-step /app/docs /usr/share/nginx/html