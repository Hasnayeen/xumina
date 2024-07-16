<?php

namespace Hasnayeen\Xumina\Themes;

use Hasnayeen\Xumina\Contracts\Theme;

class GruvBox extends BaseTheme implements Theme
{
    // Light theme (Gruvbox Light)
    public string $background = '50 11% 91%';        // #fbf1c7

    public string $foreground = '40 4% 22%';         // #3c3836

    public string $muted = '45 11% 85%';             // #ebdbb2

    public string $mutedForeground = '40 4% 40%';    // #665c54

    public string $popover = '50 11% 91%';           // #fbf1c7

    public string $popoverForeground = '40 4% 22%';  // #3c3836

    public string $border = '45 11% 80%';            // #d5c4a1

    public string $input = '45 11% 80%';             // #d5c4a1

    public string $card = '50 11% 88%';              // #f2e5bc

    public string $cardForeground = '40 4% 22%';     // #3c3836

    public string $primary = '160 13% 37%';          // #689d6a

    public string $primaryForeground = '50 11% 91%'; // #fbf1c7

    public string $secondary = '45 11% 75%';         // #bdae93

    public string $secondaryForeground = '40 4% 22%'; // #3c3836

    public string $accent = '23 30% 44%';            // #d65d0e

    public string $accentForeground = '50 11% 91%';  // #fbf1c7

    public string $destructive = '0 55% 45%';        // #cc241d

    public string $destructiveForeground = '50 11% 91%'; // #fbf1c7

    public string $ring = '160 13% 37%';             // #689d6a

    public string $radius = '0.5rem';

    // Dark theme (Gruvbox Dark)
    public string $backgroundDark = '40 4% 14%';     // #282828

    public string $foregroundDark = '45 11% 85%';    // #ebdbb2

    public string $mutedDark = '40 4% 22%';          // #3c3836

    public string $mutedForegroundDark = '45 7% 65%'; // #a89984

    public string $accentDark = '30 59% 53%';        // #fe8019

    public string $accentForegroundDark = '40 4% 14%'; // #282828

    public string $popoverDark = '40 4% 14%';        // #282828

    public string $popoverForegroundDark = '45 11% 85%'; // #ebdbb2

    public string $borderDark = '40 4% 22%';         // #3c3836

    public string $inputDark = '40 4% 22%';          // #3c3836

    public string $cardDark = '40 4% 18%';           // #32302f

    public string $cardForegroundDark = '45 11% 85%'; // #ebdbb2

    public string $primaryDark = '69 55% 55%';       // #8ec07c

    public string $primaryForegroundDark = '40 4% 14%'; // #282828

    public string $secondaryDark = '40 4% 28%';      // #504945

    public string $secondaryForegroundDark = '45 11% 85%'; // #ebdbb2

    public string $destructiveDark = '0 72% 61%';    // #fb4934

    public string $destructiveForegroundDark = '40 4% 14%'; // #282828

    public string $ringDark = '69 55% 55%';          // #8ec07c

    public string $radiusDark = '0.5rem';
}
