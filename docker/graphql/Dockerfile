FROM node:18
WORKDIR /usr/src/app
COPY package*.json ./
RUN npm install
RUN npm install --save ruru
COPY . .
CMD ["node", "server.js"]
