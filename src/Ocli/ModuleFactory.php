<?php

namespace Ocli;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class ModuleFactory
{
    /**
     * @var array
     */
    private $paths;

    /**
     * @var FileCreator
     */
    private $creator;

    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $theme;

    function __construct($path, $theme)
    {
        $this->creator = new FileCreator();
        $this->path = $path;
        $this->theme = $theme;

        $ds = DIRECTORY_SEPARATOR;
        $this->paths = [
            'adminController'   => DIR_APPLICATION . 'controller' . $ds,
            /*'adminLanguage'     => DIR_APPLICATION . 'language' . $ds,
            'adminModel'        => DIR_APPLICATION . 'model' . $ds,
            'adminView'         => DIR_APPLICATION . 'view' . $ds . 'template' . $ds,
            'catalogController' => DIR_APPLICATION . '../catalog' . $ds . 'controller' . $ds,
            'catalogLanguage'   => DIR_APPLICATION . '../catalog' . $ds . 'language' . $ds,
            'catalogModel'      => DIR_APPLICATION . '../catalog' . $ds . 'model' . $ds,
            'catalogView'       => DIR_APPLICATION . '../catalog' . $ds . 'view' . $ds . 'theme' . $ds,*/
        ];
    }

    public function createFiles()
    {
        foreach ($this->paths as $name => $path) {
            $f = 'create' . ucfirst($name);
            $this->$f($name);
        }
    }

    public function createAdminController($name)
    {
        $fs = new Filesystem();
        $finder = new Finder();

        $files = $finder->files()->in(__DIR__ . '/Template/')->name($name . '.*');
        foreach ($files as $file) {
            $template = $file->getContents();
            $template = str_replace(
                [
                    '$moduleControllerName',
                    '$modulePath',
                    '$moduleTemplatePath',
                ],
                [
                    'ModuleTest',
                    'module/test',
                    'module/test.tpl',
                ],
                $template
            );

            $fs->mkdir($this->paths[$name], 0644);
            $fs->dumpFile($this->paths[$name] . $this->path . '.php', $template, 0644);
        }
    }
}
