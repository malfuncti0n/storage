<?php
return [
    'mail'=>[
        'SMTPDebug' => 3,
        'SMTPAuth' => true,
        'SMTPSecure' => 'tls',
        'Host' => getenv('SMTPHOST'),
        'Port' => 587,
        'Username' => getenv('SMTPUSERNAME'),
        'Password' => getenv('SMTPPASSWORD'),
        'SetFrom' => getenv('SMTPFROM'),
        'AddReplyTo' => getenv('SMTPFROM')
    ]
];