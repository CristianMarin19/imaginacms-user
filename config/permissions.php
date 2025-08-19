<?php

return [

    'iuser.users' => [
        'manage' => [
            'title' =>  'iuser::users.manage.title',
            'description' => 'iuser::users.manage.description',
            'onlyFor' => ['super-admin'],
            'defaultAccess' => []
        ],
        'index' => [
            'title' =>  'iuser::users.list.title',
            'description' => 'iuser::users.list.description',
            'onlyFor' => [],
            'defaultAccess' => []
        ],
        'create' => [
            'title' =>  'iuser::users.create.title',
            'description' => 'iuser::users.create.description',
            'onlyFor' => ['super-admin'],
            'defaultAccess' => []
        ],
        'edit' => [
            'title' =>  'iuser::users.edit.title',
            'description' => 'iuser::users.edit.description',
            'onlyFor' => ['super-admin'],
            'defaultAccess' => []
        ],
        'destroy' => [
            'title' =>  'iuser::users.destroy.title',
            'description' => 'iuser::users.destroy.description',
            'onlyFor' => ['super-admin'],
            'defaultAccess' => []
        ],
        'restore' => [
            'title' =>  'iuser::users.restore.title',
            'description' => 'iuser::users.restore.description',
            'onlyFor' => ['super-admin'],
            'defaultAccess' => []
        ],
    ],
    'iuser.roles' => [
        'manage' => [
            'title' =>  'iuser::roles.manage.title',
            'description' => 'iuser::roles.manage.description',
            'onlyFor' => ['super-admin'],
            'defaultAccess' => []
        ],
        'index' => [
            'title' =>  'iuser::roles.list.title',
            'description' => 'iuser::roles.list.description',
            'onlyFor' => [],
            'defaultAccess' => []
        ],
        'create' => [
            'title' =>  'iuser::roles.create.title',
            'description' => 'iuser::roles.create.description',
            'onlyFor' => [],
            'defaultAccess' => []
        ],
        'edit' => [
            'title' =>  'iuser::roles.edit.title',
            'description' => 'iuser::roles.edit.description',
            'onlyFor' => ['super-admin'],
            'defaultAccess' => []
        ],
        'destroy' => [
            'title' =>  'iuser::roles.destroy.title',
            'description' => 'iuser::roles.destroy.description',
            'onlyFor' => ['super-admin'],
            'defaultAccess' => []
        ],
        'restore' => [
            'title' =>  'iuser::roles.restore.title',
            'description' => 'iuser::roles.restore.description',
            'onlyFor' => ['super-admin'],
            'defaultAccess' => []
        ]
    ],
    'iuser.access' => [
        'iadmin' => [
            'title' =>  'iuser::access.iadmin.title',
            'description' => 'iuser::access.iadmin.description',
            'onlyFor' => [],
            'defaultAccess' => []
        ],
        'ipanel' => [
            'title' =>  'iuser::access.ipanel.title',
            'description' => 'iuser::access.ipanel.description',
            'onlyFor' => [],
            'defaultAccess' => ['user']
        ],
    ]
    // append



];
