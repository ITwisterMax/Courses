<?php
    require 'source.php';

    function getFullName($oldLastName, $oldFirstName, $oldPatronymic) {
        // Formatting last name, first name and patronymic
        $lastName = mb_strtoupper(mb_substr(trim($oldLastName), 0, 1)) .
            mb_strtolower(mb_substr(trim($oldLastName), 1)) . ' ';
        $firstName = mb_strtoupper(mb_substr(trim($oldFirstName), 0, 1));
        $patronymic = (empty($oldPatronymic) ? '.' : '. ' . mb_strtoupper(mb_substr(trim($firstName), 0, 1)) . '.');
        
        // Full name in format: LFP or LF
        return $lastName . $firstName . $patronymic;
    }

    function getAge($birthday) {
        // Convert birthday string to date
        $timestamp = strtotime($birthday);
        
        // Calculating age
        $age = date('Y') - date('Y', $timestamp);
        if (date('md', $timestamp) > date('md')) {
            $age--;
        }

        return $age;
    }

    function getHoursWorked(&$workingDays) {
        // Calculating hours worked in week
        return array_sum($workingDays);
    }

    function getFullRate($ratePerHour, $hoursWorked) {
        // Calculating full rate in BYN
        return round(floatval($ratePerHour) * $hoursWorked * EXCHANGE_RATE, 2);
    }

    function getGeneralInfo(&$arr) {
        // Generating employee information
        $hoursWorked = getHoursWorked($arr['workingDays']);
        return array(
            getFullName($arr['lastName'], $arr['firstName'], $arr['patronymic'] ?? ''),
            getAge($arr['birthday']),
            $arr['position'],
            $hoursWorked,
            getFullRate($arr['ratePerHour'], $hoursWorked)
        );
    }

    function getDepartment($position) {
        if (stripos($position, 'QA') !== false) {
            return 'QA';
        }
        elseif (stripos($position, 'Design') !== false) {
            return 'Design';
        }
        else {
            return 'Development';
        }
    }

    function createInfoArray(&$sourceArray) {
        $info = array();
        foreach($sourceArray as $arr) {
            // Get employee information
            $generalInfo = getGeneralInfo($arr);
            // Distribution by department
            switch (getDepartment($arr['position']))
            {
                case 'QA':
                    $info['QA'][] = $generalInfo;
                    break;
                case 'Design':
                    $info['Design'][] = $generalInfo;
                    break;
                case 'Development':
                    $info['Development'][] = $generalInfo;
                    break;
            }  
        }

        // Sorting result array in alphabet order
        foreach ($info as &$arr) {
            usort($arr, function($a, $b) { return ($a <= $b) ? -1 : 1; });
        }
        
        return $info;
    }

    function getTable(&$departmentInfo) {
        // Print specific table
        $result = '<table><tr><th>№</th><th>ФИО</th><th>Возраст</th><th>Должность</th><th>Количество отработанных часов</th><th>Зарплата итого (BYN)</th>';
        $i = 1;
        foreach($departmentInfo as $arr)
        {
            $result .= "<tr><td>{$i}</td><td>{$arr[0]}</td><td>{$arr[1]}</td><td>{$arr[2]}</td><td>{$arr[3]}</td><td>{$arr[4]}</td></tr>";
            $i++;
        }
        $result .= '</table>';

        return $result;
    }

    function printTables(&$info) {
        $result = '<link rel="stylesheet" href="style.css">';
        
        // Print table "QA"
        $result .= '<div class="data"><h3>Статистика по отделу "QA":</h3></div>';
        $result .= getTable($info['QA']);
        
        // Print table "Design"
        $result .= '<div class="data"><h3>Статистика по отделу "Design":</h3></div>';
        $result .= getTable($info['Design']);

        // Print table "Development"
        $result .= '<div class="data"><h3>Статистика по отделу "Development":</h3></div>';
        $result .= getTable($info['Development']);

        echo $result;
    }

    function init(&$sourceArray) {
        // Get full information and print it
        $info = createInfoArray($sourceArray);
        printTables($info);
    }

    // Start
    init($sourceArray);
