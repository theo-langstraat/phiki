<?php
declare(strict_types = 1);

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

    // Used to generate all Labels, Values for use in ext_conf_template.txt
    public function addLanguageItemsEx(): string
    {
        $config = '';

            foreach (Grammar::cases() as $grammar) {
            $value = $grammar->value;

            $label = self::LABELS[$value] ?? ucfirst($value);

            $config .= $label . '=' . $value . ',';
        }
        return $config;
    }
}
