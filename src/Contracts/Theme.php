<?php

namespace Hasnayeen\Xumina\Contracts;

interface Theme
{
    public function background(float $hue, float $saturation, float $lightness): static;

    public function foreground(float $hue, float $saturation, float $lightness): static;

    public function muted(float $hue, float $saturation, float $lightness): static;

    public function mutedForeground(float $hue, float $saturation, float $lightness): static;

    public function popover(float $hue, float $saturation, float $lightness): static;

    public function popoverForeground(float $hue, float $saturation, float $lightness): static;

    public function border(float $hue, float $saturation, float $lightness): static;

    public function input(float $hue, float $saturation, float $lightness): static;

    public function card(float $hue, float $saturation, float $lightness): static;

    public function cardForeground(float $hue, float $saturation, float $lightness): static;

    public function primary(float $hue, float $saturation, float $lightness): static;

    public function primaryForeground(float $hue, float $saturation, float $lightness): static;

    public function secondary(float $hue, float $saturation, float $lightness): static;

    public function secondaryForeground(float $hue, float $saturation, float $lightness): static;

    public function accent(float $hue, float $saturation, float $lightness): static;

    public function accentForeground(float $hue, float $saturation, float $lightness): static;

    public function destructive(float $hue, float $saturation, float $lightness): static;

    public function destructiveForeground(float $hue, float $saturation, float $lightness): static;

    public function ring(float $hue, float $saturation, float $lightness): static;

    public function backgroundDark(float $hue, float $saturation, float $lightness): static;

    public function foregroundDark(float $hue, float $saturation, float $lightness): static;

    public function mutedDark(float $hue, float $saturation, float $lightness): static;

    public function mutedForegroundDark(float $hue, float $saturation, float $lightness): static;

    public function popoverDark(float $hue, float $saturation, float $lightness): static;

    public function popoverForegroundDark(float $hue, float $saturation, float $lightness): static;

    public function borderDark(float $hue, float $saturation, float $lightness): static;

    public function inputDark(float $hue, float $saturation, float $lightness): static;

    public function cardDark(float $hue, float $saturation, float $lightness): static;

    public function cardForegroundDark(float $hue, float $saturation, float $lightness): static;

    public function primaryDark(float $hue, float $saturation, float $lightness): static;

    public function primaryForegroundDark(float $hue, float $saturation, float $lightness): static;

    public function secondaryDark(float $hue, float $saturation, float $lightness): static;

    public function secondaryForegroundDark(float $hue, float $saturation, float $lightness): static;

    public function accentDark(float $hue, float $saturation, float $lightness): static;

    public function accentForegroundDark(float $hue, float $saturation, float $lightness): static;

    public function destructiveDark(float $hue, float $saturation, float $lightness): static;

    public function destructiveForegroundDark(float $hue, float $saturation, float $lightness): static;

    public function ringDark(float $hue, float $saturation, float $lightness): static;

    public function toString(): string;
}
