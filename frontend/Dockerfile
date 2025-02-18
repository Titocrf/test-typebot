# Usando a imagem oficial do Node.js
FROM node:18

WORKDIR /app
COPY package.json /app

# Copia os arquivos do projeto Angular
COPY . .

RUN npm install -g @angular/cli

# Expondo a porta padrão do Angular para o ambiente de desenvolvimento
EXPOSE 4200

# Comando para iniciar a aplicação
CMD ["npm", "start"]
