<?php
    include "index.html";

    if (isset($_POST["name"]))
    {
        // Get current hour
        $hours = date("G");

        // Add greeting inscription
        switch ($hours)
        {
            case "12":
                $output = "Прекрасный полдень, ";
                break;
            case "00":
                $output = "Прекрасная полночь, ";
                break;
            default:
                $output = "Прекрасное время суток, ";
        }

        // Parse name and add it
        $name = strip_tags($_POST["name"]);
        $output = (empty($name)) ? $output . "незнакомец!" : $output . $ . "!";
    }

    // Print result
    echo $output ?? "";
