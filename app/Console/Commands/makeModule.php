<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Composer;
use App\Services\PermissionGroups\PermissionGroup;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class makeModule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module {--module_name=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate module';

    /**
     * Create a new command instance.
     *
     * @param Filesystem $filesystem
     * @param Composer $composer
     */
    public function __construct(Filesystem $filesystem,
                                Composer $composer,
                                PermissionGroup $permissionGroup,
                                Permission $permission,
                                Role $role)
    {
        parent::__construct();
        $this->filesystem = $filesystem;
        $this->composer = $composer;
        $this->permissionGroup = $permissionGroup;
        $this->permission = $permission;
        $this->role = $role;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->line('--MAKE MODULE SCAFFOLDINGS--');
        $this->info('Please make sure to have it in ucwords and separated by space if multiple words eg. Product Category)');
        $this->info('This module creator refreshes the database data so make sure you have your back up.');
        $this->info('Also make sure that you have no other modified files currently so that you can revert the created module by using this commands:');
        $this->line('git checkout');
        $this->line('git clean -f -d');
        $this->line('php artisan migrate:refresh --seed');
        if ($this->confirm('Do you wish to continue?')) {
            $data = $this->getInputs();

            $bar = $this->output->createProgressBar(70);
            $bar->start();
            $bar->setEmptyBarCharacter('-');
            $bar->setBarCharacter('=');

            $this->generateServices($data);
            $bar->advance(10);
            $this->info('');
            $this->info('Controller ' . $data['module_name'] . ' Created');

            $this->generateController($data);
            $bar->advance(10);
            $this->info('');
            $this->info('Controller ' . $data['module_name'] . ' Created');

            $this->generateView($data);
            $bar->advance(10);
            $this->info('');
            $this->info('View ' . $data['module_name'] . ' Created');

            $this->generateJavascript($data);
            $bar->advance(10);
            $this->info('');
            $this->info('Javascript ' . $data['module_name'] . ' Created');

            $this->generateMigration($data);
            $bar->advance(10);
            $this->info('');
            $this->info('Migration ' . $data['module_name'] . ' Created');

            $this->generatePermissions($data);
            $bar->advance(10);
            $this->info('');
            $this->info('Permission ' . $data['module_name'] . ' Created');

            $this->generateRoute($data);
            $bar->advance(10);
            $this->info('');
            $this->info('Route ' . $data['module_name'] . ' Created');

            $bar->finish();
            $this->info('');
            $this->info('Module ' . $data['module_name'] . ' Completed');

            $this->info('');
            $this->info('Register your module at App/Providers/RepositoryServiceProvider.php');
            $this->info('Update Admin Menu at App/Providers/AdminTemplateProvider.php');
            $this->info('');
            $this->info('BJCDL | MY CMS | GEEKBIT IT SOLUTIONS | 2021');
        }
    }

    private function getInputs()
    {
        $module_name = $this->option('module_name');

        if (empty($module_name)) {
            $module_name = $this->ask('Module name');
        }

        return [
            'camel_case' => preg_replace('/\s+/', '', ucwords($module_name)),
            'camel_case_plural' => preg_replace('/\s+/', '', ucwords(str_plural($module_name))),
            'snake_case' => preg_replace('/\s+/', '_', strtolower($module_name)),
            'snake_case_plural' => preg_replace('/\s+/', '_', strtolower(str_plural($module_name))),
            'module_name' => $module_name,
            'module_name_plural' => str_plural($module_name),
            'module_name_plural_dir' => preg_replace('/\s+/', '', ucwords(str_plural($module_name))),
            'module_name_dir' => preg_replace('/\s+/', '', ucwords($module_name)),
            'module_name_dir_native' => preg_replace('/\s+/', ' ', ucwords($module_name)),
            'module_name_dir_lc_first' => preg_replace('/\s+/', '', lcfirst(ucwords($module_name))),
            'module_name_lc_first' => preg_replace('/\s+/', '', lcfirst($module_name)),
            'module_name_to_upper' => preg_replace('/\s+/', ' ', strtoupper($module_name))
        ];
    }

    private function generateServices($data)
    {
        $directory = 'app/Services/' . $data['module_name_plural_dir'] . '/';
        $subDirectories = ['Repositories/', 'Requests/'];

        if (!$this->filesystem->exists($directory)) {
            $this->filesystem->makeDirectory($directory, 0775);
        }

        foreach ($subDirectories as $subDirectory) {
            if (!$this->filesystem->exists($directory . $subDirectory)) {
                $this->filesystem->makeDirectory($directory . $subDirectory, 0775);
            }
        }
        
        $templateRepositoryInterface = $this->filesystem->get(storage_path('bjcdl/make_module_templates/services/repositories/TemplateRepositoryInterface.php'));
        $templateRepositoryInterface = $this->replaceTexts($data, $templateRepositoryInterface);
        $this->filesystem->put($directory . $subDirectories[0] . $data['module_name_dir'] . 'RepositoryInterface.php', $templateRepositoryInterface);

        $templateRepository = $this->filesystem->get(storage_path('bjcdl/make_module_templates/services/repositories/TemplateRepository.php'));
        $templateRepository = $this->replaceTexts($data, $templateRepository);
        $this->filesystem->put($directory . $subDirectories[0] . $data['module_name_dir'] . 'Repository.php', $templateRepository);

        $addTemplateRequest = $this->filesystem->get(storage_path('bjcdl/make_module_templates/services/requests/addTemplateRequest.php'));
        $addTemplateRequest = $this->replaceTexts($data, $addTemplateRequest);
        $this->filesystem->put($directory . $subDirectories[1] . 'add' . $data['module_name_dir'] . 'Request.php', $addTemplateRequest);

        $updateTemplateRequest = $this->filesystem->get(storage_path('bjcdl/make_module_templates/services/requests/updateTemplateRequest.php'));
        $updateTemplateRequest = $this->replaceTexts($data, $updateTemplateRequest);
        $this->filesystem->put($directory . $subDirectories[1] . 'update' . $data['module_name_dir'] . 'Request.php', $updateTemplateRequest);

        $modelTemplate = $this->filesystem->get(storage_path('bjcdl/make_module_templates/services/Template.php'));
        $modelTemplate = $this->replaceTexts($data, $modelTemplate);
        $this->filesystem->put($directory . $data['module_name_dir'] . '.php', $modelTemplate);
    }

    private function generateController($data)
    {
        $template = $this->filesystem->get(storage_path('bjcdl/make_module_templates/controller/TemplateController.php'));
        $template = $this->replaceTexts($data, $template);
        $this->filesystem->put('app/Http/Controllers/Admin/' . $data['camel_case'] . 'Controller.php', $template);
    }

    private function generateView($data)
    {
        $views = ['create', 'edit', 'index'];
        $directory = 'resources/views/admin/pages/' . $data['snake_case'] . '/';

        if (!$this->filesystem->exists($directory)) {
            $this->filesystem->makeDirectory($directory, 0775);
        }

        foreach ($views as $view) {
            $template = $this->filesystem->get(storage_path('bjcdl/make_module_templates/views/' . $view . '.blade.php'));
            $template = $this->replaceTexts($data, $template);
            $this->filesystem->put($directory . $view . '.blade.php', $template);
        }
    }

    private function generateJavascript($data)
    {
        $template = $this->filesystem->get(storage_path('bjcdl/make_module_templates/javascript/Templates.js'));
        $template = $this->replaceTexts($data, $template);
        $this->filesystem->put('public/js/bjcdl/libraries/' . $data['snake_case_plural'] . '.js', $template);
    }

    private function generateMigration($data)
    {
        $datetime = date('Y_m_d_His');
        $template = $this->filesystem->get(storage_path('bjcdl/make_module_templates/migration/bjcdl_create_templates_table.php'));
        $template = $this->replaceTexts($data, $template);
        $this->filesystem->put('database/migrations/' . $datetime . '_create_' . $data['snake_case_plural'] . '_table.php', $template);

        $iseed = $this->filesystem->get('Iseed.txt');
        $iseed .= "\nphp artisan iseed " . $data['snake_case_plural'] . " --force";
        $this->filesystem->put('Iseed.txt', $iseed);
    }

    private function generatePermissions($data)
    {
        $default_permissions = ['Create', 'Read', 'Update', 'Delete', 'Restore'];
        $default_permission_group = $this->permissionGroup->create([
            'name' => $data['module_name_plural'],
        ]);

        $permissions = collect([]);
        foreach ($default_permissions as $default_permission) {
            $permissions[] = $this->permission->create([
                'name' => $default_permission . ' ' . $data['module_name'],
                'permission_group_id' => $default_permission_group->id
            ]);
        }
        $roles = $this->role->whereIn('name', ['Super Admin', 'Admin'])->get();

        foreach ($roles as $role) {
            foreach ($permissions as $permission) {
                $role->givePermissionTo($permission);
            }
        }
    }

    private function generateRoute($data)
    {
        $template = $this->filesystem->get('routes/admin.php');
$template .= "\n\n/* " . $data['snake_case_plural'] . " */
Route::resource('/" . $data['snake_case_plural'] . "', 'Admin\\" . $data['camel_case'] . "Controller', [
    'as' => 'admin'
]);";

$template .= "\n\nRoute::delete('/" . $data['snake_case_plural'] . "/{id}/delete', [
    'as' => 'admin." . $data['snake_case_plural'] . ".delete',
    'uses' => '\App\Http\Controllers\Admin\\" . $data['camel_case'] . "Controller@destroy'
]);";

$template .= "\n\nRoute::get('" . $data['snake_case_plural'] . "/{id}/restore', 'Admin\\" . $data['camel_case'] . "Controller@restore')->name('admin." . $data['snake_case_plural'] . ".restore');";

$template .= "\n/* " . $data['snake_case_plural'] . " */";
        $this->filesystem->put('routes/admin.php', $template);
    }

    private function replaceTexts($data, $template)
    {
        $template = str_replace("DefaultTemplatePlural", $data['module_name_plural'], $template);
        $template = str_replace("DefaultTemplate", $data['module_name'], $template);
        $template = str_replace("TemplateCamelCasePlural", $data['camel_case_plural'], $template);
        $template = str_replace("TemplateCamelCase", $data['camel_case'], $template);
        $template = str_replace("template_snake_case_plural", $data['snake_case_plural'], $template);
        $template = str_replace("template_snake_case", $data['snake_case'], $template);
        $template = str_replace("DefaultServicePlural", $data['module_name_plural_dir'], $template);
        $template = str_replace("DefaultService", $data['module_name_dir'], $template);
        $template = str_replace("DefaultServiceNative", $data['module_name_dir_native'], $template);
        $template = str_replace("LCFirstDefault", $data['module_name_dir_lc_first'], $template);
        $template = str_replace("DefaultTemplateLC", $data['module_name_lc_first'], $template);
        $template = str_replace("HeadTextUpper", $data['module_name_to_upper'], $template);

        return $template;
    }
}
