## Библиотека для расчетов циклов AIRAC для фреймворка Laravel

AIRAC - система заблаговременного уведомления об изменениях аэронавигационных данных по единой таблице дат вступления
их в силу.

AIRAC - Aeronautical Information Regulation And Control (Регламентирование и контроль аэронавигационной информации).
Один год содержит 13, реже 14 (1976, 1998 и 2020) циклов AIRAC.

Библиотека учитывает високосные года, но не учитывает регионы, в которых действует время вступления в силу, отличное от UTC.


## Установка
```
composer require yakoffka/airac-calc 0.0.3 
```


## Использование
Пакет предоставляет три метода, принимающих необязательный параметр Carbon $date:
- getNextCycle(?Carbon $date): int - получение номера дня в цикле AIRAC для переданной даты;
- getCurrentCycle(?Carbon $date): string - получение текущего цикла AIRAC для переданной даты;
- getNextCycle(?Carbon $date): string - получение цикла AIRAC, следующего за текущим для переданной даты.

При отсутствии параметра расчет ведется относительно текущей даты.

### примеры использования с указанием даты:
```
$date = \Carbon\Carbon::createFromDate(2023, 2, 8);

AiracCalc::getCycleDay($date);         //  14
AiracCalc::getCurrentCycle($date);     //  "2301"
AiracCalc::getNextCycle($date);        //  "2302"
```

### примеры использования без указания даты:
```
AiracCalc::getCycleDay();       //  14
AiracCalc::getCurrentCycle();   //  "2301"
AiracCalc::getNextCycle();      //  "2302"
```
