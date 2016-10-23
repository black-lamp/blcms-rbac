RBAC Extension for Black-Lamp CMS
=====================================

INSTALLATION
------------

### Migrate
```
	yii migrate --migrationPath=@vendor/black-lamp/blcms-rbac/migrations
```

### Add module to your 'modules' config section
```
    'modules' => [
        ...
        'rbac' => [
            'class' => 'bl\rbac\Module'
        ],
        ...
    ]
```

### Configure AccessBehavior
```
    'as AccessBehavior' => [
        'class' => 'bl\rbac\components\AccessBehavior'
    ],
```
    
    Rolefor access is 'rbacManager'.