<?php

namespace Hasnayeen\Xumina\Themes;

use Hasnayeen\Xumina\Contracts\Theme;

class Material extends BaseTheme implements Theme
{
    // Light theme (Material Light)
    public string $background = '0 0% 100%';         // #ffffff

    public string $foreground = '200 18% 26%';       // #37474f

    public string $muted = '200 18% 96%';            // #f5f7f8

    public string $mutedForeground = '200 18% 46%';  // #607d8b

    public string $popover = '0 0% 100%';            // #ffffff

    public string $popoverForeground = '200 18% 26%'; // #37474f

    public string $border = '200 18% 88%';           // #dfe6e9

    public string $input = '200 18% 88%';            // #dfe6e9

    public string $card = '0 0% 100%';               // #ffffff

    public string $cardForeground = '200 18% 26%';   // #37474f

    public string $primary = '210 100% 55%';         // #1976d2

    public string $primaryForeground = '0 0% 100%';  // #ffffff

    public string $secondary = '200 18% 92%';        // #e6eaed

    public string $secondaryForeground = '200 18% 26%'; // #37474f

    public string $accent = '340 82% 52%';           // #e91e63

    public string $accentForeground = '0 0% 100%';   // #ffffff

    public string $destructive = '0 100% 57%';       // #f44336

    public string $destructiveForeground = '0 0% 100%'; // #ffffff

    public string $ring = '210 100% 55%';            // #1976d2

    public string $radius = '0.25rem';

    // Dark theme (Material Dark)
    public string $backgroundDark = '200 18% 14%';   // #1f2729

    public string $foregroundDark = '0 0% 98%';      // #fafafa

    public string $mutedDark = '200 18% 22%';        // #323b3f

    public string $mutedForegroundDark = '200 18% 72%'; // #b0bec5

    public string $accentDark = '340 82% 55%';       // #ea4b72

    public string $accentForegroundDark = '0 0% 100%'; // #ffffff

    public string $popoverDark = '200 18% 14%';      // #1f2729

    public string $popoverForegroundDark = '0 0% 98%'; // #fafafa

    public string $borderDark = '200 18% 26%';       // #37474f

    public string $inputDark = '200 18% 26%';        // #37474f

    public string $cardDark = '200 18% 18%';         // #292f32

    public string $cardForegroundDark = '0 0% 98%';  // #fafafa

    public string $primaryDark = '210 100% 60%';     // #42a5f5

    public string $primaryForegroundDark = '0 0% 100%'; // #ffffff

    public string $secondaryDark = '200 18% 26%';    // #37474f

    public string $secondaryForegroundDark = '0 0% 98%'; // #fafafa

    public string $destructiveDark = '0 100% 65%';   // #ff5252

    public string $destructiveForegroundDark = '0 0% 100%'; // #ffffff

    public string $ringDark = '210 100% 60%';        // #42a5f5

    public string $radiusDark = '0.25rem';
}
