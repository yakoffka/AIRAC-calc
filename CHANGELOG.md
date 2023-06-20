## [Version 0.2.1](https://github.com/yakoffka/AIRAC-calc/releases/tag/0.2.1) (2023-06-20)

### Новые возможности

Добавлены методы[`8bec87a`](https://github.com/yakoffka/AIRAC-calc/commit/8bec87aab5f179ff0f1c4d54db173f6cc44613ff):
- isValidCycle(string $cycle) проверка корректности номера цикла AIRAC
- getNumberCyclesPerYear(?string $year) получение количества циклов AIRAC в указанном году


### Незначительные изменения
- изменен вывод метода getEffectiveDates(): вместо порядкового номера цикла внутри года теперь выводится полный номер цикла (1 -> 2301)
