<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Phiki Code Highlight',
    'description' => 'This extension provides a syntax-highlighting content element powered by Phiki (https://github.com/phikiphp/phiki), a PHP-based syntax highlighter developed by Ryan Chandler. Since phiki operates entirely in PHP and does not rely on JavaScript — which is not permitted in the TYPO3 backend — the backend renders the highlighted code exactly as it appears in the frontend. This ensures a consistent WYSIWYG editing experience for integrators and editors.',
    'category' => 'fe',
    'version' => '2.0.0',
    'state' => 'stable',
    'uploadfolder' => false,
    'clearcacheonload' => true,
    'author' => 'Theo Langstraat',
    'author_email' => 'theo.langstraat@delta.nl',

    'constraints' => [
        'depends' => [
            'typo3' => '14.0.0-14.99.99',
            'php' => '8.2.0-8.99.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
