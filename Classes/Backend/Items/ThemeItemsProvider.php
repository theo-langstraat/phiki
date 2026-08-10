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
}
