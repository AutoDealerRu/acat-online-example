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

- **Установите пакеты используя один из вариантов**
    - ```php composer.phar install```
    - ```composer install```
- **Укажите в файле настроек [src/settings.php](https://github.com/AutoDealerRu/acat-online-example/blob/master/src/settings.php#L11) ваш API Token**
- Если каталог расположен не в корневой директории, а например по адресу **http://example.com/catalog** добавьте в файле настроек [src/settings.php](https://github.com/AutoDealerRu/acat-online-example/blob/master/src/settings.php#L13) ```catalog/``` чтобы ссылки работали корректно
- **Важно!** Если сайт индексируется поисковиками, настройте индексацию каталога так, чтобы избежать блокировки по лимитам (**используя файл robots.txt**)


# Запуск

## Используя composer (один из вариантов): 
- ```php composer.phar start```
- ```composer start```

## Используя php
- ```php -S 0.0.0.0:80 -t public public/index.php```

## Используя docker:

### Доп. требования:

- **docker**
- **docker-compose**
- **возможность использования docker (при размещении сайта на "общей" хостинг-площадке)**

### Для запуска введите:

```docker-compose up -d```


# Обновления

## 21.11.2017
### Добавлено:
- Вывод ошибки об отсутствии токена 
- Дополнена инструкция по установке 
- Дополнен каталог ssangyong 
### Исправлено:
- Параметры запуска в файле ```composer.json```

## 20.11.2017
### Добавлено:
#### Renault | Dacia
- Модельный ряд каталога
- Модификации каталога
- Группы
- Подгруппы
- Номера (артикулы) каталога
- Подномера (аналоги) каталога
#### Mercedes Benz | Smart
- Страны и аггрегаты каталога
- Добавлены все URL адреса (routing) каталога 
- Добавлены все представления (view) каталога (пока без содержимого) 

## 17.11.2017
### Добавлено:
#### Nissan | Infinity
- Модельный ряд каталога 
- Модификации каталога
- Группы
- Подгруппы
- Номера (артикулы) каталога
### Исправлено:
- Вывод даты актуальности запчасти (в информации по артикулу)

## 14.11.2017
### Добавлено:
- Главная страница с типами и марками
- Модельный ряд каталога a2d ([список типов и марок](https://github.com/AutoDealerRu/catalog-api-documentation/blob/master/a2d/README.md))
- Группы каталога a2d ([список типов и марок](https://github.com/AutoDealerRu/catalog-api-documentation/blob/master/a2d/README.md))
- Конечная страница номеров с изображением (точки, увеличение, уменьшение, движение изображения)