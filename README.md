# Содержание
1. [**Системные требования**](https://github.com/AutoDealerRu/acat-online-example#Системные-требования)
2. [**Настройки**](https://github.com/AutoDealerRu/acat-online-example#Настройки)
3. [**Запуск**](https://github.com/AutoDealerRu/acat-online-example#Запуск)
4. [**Обновления**](https://github.com/AutoDealerRu/acat-online-example#Обновления)


# Системные требования 

- **apache** >= 2.2
- **composer**
- **php** >= 5.5


# Настройки

- **Укажите в файле [src/settings.php](https://github.com/AutoDealerRu/acat-online-example/blob/master/src/settings.php#L11) ваш API Token**


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
- **возможность использования docker (при размещении сайта на "общей" хостинг-площадке)**

### Для запуска введите:

```docker-compose up -d```


# Обновления

## 14.11.2017
### Добавлено:
- Главная страница с типами и марками
- Модельный ряд каталога a2d ([список типов и марок](https://github.com/AutoDealerRu/catalog-api-documentation/blob/master/a2d/README.md))
- Группы каталога a2d ([список типов и марок](https://github.com/AutoDealerRu/catalog-api-documentation/blob/master/a2d/README.md))
- Конечная страница номеров с изображением (точки, увеличение, уменьшение, движение изображения)

## 17.11.2017
### Добавлено:
- Модельный ряд каталога Nissan | Infinity
- Модификации каталога Nissan | Infinity
- Группы Nissan | Infinity
- Подгруппы Nissan | Infinity
- Номера (артикулы) каталога Nissan | Infinity
### Исправлено:
- Вывод даты актуальности запчасти (в информации по артикулу)