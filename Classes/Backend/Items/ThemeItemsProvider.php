<?php
declare(strict_types = 1);

namespace Theolangstraat\Phiki\Backend\Items;

use Phiki\Theme\Theme;

class ThemeItemsProvider
{
    private const LABEL_OVERRIDES = [
        'github' => 'GitHub',
        'catppuccin' => 'Catppuccin',
        'everforest' => 'Everforest',
        'gruvbox' => 'Gruvbox',
        'kanagawa' => 'Kanagawa',
        'material' => 'Material',
        'rose' => 'Rose',
        'slack' => 'Slack',
        'solarized' => 'Solarized',
        'vitesse' => 'Vitesse',
        'synthwave' => 'Synthwave 84', // speciale case
    ];

    public function addThemeItems(array &$config): void
    {
        foreach (Theme::cases() as $theme) {
            $value = $theme->value;

            $label = $this->makeLabel($value);

            $config['items'][] = [
                $label,   // Mooie naam
                $value,   // Enum value
            ];
        }
    }

    private function makeLabel(string $value): string
    {
        // Voorbeeld: "catppuccin-mocha" → ["catppuccin", "mocha"]
        $parts = explode('-', $value);

        $labelParts = array_map(function ($part) {
            $lower = strtolower($part);

            // Override voor bekende woorden
            if (isset(self::LABEL_OVERRIDES[$lower])) {
                return self::LABEL_OVERRIDES[$lower];
            }

            // Default: hoofdletter
            return ucfirst($lower);
        }, $parts);

        return implode(' ', $labelParts);
    }

    // Used to generate all Labels, Values for use in ext_conf_template.txt
    public function addThemeItemsEx(): string
    {
        $config = 'options[';

        foreach (Theme::cases() as $theme) {
            $value = $theme->value;

            $label = $this->makeLabel($value);

            $config .= $label . '=' . $value . ',';
        }
        $config .= ']';
        return $config;
    }
}
