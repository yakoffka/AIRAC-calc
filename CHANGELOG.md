## [Version 0.2.45](https://github.com/yakoffka/AIRAC-calc/releases/tag/0.2.5) (2024-05-28)

### Незначительные изменения

Правка тестов[`5b93c03`](https://github.com/yakoffka/AIRAC-calc/commit/5b93c03ffcab4a9ac57d86137f502829433213bb):
- перевод тестов на аттрибуты
- обновление конфигурации


## [Version 0.2.4](https://github.com/yakoffka/AIRAC-calc/releases/tag/0.2.4) (2024-05-28)

### Незначительные изменения

Обновление версии зависимостей[`3252c02`](https://github.com/yakoffka/AIRAC-calc/commit/3252c02ef6ead2d28a67089ecb8dd6df375c8ebb):
- composer update
- composer bump


## [Version 0.2.3](https://github.com/yakoffka/AIRAC-calc/releases/tag/0.2.3) (2024-05-28)

### Незначительные изменения

Удаление устаревших тегов version[`98b8530`](https://github.com/yakoffka/AIRAC-calc/commit/98b85304d4d8358d47d8c8746590d719c5f7d7dd):

- composer.json: The version field is present, it is recommended to leave it out if the package is published on Packagist.
- docker-compose.yaml:  `version` is obsolete


## [Version 0.2.2](https://github.com/yakoffka/AIRAC-calc/releases/tag/0.2.2) (2024-05-28)

### Незначительные изменения

Обновление версии зависимостей[`fa2b992`](https://github.com/yakoffka/AIRAC-calc/commit/fa2b992080c0e51c49ea12877399a9dc99ebb91c):
- composer update
- composer bump


## [Version 0.2.1](https://github.com/yakoffka/AIRAC-calc/releases/tag/0.2.1) (2023-06-20)

### Новые возможности

Добавлены методы[`8bec87a`](https://github.com/yakoffka/AIRAC-calc/commit/8bec87aab5f179ff0f1c4d54db173f6cc44613ff):
- isValidCycle(string $cycle) проверка корректности номера цикла AIRAC
- getNumberCyclesPerYear(?string $year) получение количества циклов AIRAC в указанном году


### Незначительные изменения
- изменен вывод метода getEffectiveDates(): вместо порядкового номера цикла внутри года теперь выводится полный номер цикла (1 -> 2301)

