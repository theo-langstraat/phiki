<?php
declare(strict_types = 1);

use TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider;

return [
    'ext-phiki-plugin' => [
        'provider' => SvgIconProvider::class,
        'source' => 'EXT:phiki/Resources/Public/Icons/content-phiki.svg',
    ],
];
