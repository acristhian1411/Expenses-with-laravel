<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;


class MakeSvelteTemplate extends Command
{
    protected $signature = 'make:svelte-template {model} {fields?*} {--l|list} {--f|form} {--s|show}';
    protected $description = 'Genera plantillas Svelte para un modelo especificado';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $filesystem = new Filesystem();
        $model = $this->argument('model');
        $fields = $this->argument('fields');
        $generateList = $this->option('list');
        $generateForm = $this->option('form');
        $generateShow = $this->option('show');

        // Directorio de plantillas
        $directory = resource_path("js/Pages/{$model}s");
        $filesystem->ensureDirectoryExists($directory);

        // Generar archivos específicos o todos si no se especifican opciones
        if (!$generateList && !$generateForm && !$generateShow) {
            $generateList = $generateForm = $generateShow = true;
        }

        // Crear cada archivo según las opciones
        if ($generateList) {
            $this->createListTemplate($filesystem, $directory, $model, $fields);
        }

        if ($generateForm) {
            $this->createFormTemplate($filesystem, $directory, $model, $fields);
        }

        if ($generateShow) {
            $this->createShowTemplate($filesystem, $directory, $model, $fields);
        }

        $this->info("Plantillas Svelte generadas para el modelo {$model}");
    }

    private function createListTemplate(Filesystem $filesystem, $directory, $model, $fields)
    {
        require_once 'app/Templates/list.php';
        $content = generateListComponent($model, $fields);
        $filesystem->put(path: "{$directory}/List.svelte", contents: $content);
        $this->info("Archivo List.svelte creado para {$model}");
    }

    private function createFormTemplate(Filesystem $filesystem, $directory, $model, $fields)
    {
        require_once 'app/Templates/form.php';
        $content = generateFormComponent($model, $fields);
        $filesystem->put("{$directory}/Form.svelte", $content);
        $this->info("Archivo Form.svelte creado para {$model}");
    }

    private function createShowTemplate(Filesystem $filesystem, $directory, $model, $fields)
    {
        require_once 'app/Templates/show.php';
        $content = generateShowComponent($model, $fields);
        $filesystem->put("{$directory}/Show.svelte", $content);
        $this->info("Archivo Show.svelte creado para {$model}");
    }
}
