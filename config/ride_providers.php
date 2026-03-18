<?php

return [
    'providers' => [
        [
            'name'          => 'inDrive',
            'type'          => 'Standard',
            'base_fare'     => 5.00,
            'per_km'        => 1.80,
            'per_min'       => 0.10,
            'currency'      => 'GH₵',
            'logo'          => 'indrive.png',
            'color'         => '#1a73e8',
        ],
        [
            'name'          => 'Bolt',
            'type'          => 'Bolt Go',
            'base_fare'     => 6.00,
            'per_km'        => 2.10,
            'per_min'       => 0.15,
            'currency'      => 'GH₵',
            'logo'          => 'bolt.png',
            'color'         => '#34d186',
        ],
        [
            'name'          => 'Uber',
            'type'          => 'UberX',
            'base_fare'     => 7.00,
            'per_km'        => 2.30,
            'per_min'       => 0.20,
            'currency'      => 'GH₵',
            'logo'          => 'uber.png',
            'color'         => '#000000',
        ],
        [
            'name'          => 'Taxi',
            'type'          => 'Local Cab',
            'base_fare'     => 8.00,
            'per_km'        => 2.50,
            'per_min'       => 0.00,
            'currency'      => 'GH₵',
            'logo'          => 'taxi.png',
            'color'         => '#f59e0b',
        ],
    ],
];