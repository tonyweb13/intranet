<?php
/**
 * Created by PhpStorm.
 * User: cestipular
 * Date: 3/6/2018
 * Time: 2:51 AM
 */

return [
    'url' => env('Epic_API_Url'),
    'portfolio' => env('EpicDefault','inbx'),
    'NPF' => [
        'prod' => [
            'Acceskey' => env('Norp_Prod_AccessKey','AL4wCIZfGXG0NG+h6Dl3NbcDFq4jfx4ItZ1w1bCzKDJT98251tJids0AsoOync510g=='),
            'Secretkey' => env('Norp_Prod_SecretKey','AMKR5M1O7c0jzGvk0MDT9ozEz9uRhPHnQmQy6YYu/yZpijUiWW1XWekPPybYurGngwAOIyprVuheHh8mQTosorF6mqDL7TzOIaXYcX5F8J01zxcWqjtwFgzU/2mwsFZ3tQbA=='),
        ],
        'test' => [
            'Acceskey' => env('Norp_Test_Acceskey','AA8pR0AEwoCBoqsy7UjukZFoyCS2oEaqUhLroCz4fkts8k4PkqQgyxVMl8Wv5pIotg=='),
            'Secretkey' => env('Norp_Test_Secretkey','AFKxowMC4tsJPHsGgJVnCTOvrOK4drXaYH/K4PDTxebik0P3OI5PECwfJBEne7yAeAAA8rNuJOO+p/Dh0xbSAf+ZmwwypK6P7zKcydDzKZOQS9Oq0ktB7PZhMKsPYPZSmb1A=='),
        ],
    ],

    'SLS' => [
        'prod' => [
            'Acceskey' => env('SLS_Prod_AccessKey','APrgV9+TWuk10Y3cyJbjf0UIl1UpLQqKsJUqVw5B121Up2XlwS4RZ4nBEbJxfo+qbA=='),
            'Secretkey' => env('SLS_Prod_SecretKey','APSw8w5mgL1piZE9qyt5FS5/hiKWHZGObeY+1/sV0+iAxvHldGTa5N+T8vwdlexcAwAC+BhnrfflffShRWVCRLxhdRW3U0ilRzSZ4ny4yyX7hDlrKLSevM0wMPIo2V1fimKw=
'),
        ],
        'test' => [
            'Acceskey' => env('',''),
            'Secretkey' => env('',''),
        ],
    ],

    'INBX' => [
        'prod' => [
                'Acceskey' => env('INBX_Prod_AccessKey','AHARKz+S2fnZyUZTns2g8GOjRLODcgyU8/+y4lfm4NJS1d4oRBfy0QbwxTI6UMSEsQ=='),
                'Secretkey' => env('INBX_Prod_SecretKey','AAxAP74zZyaqw/vCgjLYpb+GZekLi7MDf9nmw8d6zOGzX2OEc+4xRFp9rOKlLT+7tgAKPejpn382ZSvPYzk01KfcbOMl3AgRfeu7QM7CtN9TiW3uAYxNZ2yMktANBeDQPiRg=='),
        ],
        'test' => [
                'Acceskey' => env(''),
                'Secretkey' => env(''),
        ],
    ],

    'SOF' => [
        'prod' => [
            'Acceskey' => env('SOF_Prod_AccessKey','AHARKz+S2fnZyUZTns2g8GOjRLODcgyU8/+y4lfm4NJS1d4oRBfy0QbwxTI6UMSEsQ=='),
            'Secretkey' => env('SOF_Prod_SecretKey','AAxAP74zZyaqw/vCgjLYpb+GZekLi7MDf9nmw8d6zOGzX2OEc+4xRFp9rOKlLT+7tgAKPejpn382ZSvPYzk01KfcbOMl3AgRfeu7QM7CtN9TiW3uAYxNZ2yMktANBeDQPiRg=='),
        ],
        'test' => [
            'Acceskey' => env(''),
            'Secretkey' => env(''),
        ],
    ],

];