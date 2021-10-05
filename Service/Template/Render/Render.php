<?php

namespace Rewsam\DevelopmentAssist\Service\Template\Render;

interface Render
{
    public function renderTemplate(string $name, array $params): string;

    public function render(string $template, array $params): string;
}