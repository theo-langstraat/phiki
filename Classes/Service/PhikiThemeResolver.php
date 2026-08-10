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

namespace Theolangstraat\Phiki\Service;

use Phiki\Theme\Theme;

class PhikiThemeResolver
{
    /**
     * Map van string → Theme enum
     */
    private const MAP = [
        'andromeeda' => Theme::Andromeeda,
        'aurora-x' => Theme::AuroraX,
        'ayu-dark' => Theme::AyuDark,
        'catppuccin-frappe' => Theme::CatppuccinFrappe,
        'catppuccin-latte' => Theme::CatppuccinLatte,
        'catppuccin-macchiato' => Theme::CatppuccinMacchiato,
        'catppuccin-mocha' => Theme::CatppuccinMocha,
        'dark-plus' => Theme::DarkPlus,
        'dracula' => Theme::Dracula,
        'dracula-soft' => Theme::DraculaSoft,
        'everforest-dark' => Theme::EverforestDark,
        'everforest-light' => Theme::EverforestLight,
        'github-dark' => Theme::GithubDark,
        'github-dark-default' => Theme::GithubDarkDefault,
        'github-dark-dimmed' => Theme::GithubDarkDimmed,
        'github-dark-high-contrast' => Theme::GithubDarkHighContrast,
        'github-light' => Theme::GithubLight,
        'github-light-default' => Theme::GithubLightDefault,
        'github-light-high-contrast' => Theme::GithubLightHighContrast,
        'gruvbox-dark-hard' => Theme::GruvboxDarkHard,
        'gruvbox-dark-medium' => Theme::GruvboxDarkMedium,
        'gruvbox-dark-soft' => Theme::GruvboxDarkSoft,
        'gruvbox-light-hard' => Theme::GruvboxLightHard,
        'gruvbox-light-medium' => Theme::GruvboxLightMedium,
        'gruvbox-light-soft' => Theme::GruvboxLightSoft,
        'houston' => Theme::Houston,
        'kanagawa-dragon' => Theme::KanagawaDragon,
        'kanagawa-lotus' => Theme::KanagawaLotus,
        'kanagawa-wave' => Theme::KanagawaWave,
        'laserwave' => Theme::Laserwave,
        'light-plus' => Theme::LightPlus,
        'material-theme' => Theme::MaterialTheme,
        'material-theme-darker' => Theme::MaterialThemeDarker,
        'material-theme-lighter' => Theme::MaterialThemeLighter,
        'material-theme-ocean' => Theme::MaterialThemeOcean,
        'material-theme-palenight' => Theme::MaterialThemePalenight,
        'min-dark' => Theme::MinDark,
        'min-light' => Theme::MinLight,
        'monokai' => Theme::Monokai,
        'night-owl' => Theme::NightOwl,
        'nord' => Theme::Nord,
        'one-dark-pro' => Theme::OneDarkPro,
        'one-light' => Theme::OneLight,
        'plastic' => Theme::Plastic,
        'poimandres' => Theme::Poimandres,
        'red' => Theme::Red,
        'rose-pine' => Theme::RosePine,
        'rose-pine-dawn' => Theme::RosePineDawn,
        'rose-pine-moon' => Theme::RosePineMoon,
        'slack-dark' => Theme::SlackDark,
        'slack-ochin' => Theme::SlackOchin,
        'snazzy-light' => Theme::SnazzyLight,
        'solarized-dark' => Theme::SolarizedDark,
        'solarized-light' => Theme::SolarizedLight,
        'synthwave-84' => Theme::Synthwave_84,
        'tokyo-night' => Theme::TokyoNight,
        'vesper' => Theme::Vesper,
        'vitesse-black' => Theme::VitesseBlack,
        'vitesse-dark' => Theme::VitesseDark,
        'vitesse-light' => Theme::VitesseLight,
    ];

    public function resolve(string $input): Theme
    {
        $key = strtolower(trim($input));

        return self::MAP[$key] ?? Theme::GithubDarkDefault;
    }
}
