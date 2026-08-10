<?php
declare(strict_types = 1);

$EM_CONF[$_EXTKEY] = [
    'title' => 'Phiki Code Highlight',
    'description' => 'Extbase-based code highlighting content element using Phiki with theme and plugin support.',
    'category' => 'fe',
    'author' => 'Theo Langstraat',
    'author_email' => 'theo.langstraat@delta.nl',
    'state' => 'stable',
    'clearCacheOnLoad' => true,
    'version' => '2.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '14.0.0-14.99.99',
            'php' => '8.2.0-8.99.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
