# Системные требования: 

- **apache** >= 2.2
- **composer**
- **php** >= 5.5


# Запуск

## Используя composer (один из вариантов): 
- ```php composer.phar start```
- ```composer start```

## Используя php
- ```php -S localhost:80 -t public public/index.php```

## Используя docker:

### Доп. требования:

- **docker**
- **docker-compose**

### Для запуска введите:

```docker-compose up -d``` (понадобятся пакеты ```docker``` и ```docker-compose``` и уточните у систем)


# Настройка

- **Укажите в файле [src/settings.php](https://github.com/AutoDealerRu/acat-online-example/blob/master/src/settings.php#L11) ваш API Token**


# Обновления:

## 14.11.2017
### Добавлено:
- Главная страница с типами и марками
- Модельный ряд каталога a2d ([список типов и марок](https://github.com/AutoDealerRu/catalog-api-documentation/blob/master/a2d/README.md))
- Группы каталога a2d ([список типов и марок](https://github.com/AutoDealerRu/catalog-api-documentation/blob/master/a2d/README.md))
- Конечная страница номеров с изображением (точки, увеличение, уменьшение, движение изображения)