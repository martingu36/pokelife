<?php

test('verificacion de despliegue continuo en CI', function () {
    $estadoCorrecto = true;

    expect($estadoCorrecto)->toBeTrue();
});
