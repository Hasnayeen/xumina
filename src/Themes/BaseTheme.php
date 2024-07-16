<?php

namespace Hasnayeen\Xumina\Themes;

abstract class BaseTheme
{
    public string $background = '0 0% 100%';

    public string $foreground = '222.2 47.4% 11.2%';

    public string $muted = '210 40% 96.1%';

    public string $mutedForeground = '215.4 16.3% 46.9%';

    public string $popover = '0 0% 100%';

    public string $popoverForeground = '222.2 47.4% 11.2%';

    public string $border = '214.3 31.8% 91.4%';

    public string $input = '214.3 31.8% 91.4%';

    public string $card = '0 0% 100%';

    public string $cardForeground = '222.2 47.4% 11.2%';

    public string $primary = '222.2 47.4% 11.2%';

    public string $primaryForeground = '210 40% 98%';

    public string $secondary = '210 40% 96.1%';

    public string $secondaryForeground = '222.2 47.4% 11.2%';

    public string $accent = '210 40% 96.1%';

    public string $accentForeground = '222.2 47.4% 11.2%';

    public string $destructive = '0 100% 50%';

    public string $destructiveForeground = '210 40% 98%';

    public string $ring = '215 20.2% 65.1%';

    public string $radius = '0.5rem';

    public string $backgroundDark = '224 71% 4%';

    public string $foregroundDark = '213 31% 91%';

    public string $mutedDark = '223 47% 11%';

    public string $mutedForegroundDark = '215.4 16.3% 56.9%';

    public string $accentDark = '216 34% 17%';

    public string $accentForegroundDark = '210 40% 98%';

    public string $popoverDark = '224 71% 4%';

    public string $popoverForegroundDark = '215 20.2% 65.1%';

    public string $borderDark = '216 34% 17%';

    public string $inputDark = '216 34% 17%';

    public string $cardDark = '224 71% 4%';

    public string $cardForegroundDark = '213 31% 91%';

    public string $primaryDark = '210 40% 98%';

    public string $primaryForegroundDark = '222.2 47.4% 1.2%';

    public string $secondaryDark = '222.2 47.4% 11.2%';

    public string $secondaryForegroundDark = '210 40% 98%';

    public string $destructiveDark = '0 63% 31%';

    public string $destructiveForegroundDark = '210 40% 98%';

    public string $ringDark = '216 34% 17%';

    public string $radiusDark = '0.5rem';

    public function background(float $hue, float $saturation, float $lightness): static
    {
        $this->background = $this->setValue($this->background, $hue, $saturation, $lightness);

        return $this;
    }

    public function foreground(float $hue, float $saturation, float $lightness): static
    {
        $this->foreground = $this->setValue($this->foreground, $hue, $saturation, $lightness);

        return $this;
    }

    public function muted(float $hue, float $saturation, float $lightness): static
    {
        $this->muted = $this->setValue($this->muted, $hue, $saturation, $lightness);

        return $this;
    }

    public function mutedForeground(float $hue, float $saturation, float $lightness): static
    {
        $this->mutedForeground = $this->setValue($this->mutedForeground, $hue, $saturation, $lightness);

        return $this;
    }

    public function popover(float $hue, float $saturation, float $lightness): static
    {
        $this->popover = $this->setValue($this->popover, $hue, $saturation, $lightness);

        return $this;
    }

    public function popoverForeground(float $hue, float $saturation, float $lightness): static
    {
        $this->popoverForeground = $this->setValue($this->popoverForeground, $hue, $saturation, $lightness);

        return $this;
    }

    public function border(float $hue, float $saturation, float $lightness): static
    {
        $this->border = $this->setValue($this->border, $hue, $saturation, $lightness);

        return $this;
    }

    public function input(float $hue, float $saturation, float $lightness): static
    {
        $this->input = $this->setValue($this->input, $hue, $saturation, $lightness);

        return $this;
    }

    public function card(float $hue, float $saturation, float $lightness): static
    {
        $this->card = $this->setValue($this->card, $hue, $saturation, $lightness);

        return $this;
    }

    public function cardForeground(float $hue, float $saturation, float $lightness): static
    {
        $this->cardForeground = $this->setValue($this->cardForeground, $hue, $saturation, $lightness);

        return $this;
    }

    public function primary(float $hue, float $saturation, float $lightness): static
    {
        $this->primary = $this->setValue($this->primary, $hue, $saturation, $lightness);

        return $this;
    }

    public function primaryForeground(float $hue, float $saturation, float $lightness): static
    {
        $this->primaryForeground = $this->setValue($this->primaryForeground, $hue, $saturation, $lightness);

        return $this;
    }

    public function secondary(float $hue, float $saturation, float $lightness): static
    {
        $this->secondary = $this->setValue($this->secondary, $hue, $saturation, $lightness);

        return $this;
    }

    public function secondaryForeground(float $hue, float $saturation, float $lightness): static
    {
        $this->secondaryForeground = $this->setValue($this->secondaryForeground, $hue, $saturation, $lightness);

        return $this;
    }

    public function accent(float $hue, float $saturation, float $lightness): static
    {
        $this->accent = $this->setValue($this->accent, $hue, $saturation, $lightness);

        return $this;
    }

    public function accentForeground(float $hue, float $saturation, float $lightness): static
    {
        $this->accentForeground = $this->setValue($this->accentForeground, $hue, $saturation, $lightness);

        return $this;
    }

    public function destructive(float $hue, float $saturation, float $lightness): static
    {
        $this->destructive = $this->setValue($this->destructive, $hue, $saturation, $lightness);

        return $this;
    }

    public function destructiveForeground(float $hue, float $saturation, float $lightness): static
    {
        $this->destructiveForeground = $this->setValue($this->destructiveForeground, $hue, $saturation, $lightness);

        return $this;
    }

    public function ring(float $hue, float $saturation, float $lightness): static
    {
        $this->ring = $this->setValue($this->ring, $hue, $saturation, $lightness);

        return $this;
    }

    public function radius(string $radius): static
    {
        $this->radius = $radius;

        return $this;
    }

    public function backgroundDark(float $hue, float $saturation, float $lightness): static
    {
        $this->backgroundDark = $this->setValue($this->backgroundDark, $hue, $saturation, $lightness);

        return $this;
    }

    public function foregroundDark(float $hue, float $saturation, float $lightness): static
    {
        $this->foregroundDark = $this->setValue($this->foregroundDark, $hue, $saturation, $lightness);

        return $this;
    }

    public function mutedDark(float $hue, float $saturation, float $lightness): static
    {
        $this->mutedDark = $this->setValue($this->mutedDark, $hue, $saturation, $lightness);

        return $this;
    }

    public function mutedForegroundDark(float $hue, float $saturation, float $lightness): static
    {
        $this->mutedForegroundDark = $this->setValue($this->mutedForegroundDark, $hue, $saturation, $lightness);

        return $this;
    }

    public function popoverDark(float $hue, float $saturation, float $lightness): static
    {
        $this->popoverDark = $this->setValue($this->popoverDark, $hue, $saturation, $lightness);

        return $this;
    }

    public function popoverForegroundDark(float $hue, float $saturation, float $lightness): static
    {
        $this->popoverForegroundDark = $this->setValue($this->popoverForegroundDark, $hue, $saturation, $lightness);

        return $this;
    }

    public function borderDark(float $hue, float $saturation, float $lightness): static
    {
        $this->borderDark = $this->setValue($this->borderDark, $hue, $saturation, $lightness);

        return $this;
    }

    public function inputDark(float $hue, float $saturation, float $lightness): static
    {
        $this->inputDark = $this->setValue($this->inputDark, $hue, $saturation, $lightness);

        return $this;
    }

    public function cardDark(float $hue, float $saturation, float $lightness): static
    {
        $this->cardDark = $this->setValue($this->cardDark, $hue, $saturation, $lightness);

        return $this;
    }

    public function cardForegroundDark(float $hue, float $saturation, float $lightness): static
    {
        $this->cardForegroundDark = $this->setValue($this->cardForegroundDark, $hue, $saturation, $lightness);

        return $this;
    }

    public function primaryDark(float $hue, float $saturation, float $lightness): static
    {
        $this->primaryDark = $this->setValue($this->primaryDark, $hue, $saturation, $lightness);

        return $this;
    }

    public function primaryForegroundDark(float $hue, float $saturation, float $lightness): static
    {
        $this->primaryForegroundDark = $this->setValue($this->primaryForegroundDark, $hue, $saturation, $lightness);

        return $this;
    }

    public function secondaryDark(float $hue, float $saturation, float $lightness): static
    {
        $this->secondaryDark = $this->setValue($this->secondaryDark, $hue, $saturation, $lightness);

        return $this;
    }

    public function secondaryForegroundDark(float $hue, float $saturation, float $lightness): static
    {
        $this->secondaryForegroundDark = $this->setValue($this->secondaryForegroundDark, $hue, $saturation, $lightness);

        return $this;
    }

    public function accentDark(float $hue, float $saturation, float $lightness): static
    {
        $this->accentDark = $this->setValue($this->accentDark, $hue, $saturation, $lightness);

        return $this;
    }

    public function accentForegroundDark(float $hue, float $saturation, float $lightness): static
    {
        $this->accentForegroundDark = $this->setValue($this->accentForegroundDark, $hue, $saturation, $lightness);

        return $this;
    }

    public function destructiveDark(float $hue, float $saturation, float $lightness): static
    {
        $this->destructiveDark = $this->setValue($this->destructiveDark, $hue, $saturation, $lightness);

        return $this;
    }

    public function destructiveForegroundDark(float $hue, float $saturation, float $lightness): static
    {
        $this->destructiveForegroundDark = $this->setValue($this->destructiveForegroundDark, $hue, $saturation, $lightness);

        return $this;
    }

    public function ringDark(float $hue, float $saturation, float $lightness): static
    {
        $this->ringDark = $this->setValue($this->ringDark, $hue, $saturation, $lightness);

        return $this;
    }

    public function radiusDark(string $radius): static
    {
        $this->radiusDark = $radius;

        return $this;
    }

    protected function setValue($old, $hue, $saturation, $lightness): string
    {
        [$oldHue, $oldSaturation, $oldLightness] = explode(' ', $old);

        return implode(' ', [$hue ?? $oldHue, $saturation ?? $oldSaturation, $lightness ?? $oldLightness]);
    }

    public function toString(): string
    {
        return <<<THEME
          :root {
            --background: $this->background;
            --foreground: $this->foreground;

            --muted: $this->muted;
            --muted-foreground: $this->mutedForeground;

            --popover: $this->popover;
            --popover-foreground: $this->popoverForeground;

            --border: $this->border;
            --input: $this->input;

            --card: $this->card;
            --card-foreground: $this->cardForeground;

            --primary: $this->primary;
            --primary-foreground: $this->primaryForeground;

            --secondary: $this->secondary;
            --secondary-foreground: $this->secondaryForeground;

            --accent: $this->accent;
            --accent-foreground: $this->accentForeground;

            --destructive: $this->destructive;
            --destructive-foreground: $this->destructiveForeground;

            --ring: $this->ring;

            --radius: $this->radius;
          }

          .dark {
            --background: $this->backgroundDark;
            --foreground: $this->foregroundDark;

            --muted: $this->mutedDark;
            --muted-foreground: $this->mutedForegroundDark;

            --accent: $this->accentDark;
            --accent-foreground: $this->accentForegroundDark;

            --popover: $this->popoverDark;
            --popover-foreground: $this->popoverForegroundDark;

            --border: $this->borderDark;
            --input: $this->inputDark;

            --card: $this->cardDark;
            --card-foreground: $this->cardForegroundDark;

            --primary: $this->primaryDark;
            --primary-foreground: $this->primaryForegroundDark;

            --secondary: $this->secondaryDark;
            --secondary-foreground: $this->secondaryForegroundDark;

            --destructive: $this->destructiveDark;
            --destructive-foreground: $this->destructiveForegroundDark;

            --ring: $this->ringDark;

            --radius: $this->radiusDark;
          }                
        THEME;
    }
}
