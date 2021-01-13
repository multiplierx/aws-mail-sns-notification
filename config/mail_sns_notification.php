<?php

return [

    // Name of SNS Notification tenant header
    'header_tenant_name' => env('SNS_HEADER_TENANT_NAME', 'x-tenant-name'),

    // Name of SNS Notification mail identifier header
    'header_mail_identifier' => env('SNS_HEADER_MAIL_IDENTIFIER', 'x-mail-identifier')

];