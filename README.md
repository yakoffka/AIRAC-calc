## Библиотека для работы с циклами AIRAC для фреймворка Laravel

AIRAC - система заблаговременного уведомления об изменениях аэронавигационных данных по единой таблице дат вступления
их в силу.

AIRAC - Aeronautical Information Regulation And Control (Регламентирование и контроль аэронавигационной информации).
Один год содержит 13, реже 14 (1976, 1998 и 2020) циклов AIRAC.

Библиотека учитывает високосные года, но не учитывает регионы, в которых действует время вступления в силу, отличное от UTC.


## Установка
```
composer require yakoffka/airac-cycle-dates-for-laravel 0.0.2 
```


## Использование
Пакет предоставляет три метода, принимающих необязательный параметр Carbon $date:
- getNextCycle(?Carbon $date) - получение номера дня в цикле AIRAC для переданной даты;
- getCurrentCycle(?Carbon $date) - получение текущего цикла AIRAC для переданной даты;
- getNextCycle(?Carbon $date) - получение цикла AIRAC, следующего за текущим для переданной даты.

При отсутствии параметра расчет ведется относительно текущей даты.

### примеры использования с указанием даты:
```
AiracCycle::getCycleDay(\Carbon\Carbon::createFromDate(2023, 2, 8)): int            //  14
AiracCycle::getCurrentCycle(\Carbon\Carbon::createFromDate(2023, 2, 8)): string     //  "2301"
AiracCycle::getNextCycle(\Carbon\Carbon::createFromDate(2023, 2, 8)): string        //  "2302"
```

### примеры использования без указания даты:
```
AiracCycle::getNextCycle()      //  14
AiracCycle::getCurrentCycle()   //  "2301"
AiracCycle::getNextCycle()      //  "2302"
```
