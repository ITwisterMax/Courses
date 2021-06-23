<?php
    session_start();

    // Create captcha image
    $digit1 = rand(1, 30);
    $digit2 = rand(1, 30);
    $_SESSION['randNumber'] = $digit1 + $digit2;

    $image = imagecreatetruecolor(200, 40);
    $textColor = imagecolorallocate($image, 200, 100, 90);
    $bgColor = imagecolorallocate($image, 255, 255, 255);

    imagefilledrectangle($image, 0, 0, 200, 40, $bgColor);
    imagettftext($image, 30, 0, 10, 35, $textColor, "font.ttf", "$digit1 + $digit2");
    imagepng($image);
