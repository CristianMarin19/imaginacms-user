<?php

return [
  //Register Users
  'registerUsers' => [
    'name' => 'iuser::registerUsers',
    'default' => '1',
    'dynamicFiled' => [
      'type' => 'checkbox',
      'props' => [
        'trueValue' => '1',
        'falseValue' => '0',
        'label' => 'iuser::settings.registerUsers',
      ],
    ]
  ],
  //Validate register with email
  'validateRegisterWithEmail' => [
    'name' => 'iuser::validateRegisterWithEmail',
    'default' => '0',
    'dynamicFiled' => [
      'type' => 'checkbox',
      'props' => [
        'trueValue' => '1',
        'falseValue' => '0',
        'label' => 'iuser::settings.validateRegisterWithEmail',
      ],
    ]
  ],
  //Admin needs to activate any new user - Slim:
  'adminNeedsToActivateNewUsers' => [
    'name' => 'iuser::adminNeedsToActivateNewUsers',
    'default' => '0',
    'dynamicFiled' => [
      'type' => 'checkbox',
      'props' => [
        'trueValue' => '1',
        'falseValue' => '0',
        'label' => 'iuser::settings.adminNeedsToActivateNewUsers',
      ],
    ]
  ],
  //Admin needs to activate any new user - Slim:
  'allowResetPassword' => [
    'name' => 'iuser::allowResetPassword',
    'default' => '1',
    'dynamicFiled' => [
      'type' => 'checkbox',
      'props' => [
        'trueValue' => '1',
        'falseValue' => '0',
        'label' => 'iuser::settings.allowResetPassword',
      ],
    ]
  ],
  //Enable register with social media
  'registerUsersWithSocialNetworks' => [
    'name' => 'iuser::registerUsersWithSocialNetworks',
    'default' => '0',
    'dynamicFiled' => [
      'type' => 'checkbox',
      'props' => [
        'trueValue' => '1',
        'falseValue' => '0',
        'label' => 'iuser::settings.registerUsersWithSocialNetworks',
      ],
    ]
  ],
  //Enable register with politicsOfPrivacy
  'registerUserWithPoliticsOfPrivacy' => [
    'name' => 'iuser::registerUserWithPoliticsOfPrivacy',
    'default' => null,
    'dynamicFiled' => [
      'type' => 'input',
      'props' => [
        'label' => 'iuser::settings.registerUserWithPoliticsOfPrivacy',
        'type' => 'text',
      ],
    ]
  ],
  //Enable register with DataTreatment
  'registerUserWithTermsAndConditions' => [
    'name' => 'iuser::registerUserWithTermsAndConditions',
    'default' => null,
    'dynamicFiled' => [
      'type' => 'input',
      'props' => [
        'label' => 'iuser::settings.registerUserWithTermsAndConditions',
        'type' => 'text',
      ],
    ]
  ],
  //Register Users
  'logoutIdlTime' => [
    'name' => 'iuser::logoutIdlTime',
    'default' => '0',
    'dynamicFiled' => [
      'type' => 'input',
      'help' => [
        'description' => 'iuser::settings.logoutIdlTime.helpText',
      ],
      'props' => [
        'type' => 'number',
        'label' => 'iuser::settings.logoutIdlTime.label',
      ],
    ]
  ],
  //==== Auth settings
  //Auth banner
  'authBanner' => [
    'default' => (object)['iuser::authBanner' => null],
    'name' => 'medias_single',
    'isMedia' => 'media_single',
    'dynamicFiled' => [
      'fakeFieldName' => 'iuser::authBanner',
      'type' => 'media',
      'groupName' => 'register',
      'groupTitle' => 'iuser::settings.settingGroups.auth',
      'columns' => 'col-12',
      'props' => [
        'label' => 'Banner',
        'zone' => 'iuser::authBanner',
        'entity' => "Modules\Setting\Entities\Setting",
        'entityId' => null,
      ],
    ]
  ],
  //auth Title
  'authTitle' => [
    'name' => 'iuser::authTitle',
    'default' => null,
    'isTranslatable' => true,
    'dynamicFiled' => [
      'type' => 'input',
      'groupName' => 'register',
      'groupTitle' => 'iuser::settings.settingGroups.auth',
      'props' => [
        'label' => 'iuser::settings.authTitle',
        'clearable' => true,
      ],
    ]
  ],
  //Roles to register
  'hideLogo' => [
    'name' => 'iuser::hideLogo',
    'default' => '0',
    'dynamicFiled' => [
      'type' => 'select',
      'groupName' => 'register',
      'groupTitle' => 'iuser::settings.settingGroups.auth',
      'props' => [
        'label' => 'iuser::settings.hideLogo',
        'options' => [
          ['label' => 'iuser::settings.yes', 'default' => '1'],
          ['label' => 'iuser::settings.no', 'default' => '0'],
        ],
      ],
    ]
  ],
  //auth login caption
  'authLoginCaption' => [
    'name' => 'iuser::authLoginCaption',
    'default' => null,
    'isTranslatable' => true,
    'dynamicFiled' => [
      'type' => 'input',
      'groupName' => 'register',
      'groupTitle' => 'iuser::settings.settingGroups.auth',
      'props' => [
        'label' => 'iuser::settings.authLoginCaption',
        'clearable' => true,
      ],
    ]
  ],
  //auth register caption
  'authRegisterCaption' => [
    'name' => 'iuser::authRegisterCaption',
    'default' => null,
    'isTranslatable' => true,
    'dynamicFiled' => [
      'type' => 'input',
      'groupName' => 'register',
      'groupTitle' => 'iuser::settings.settingGroups.auth',
      'props' => [
        'label' => 'iuser::settings.authRegisterCaption',
        'clearable' => true,
      ],
    ]
  ],
  //Roles to register
  'rolesToRegister' => [
    'name' => 'iuser::rolesToRegister',
    'default' => [2],
    'dynamicFiled' => [
      'type' => 'select',
      'groupName' => 'register',
      'groupTitle' => 'iuser::settings.settingGroups.auth',
      'props' => [
        'label' => 'iuser::settings.rolesToRegister',
        'multiple' => true,
        'useChips' => true,
      ],
      'loadOptions' => [
        'apiRoute' => 'apiRoutes.quser.roles',
        'select' => ['label' => 'name', 'id' => 'id'],
      ],
    ]
  ],
  //Roles to register
  'rolesToRegisterInWizard' => [
    'name' => 'iuser::rolesToRegisterInWizard',
    'default' => [2],
    'dynamicFiled' => [
      'type' => 'select',
      'groupName' => 'register',
      'groupTitle' => 'iuser::settings.settingGroups.auth',
      'props' => [
        'label' => 'iuser::settings.rolesToRegisterInWizard',
        'multiple' => true,
        'useChips' => true,
      ],
      'loadOptions' => [
        'apiRoute' => 'apiRoutes.quser.roles',
        'select' => ['label' => 'name', 'id' => 'id'],
      ],
    ]
  ],
  //Password
  'passwordExpiredTime' => [
    'name' => 'iuser::passwordExpiredTime',
    'default' => '0',
    'dynamicFiled' => [
      'type' => 'select',
      'groupName' => 'register',
      'groupTitle' => 'iuser::settings.settingGroups.auth',
      'props' => [
        'label' => 'iuser::settings.passwordExpiredTime',
        'options' => [
          ['label' => 'iuser::settings.expiredTime.never', 'default' => '0'],
          ['label' => 'iuser::settings.expiredTime.1 week', 'default' => '7'],
          ['label' => 'iuser::settings.expiredTime.1 month', 'default' => '30'],
          ['label' => 'iuser::settings.expiredTime.3 months', 'default' => '90'],
          ['label' => 'iuser::settings.expiredTime.1 year', 'default' => '365'],
        ],
      ],
    ]
  ],
  //Password not allow old
  'notAllowOldPassword' => [
    'name' => 'iuser::notAllowOldPassword',
    'default' => '1',
    'dynamicFiled' => [
      'type' => 'checkbox',
      'groupName' => 'register',
      'groupTitle' => 'iuser::settings.settingGroups.auth',
      'props' => [
        'trueValue' => '1',
        'falseValue' => '0',
        'label' => 'iuser::settings.notAllowOldPassword',
      ],
    ]
  ],
  //Allow local login
  'allowLocalLogin' => [
    'name' => 'iuser::allowLocalLogin',
    'default' => "1",
    'dynamicFiled' => [
      'type' => 'checkbox',
      'props' => [
        'trueValue' => "1",
        'falseValue' => "0",
        'label' => 'iuser::settings.allowLocalLogin'
      ],
    ]
  ],
  'customLogin' => [
    'name' => 'iuser::customLogin',
    'default' => ['email'],
    'dynamicFiled' => [
      'type' => 'select',
      'props' => [
        'label' => 'iuser::settings.labelCustomLogin',
        'multiple' => true,
        'useChips' => true,
        'hideDropdownIcon' => true,
        'options' => [
          ['label' => 'iuser::settings.optionMailCustomLogin', 'default' => 'email'],
          ['label' => 'iuser::settings.optionUserNameCustomLogin', 'default' => 'user_name']
        ]
      ],
    ]
  ],
  //Microsoft APP ID
  'microsoftClientId' => [
    'default' => "",
    'name' => 'iuser::microsoftClientId',
    'dynamicFiled' => [
      'type' => 'input',
      'groupName' => 'microsoft',
      'groupTitle' => 'isite::cms.label.microsoft',
      'props' => [
        'label' => 'isite::common.settings.microsoftClientId'
      ]
    ]
  ],
  'microsoftAuthUrl' => [
    'default' => "",
    'name' => 'iuser::microsoftAuthUrl',
    'dynamicFiled' => [
      'type' => 'input',
      'groupName' => 'microsoft',
      'groupTitle' => 'isite::cms.label.microsoft',
      'props' => [
        'label' => 'isite::common.settings.microsoftAuthUrl'
      ]
    ]
  ],
  'microsoftScopeLogin' => [
    'default' => [],
    'name' => 'iuser::microsoftScopeLogin',
    'dynamicFiled' => [
      'type' => 'select',
      'groupName' => 'microsoft',
      'groupTitle' => 'isite::cms.label.microsoft',
      'props' => [
        'label' => 'isite::common.settings.microsoftScopeLogin',
        'useInput' => true,
        'useChips' => true,
        'multiple' => true,
        'newValueMode' => 'add-unique',
        'hideDropdownIcon' => true,
      ],
    ]
  ],
  'layoutProfileShow' => [
    'name' => 'iuser::layoutProfileShow',
    'default' => "iuser::frontend.profile.layouts.profile-layout-1.index",
    'dynamicFiled' => [
      'type' => 'select',
      'groupName' => 'layouts',
      'groupTitle' => 'iuser::common.layouts.group_name',
      'loadOptions' => [
        'apiRoute' => '/isite/v1/layouts',
        'select' => ['label' => 'title', 'id' => 'path'],
        'requestParams' => ['filter' => ['entity_name' => 'User', 'module_name' => 'Iprofile', 'isInternal' => 1]],
      ],
      'props' => [
        'label' => 'iuser::common.layouts.label_views',
        'entityId' => null,
      ],
    ]
  ],
  //Register Users
  'notifyUserOnCreation' => [
    'name' => 'iuser::notifyUserOnCreation',
    'default' => '0',
    'dynamicFiled' => [
      'type' => 'checkbox',
      'props' => [
        'trueValue' => '1',
        'falseValue' => '0',
        'label' => 'iuser::settings.notifyUserOnCreation',
      ],
    ]
  ]
];
