<?php

return [
    'role_structure' => [
        'super' => [
            'users'          => 'c,r,u,d',
            'roles'          => 'c,r,u,d',
            'countries'      => 'c,r,u,d',
            'cities'         => 'c,r,u,d',
            'about_us'       => 'c,r,u,d',
            'settings'       => 'c,r,u,d',
            'jobtitles'      => 'c,r,u,d',
            'clients'        => 'c,r,u,d',


        ],
    ],
    // 'permission_structure' => [
    //     'cru_user' => [
    //         'profile' => 'c,r,u'
    //     ],
    // ],
    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete'
    ]
];
