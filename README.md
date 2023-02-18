# Библиотека для расчетов циклов AIRAC для фреймворка Laravel

## Общие сведения

AIRAC - система заблаговременного уведомления об изменениях аэронавигационных данных по единой таблице дат вступления
их в силу.

AIRAC - Aeronautical Information Regulation And Control (Регламентирование и контроль аэронавигационной информации).
Один год содержит 13, реже 14 (1976, 1998 и 2020) циклов AIRAC.

Библиотека учитывает високосные года, но не учитывает регионы, в которых действует время вступления в силу, отличное от UTC.
Результаты вычислений корректны для дат текущего столетия.


## Установка
```
composer require yakoffka/airac-calc
```


## Использование
Пакет предоставляет четыре метода, принимающих в качестве необязательного аргумента дату в строковом представлении
('Y-m-d') $dateString:
- getCycleDay(?string $dateString): int (от 1 до 28) - получение номера дня в цикле AIRAC для переданной даты;
- getCurrentCycle(?string $dateString): string - получение идентификатора текущего цикла AIRAC для переданной даты;
- getPrevCycle(?string $dateString): string - получение идентификатора цикла AIRAC, предшествующего текущему для переданной даты.
- getNextCycle(?string $dateString): string - получение идентификатора цикла AIRAC, следующего за текущим для переданной даты.

При отсутствии параметра расчет ведется относительно текущей даты.

### примеры использования с указанием даты:
```
$date = \Carbon\Carbon::createFromDate(2023, 2, 8);

AiracCalc::getCycleDay($date);         //  14
AiracCalc::getCurrentCycle($date);     //  "2301"
AiracCalc::getPrevCycle($date);        //  "2213"
AiracCalc::getNextCycle($date);        //  "2302"
```

### примеры использования без указания даты:
```
AiracCalc::getCycleDay();               //  14
AiracCalc::getCurrentCycle();           //  "2301"
AiracCalc::getPrevCycle();              //  "2213"
AiracCalc::getNextCycle();              //  "2302"
```

Также пакет предоставляет два метода, принимающих обязательный строковый параметр с идентификатором цикла AIRAC:
- getPrevByAirac(?string $airac): string - получение идентификатора цикла AIRAC, предшествующего переданному.
- getNextByAirac(?string $airac): string - получение идентификатора цикла AIRAC, следующего за переданным.
### примеры использования:
```
AiracCalc::getPrevByAirac('2301');       //  "2302"
AiracCalc::getNextByAirac('2301');       //  "2213"
```


## Дополнительный метод showEffectiveDates() \[доступен с версии 0.0.4\]
Пакет предоставляет также дополнительный метод showEffectiveDates(), который выводит календарь циклов на запрошенный период

### пример использования:
```
// в качестве необязательных параметров данный метод принимает строки начала и конца требуемого интервала

AiracCalc::showEffectiveDates('2023-01-01', '2024-01-01');
```
результатом выполнения будет вывод всех дат начала циклов, входящих в данный интервал:
```
  2023 year
 1 2023-01-26
 2 2023-02-23
 3 2023-03-23
 4 2023-04-20
 5 2023-05-18
 6 2023-06-15
 7 2023-07-13
 8 2023-08-10
 9 2023-09-07
10 2023-10-05
11 2023-11-02
12 2023-11-30
13 2023-12-28

  2024 year
 1 2024-01-25
 2 2024-02-22
 3 2024-03-21
 4 2024-04-18
 5 2024-05-16
 6 2024-06-13
 7 2024-07-11
 8 2024-08-08
 9 2024-09-05
10 2024-10-03
11 2024-10-31
12 2024-11-28
13 2024-12-26
```

### источники
 
- [Aeronautical Information Publication](https://en.wikipedia.org/wiki/Aeronautical_Information_Publication#AIRAC_effective_dates_(28-day_cycle)).
