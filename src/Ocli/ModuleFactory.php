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
     * @var \Symfony\Component\Filesystem\Filesystem
     */
    private $filesystem;
    /**
     * @var \Symfony\Component\Finder\Finder
     */
    private $finder;

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
        $this->filesystem = new Filesystem();
        $this->finder = new Finder();

        $ds = DIRECTORY_SEPARATOR;
        $this->paths = [
            'adminController'   => DIR_APPLICATION . 'controller' . $ds,
            'adminModel'        => DIR_APPLICATION . 'model' . $ds,
            //'adminView'         => DIR_APPLICATION . 'view' . $ds . 'template' . $ds,
            //'adminLanguage'     => DIR_APPLICATION . 'language' . $ds,
            'catalogController' => DIR_APPLICATION . '../catalog' . $ds . 'controller' . $ds,
            //'catalogModel'      => DIR_APPLICATION . '../catalog' . $ds . 'model' . $ds,
            'catalogView'       => DIR_APPLICATION . '../catalog' . $ds . 'view' . $ds . 'theme' . $ds,
            //'catalogLanguage'   => DIR_APPLICATION . '../catalog' . $ds . 'language' . $ds,
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
        $files = $this->searchTemplateFile($name);
        foreach ($files as $file) {
            $template = $file->getContents();
            $template = str_replace(
                [
                    '$moduleControllerName',
                    '$modulePath',
                    '$moduleTemplatePath',
                ],
                [
                    $this->getModuleName(),
                    $this->path,
                    'module/test.tpl',
                ],
                $template
            );

            $this->writeFile($name, $template);
        }
    }

    public function createAdminModel($name)
    {
        $files = $this->searchTemplateFile($name);
        foreach ($files as $file) {
            $template = $file->getContents();
            $template = str_replace('$moduleModelName', $this->getModuleName(), $template);
            $this->writeFile($name, $template);
        }
    }

    public function createCatalogController($name)
    {
        $files = $this->searchTemplateFile($name);
        foreach ($files as $file) {
            $template = $file->getContents();
            $template = str_replace(
                [
                    '$moduleControllerName',
                    '$modulePath',
                    '$moduleTemplatePath',
                ],
                [
                    $this->getModuleName(),
                    $this->path,
                    'module/test.tpl',
                ],
                $template
            );

            $this->writeFile($name, $template);
        }
    }

    /**
     * @param $name string
     * @return \Symfony\Component\Finder\SplFileInfo[]
     */
    private function searchTemplateFile($name)
    {
        return $this->finder->files()->in(__DIR__ . '/Template/')->name($name . '.*');
    }

    /**
     * @param $name string
     * @param $data string
     * @return void
     */
    private function writeFile($name, $data)
    {
        $this->filesystem->mkdir($this->paths[$name], 0644);
        $this->filesystem->dumpFile($this->paths[$name] . $this->path . '.php', $data, 0644);
    }

    /**
     * @return string
     */
    private function getModuleName()
    {
        $name = '';
        $parts = explode('/', $this->path);
        foreach ($parts as $part) {
            $name .= ucfirst($part);
        }

        return $name;
    }
}
