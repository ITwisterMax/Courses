<?php
    const EXCHANGE_RATE = 2.51;
    
    // Дан массив:
    $sourceArray = [
        [
            'firstName' => 'Василий',
            'patronymic' => 'Васильевич',
            'lastName' => 'Васильев',
            'birthday' => '12.01.1986',
            'workingDays' => [
                1 => 8,
                2 => 8,
                3 => 7,
                4 => 8,
                5 => 7,
                6 => 2.5,
                7 => 0
            ],
            'ratePerHour' => '8.3$',
            'position' => 'Software engineer'
        ],
        [
            'firstName' => 'Иван',
            'patronymic' => 'Иванович',
            'lastName' => 'Иванов',
            'birthday' => '30.02.1991',
            'workingDays' => [
                1 => 4,
                2 => 4,
                3 => 7,
                4 => 8,
                5 => 0,
                6 => 26,
                7 => 0
            ],
            'ratePerHour' => '4$',
            'position' => 'QA engineer'
        ],
        [
            'firstName' => ' Пётр',
            'patronymic' => 'Петрович',
            'lastName' => 'Петров',
            'birthday' => '13.05.1990',
            'workingDays' => [
                1 => 8,
                2 => 8,
                3 => 8,
                4 => 8,
                5 => 8,
                6 => 0,
                7 => 0
            ],
            'ratePerHour' => '4.53$',
            'position' => 'UX Designer'
        ],
        [
            'firstName' => 'cергей',
            'patronymic' => 'Сергеевич',
            'lastName' => 'Павлов',
            'birthday' => '13.09.1989',
            'workingDays' => [
                1 => 8,
                2 => 8,
                3 => 8,
                4 => 4,
                5 => 8,
                6 => 0,
                7 => 2.2
            ],
            'ratePerHour' => '8.0$',
            'position' => 'Lead UX Designer'
        ],
        [
            'firstName' => 'Анна',
            'lastName' => 'Павлова',
            'birthday' => '13.10.1988',
            'workingDays' => [
                1 => 4,
                2 => 4.4,
                3 => 8,
                4 => 4,
                5 => 3,
                6 => 0,
                7 => 0
            ],
            'ratePerHour' => '5$',
            'position' => 'QA Specialist'
        ],
        [
            'firstName' => 'Джон',
            'lastName' => 'до',
            'birthday' => '1.11.1996',
            'workingDays' => [
                1 => 12,
                2 => 12,
                3 => 12,
                4 => 12,
                5 => 12,
                6 => 12,
                7 => 12
            ],
            'ratePerHour' => '45$',
            'position' => 'Senior Software Engineer'
        ],
        [
            'firstName' => 'Vijaycumar',
            'lastName' => 'Botlapati',
            'birthday' => '09.11.1976',
            'workingDays' => [
                1 => 8,
                2 => 4,
                3 => 3.3,
                4 => 8,
                5 => 10,
                6 => 0,
                7 => 0
            ],
            'ratePerHour' => '15.5$',
            'position' => 'Senior Software Engineer'
        ]
    ];

    // 1. Составить и вывести на экран 3 таблицы соответственно по отделам (QA, Design, Development) вида:
    //    |№|ФИО|Возраст|Должность|Количество отработанных часов|Зарплата Итого (BYN)|
    // 2. Отсортировать таблицу по алфавиту от A до Я
    // 3. Написать функцию, которая на вход принимает Фамилия, Имя, Отчество, и возвращает строку ФИО (формат - Васильев В. В.). Если отчество не указано выводить ФИ.
    // 4. Написать функцию, которая по дате рождения вычисляет возраст.
    // 5. Написать функцию, которая на вход принимает массив workingDays и возвращает количество отработанных часов за неделю.
    // 6. Написать функцию, которая на вход принимает ratePerHour и Количество отработанных часов за неделю. Возвращает количество заработанных денег в BYN курсу 2.51
    // 7. Использовать все написанные функции при отрисовке таблиц.
