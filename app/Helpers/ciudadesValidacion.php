<?php

$config = [
    [
        'field'=>'nombre',
        'rules'=>'required|min_length[3]',
        'errors'=>[
            'required'=>'Debe especificar el nombre de la ciudad',
            'min_length'=>'El nombre de la ciudad debe tener por lo menos tres letras'
        ]
    ]
]



?>