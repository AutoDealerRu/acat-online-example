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


# Обновления:

## 14.11.2017
### Добавлено:
- Главная страница с типами и марками
- Модельный ряд каталога a2d ([список типоы и марок](https://github.com/AutoDealerRu/catalog-api-documentation/blob/master/a2d/README.md))
- Группы каталога a2d ([список типоы и марок](https://github.com/AutoDealerRu/catalog-api-documentation/blob/master/a2d/README.md))
- Конечная страница номеров с изображением (точки, увеличение, уменьшение, движение изображения)