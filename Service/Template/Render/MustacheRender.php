<?php

namespace Rewsam\DevelopmentAssist\Service\Template\Render;

use Mustache_Engine;
use Mustache_Loader;
use Mustache_Loader_FilesystemLoader;
use Mustache_Loader_StringLoader;
use Mustache_Logger_StreamLogger;

class MustacheRender implements Render
{
    /**
     * @var string
     */
    private $baseDir;

    public function __construct(string $baseDir)
    {
        $this->baseDir = $baseDir;
    }

    public function renderTemplate(string $name, array $params): string
    {
        $tpl = $this->getEngine(new Mustache_Loader_FilesystemLoader($this->baseDir))->loadTemplate($name);

        return $tpl->render($params);
    }

    public function render(string $template, array $params): string
    {
        $mustache = $this->getEngine(new Mustache_Loader_StringLoader());

        return $mustache->render($template, $params);
    }

    private function getEngine(Mustache_Loader $loader): Mustache_Engine
    {
        return new Mustache_Engine(array(
            'loader' => $loader,
            //'partials_loader' => new Mustache_Loader_FilesystemLoader($this->baseDir . '/partials'),
            'helpers' => [
                'i18n' => static function($text) {
            }],
            'escape' => function($value) {
                return htmlspecialchars($value, ENT_COMPAT, 'UTF-8');
            },
            'charset' => 'ISO-8859-1',
            'logger' => new Mustache_Logger_StreamLogger('php://stderr'),
            'strict_callables' => true,
            'pragmas' => [Mustache_Engine::PRAGMA_FILTERS],
        ));
    }
}