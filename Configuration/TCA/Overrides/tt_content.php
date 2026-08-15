<?php
declare(strict_types = 1);

use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') or die();

(static function (): void {
    $pluginKey = ExtensionUtility::registerPlugin(
        // extension name, matching the PHP namespaces (but without the vendor)
        'Phiki',
        // arbitrary, but unique plugin name (not visible in the backend)
        'Snippet',
        // plugin title, as visible in the drop-down in the backend, use "LLL:" for localization
        'Code Highlight (Phiki)',
        // plugin icon, use an icon identifier from the icon registry
        'ext-phiki-plugin',
        // plugin group, to define where the new plugin will be located in
        'special',
        // plugin description, as visible in the new content element wizard
        'Code Highlighter based on Phiki',
    );
})();

// TCA configuratie voor het CE
$GLOBALS['TCA']['tt_content']['types']['phiki_snippet'] = [
    'showitem' => '
        --palette--;;general,
        header,
        bodytext,
        --div--;Settings,
        pi_flexform,
        --div--;Appearance,
        --palette--;;frames,
        --div--;Access,
        --palette--;;hidden,
        --palette--;;access,
    ',
    'columnsOverrides' => [
        'bodytext' => [
            'config' => [
                'renderType' => 'codeEditor',
                'wrap' => 'off',
                'fixedFont' => true,
            ],
        ],
        'pi_flexform' => [
            'config' => [
                'ds' => 'FILE:EXT:phiki/Configuration/FlexForms/Options.xml',
            ],
        ],
    ],
];

