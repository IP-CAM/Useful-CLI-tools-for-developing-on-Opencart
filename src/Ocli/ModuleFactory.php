<?php

namespace Ocli;

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
    }

    protected function getModulePaths()
    {
        $ds = DIRECTORY_SEPARATOR;
        $this->paths = [
            'adminController'   => $ds . 'controller' . $ds,
            'adminLanguage'     => DIR_APPLICATION . 'language' . $ds,
            'adminModel'        => DIR_APPLICATION . 'model' . $ds,
            'adminView'         => DIR_APPLICATION . 'view' . $ds . 'template' . $ds,
            'catalogController' => DIR_APPLICATION . '../catalog' . $ds . 'controller' . $ds,
            'catalogLanguage'   => DIR_APPLICATION . '../catalog' . $ds . 'language' . $ds,
            'catalogModel'      => DIR_APPLICATION . '../catalog' . $ds . 'model' . $ds,
            'catalogView'       => DIR_APPLICATION . '../catalog' . $ds . 'view' . $ds . 'theme' . $ds,
        ];
    }
    
    public function createFiles()
    {
        foreach ($this->paths as $path) {
            $this->create{ucfirst($path)}($path);
        }
    }

    public function createAdminController($path)
    {
        if ($this->creator->createFile($path)) {
            return true;
        }

        return false;
    }
}
