<?php

return [
    'options' => [
    	'end_date' => 30,						// Dias de vencimiento de una cuenta de prueva
        'no_reply' => 'no-reply@gmail.com',		// Cuenta que envia mensajes
        'cron_mail' => 'deduar@gmail.com',		// Cuneta que recibe los reports del cron
        'end_date_begin' => 8,					// Delta tiempo antes de hoy
        'end_date_end' => 3,					// Delta tiempo luego de hoy
        'register_to_mail' => 'deduar@gmail.com'// Mail de monitoreo
    ]
];