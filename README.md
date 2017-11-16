# Системные требования: 

- **apache** >= 2.2
- **composer**
- **php** >= 5.5


# Запуск

## Используя composer (один из вариантов): 
- ```bash php composer.phar start```
- ```bash composer start```

## Используя php
- ```bash php -S localhost:80 -t public public/index.php```

## Используя docker:

### Доп. требования:

- **docker**
- **docker-compose**

### Для запуска введите:

```bash docker-compose up -d``` (понадобятся пакеты ```docker``` и ```docker-compose``` и уточните у систем)


# Настройка

- **Укажите в файле src/settings.php ваш API Token**
- ****