<p align="center">
<img src="info/logo.png">
</p>
 
## Easy A
Кароч изи пакет для вывода и записи аналитики. Минималка.
Есть генерация тестовых данных.
В одну строчку сразу выводятся вьюшки-блоки как на картинки!
Без js пока что
Ставь, с кайфом сделано. Не надо в гугл аналитикс лезть и душнится.
Функций меньше чем 0, просто записать колв, инкрементировать, вывести.
   

## Установка
1) Установить из композера 
```  
composer require slavawins/easyanalitics
```

2) Опубликовать вендоры. Просто запусти
Вызывать команду:
   ```
   php artisan vendor:publish --provider="SlavaWins\EasyAnalitics\Providers\EasyAnaliticsServiceProvider"
   ``` 

 
3) Выполнить миграцию
 ```
    php artisan migrate 
 ``` 

 
