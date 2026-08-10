<?php
declare(strict_types = 1);

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

namespace Theolangstraat\Phiki\Backend\Items;

use Phiki\Grammar\Grammar;

class LanguageItemsProvider
{
    private const LABELS = [
        'javascript' => 'JavaScript',
        'php' => 'PHP',
        'csharp' => 'C#',
        'cpp' => 'C++',
        'css' => 'CSS',
        'html' => 'HTML',
        'json' => 'JSON',
        'yaml' => 'YAML',
        'markdown' => 'Markdown',
        'bash' => 'Bash',
        'shell' => 'Shell',
        'sql' => 'SQL',
        'python' => 'Python',
        'java' => 'Java',
        'go' => 'Go',
        'rust' => 'Rust',
        'ruby' => 'Ruby',
        'swift' => 'Swift',
        'kotlin' => 'Kotlin',
        'typescript' => 'TypeScript',
        // … je kunt hier uitbreiden, maar alles wat ontbreekt valt terug op ucfirst()
    ];

    public function addLanguageItems(array &$config): void
    {
        foreach (Grammar::cases() as $grammar) {
            $value = $grammar->value;

            $label = self::LABELS[$value] ?? ucfirst($value);

            $config['items'][] = [
                $label,   // Mooie naam
                $value,   // Enum value
            ];
        }
    }
}
