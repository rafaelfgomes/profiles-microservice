#!/bin/bash

LINE="============================================="
clear
echo -e "$LINE"
echo "          Script de inicialização"
echo -e "$LINE"

read -p "Digite o nome da aplicação: " appName

appName="\""$appName"\""

echo -e "\nEscolha o ambiente"
read -p "1. local | 2. produção: " choice

case $choice in
    1)
        appEnv="local"
        ;;
    2)
        appEnv="production"
        ;;
    *)
        echo -e "Opção inválida"
        exit 1
        ;;
esac

appKey=$(cat /dev/urandom | tr -dc 'a-zA-Z0-9' | fold -w 32 | head -n 1)

echo -e "\nChave da aplicação gerada: $appKey\n"

read -p "Ligar o debug? [s/n]: " debug
case $debug in
    S)
        appDebug=true
        ;;
    s)
        appDebug=true
        ;;
    N)
        appEnv=false
        ;;
    n)
        appEnv=false
        ;;
    *)
        echo -e "Opção inválida"
        exit 1
        ;;
esac

echo -e "\n"
read -p "Digite a url da aplicação: " appUrl
appUrl="http://"$appUrl

echo -e "\n"
read -p "Digite a porta da aplicação: " appPort

echo -e "\nSetando o timezone da aplicação..."
appTz=$(curl https://ipapi.co/timezone)
echo -e "\nTimezone: $appTz"

appSecret1=$(cat /dev/urandom | tr -dc 'a-zA-Z0-9' | fold -w 32 | head -n 1)
appSecret2=$(cat /dev/urandom | tr -dc 'a-zA-Z0-9' | fold -w 32 | head -n 1)
appSecret3=$(cat /dev/urandom | tr -dc 'a-zA-Z0-9' | fold -w 32 | head -n 1)

echo -e "\nCriando e configurando o arquivo .env..."
cp .env.example .env

sed -i "s+APP_NAME=+APP_NAME=$appName+g" .env
sed -i "s+APP_ENV=+APP_ENV=$appEnv+g" .env
sed -i "s+APP_KEY=+APP_KEY=$appKey+g" .env
sed -i "s+APP_DEBUG=+APP_DEBUG=$appDebug+g" .env
sed -i "s+APP_URL=+APP_URL=$appUrl+g" .env
sed -i "s+APP_PORT=+APP_PORT=$appPort+g" .env
sed -i "s+APP_TIMEZONE=+APP_TIMEZONE=$appTz+g" .env
sed -i "s+ACCEPTED_SECRETS=+ACCEPTED_SECRETS=$appSecret1,$appSecret2,$appSecret3+g" .env

echo -e "\nCriando o arquivo SQLite para o Banco de Dados..."
touch $(pwd)/database/profiles.sqlite

echo -e "\nInstalando as dependências do composer..."
composer install

echo -e "\nCriando e populando as tabelas..."
php artisan migrate:fresh --seed

echo -e "\nScript finalizado, a aplicação está pronta..."
