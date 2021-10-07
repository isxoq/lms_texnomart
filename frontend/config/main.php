<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'homeUrl' => "/",
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'ldapAuth' => [
//            'class' => 'frontend\components\LdapAuth',
            'class' => '\stmswitcher\Yii2LdapAuth\LdapAuth',
            'host' => '192.168.0.200',
            'baseDn' => 'DC=office,DC=tm,DC=uz',
            'searchUserName' => 'lms_ldap',
            'searchUserPassword' => '1234qwer!@#$',

            // optional parameters and their default values
            'ldapVersion' => 3,             // LDAP version
            'protocol' => 'ldap://',       // Protocol to use
            'followReferrals' => false,     // If connector should follow referrals
            'port' => 389,                  // Port to connect to
            'loginAttribute' => 'cn',      // Identifying user attribute to look up for
            'ldapObjectClass' => 'person',  // Class of user objects to look up for
            'timeout' => 10,                // Operation timeout, seconds
            'connectTimeout' => 5,          // Connect timeout, seconds
        ],

        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
//            'identityClass' => '\stmswitcher\Yii2LdapAuth\Model\LdapUser',
        ],

        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'google' => [
                    'class' => 'yii\authclient\clients\Google',
//                    'validateAuthState' => false, //TEMPORARY
                    'clientId' => '909221392745-p3v978pr2tf38khfveug0h7kbh724mjj.apps.googleusercontent.com',
                    'clientSecret' => '7uw0aSlJhVkkAt4zNtZz3AgQ',
//                    'returnUrl'=>'https://virtualdars.uz/auth/auth'
                ],
//                'facebook' => [
//                    'class' => 'yii\authclient\clients\Facebook',
//                    'clientId' => 'facebook_client_id',
//                    'clientSecret' => 'facebook_client_secret',
//                ],
//                // etc.
            ],
        ],
        'billing' => [
            'class' => 'backend\modules\billing\components\Billing'
        ],

        'octo' => [
            'class' => 'backend\modules\octouz\components\OctoUzComponent'
        ],

        'i18n' => [
            'translations' => [
                'app' => [
                    'class' => 'yii\i18n\DbMessageSource',
                ],
            ],
        ],

        'view' => [
            'class' => 'frontend\components\FrontendView',
        ],
        'cart' => [
            'class' => 'frontend\components\Cart',
        ],

        'help' => [
            'class' => 'soft\components\Helper',
        ],
        'request' => [
            'baseUrl' => "/",
            'csrfParam' => '_csrf-frontend',
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'urlManager' => [
            'class' => 'soft\web\SUrlManager',
            'baseUrl' => "/",
            'scriptUrl' => '/index.php',
            'showScriptName' => false,
            'enablePrettyUrl' => true,
            /*'rules' => [

                '<language:\w+>/signup/index' => 'signup/index',

                '<language:\w+>/course/all' => 'course/all',
                '<language:\w+>/course/detail/<id>' => 'course/detail',
                '<language:\w+>/course/preview/<id>' => 'course/preview',
                '<language:\w+>/course/enroll/<id>' => 'course/enroll',

                '<language:\w+>/blog/' => 'blog',
                '<language:\w+>/blog/index/' => 'blog/index',
                '<language:\w+>/blog/detail/<id>' => 'blog/detail',

                '<language:\w+>/page/<id>' => 'site/page',

                '<language:\w+>/<action:(index|about|contact|login|faq)>' => 'site/<action>',

                '<language:\w+>/profile/my-courses' => 'profile/default/my-courses',

            ],*/

            'rules' => [

                'signup/index' => 'signup/index',

                'course/all' => 'course/all',
                'course/detail/<id>' => 'course/detail',
                'course/detail-test/<id>' => 'course/detail-test',
                'course/preview/<id>' => 'course/preview',
                'course/enroll/<id>' => 'course/enroll',

                'blog/' => 'blog',
                'blog/index/' => 'blog/index',
                'blog/detail/<id>' => 'blog/detail',
                'shop/payment/<id>' => 'shop/payment',

                'page/<id>' => 'site/page',

                '<action:(index|about|contact|login|faq|become-teacher|aloqa)>' => 'site/<action>',

                'profile/my-courses' => 'profile/default/my-courses',

            ],
        ],
        'assetManager' => require __DIR__ . '/_asset-manager-config.php',
    ],
    'modules' => [
        'profile' => [
            'class' => 'frontend\modules\profile\Module',
            'layout' => '@frontend/modules/profile/views/layouts/main',
        ],
        'teacher' => [
            'class' => 'frontend\modules\teacher\Modul',
            'layout' => '@frontend/modules/profile/views/layouts/main',
        ],
        'mbapp' => [
            'class' => 'frontend\modules\mbapp\Module',
        ],

    ],
    'params' => $params,
];
