<?php

namespace Vignesh\Laracrm;

use Artisan;
use Illuminate\Support\Facades\Blade;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

use Vignesh\Laracrm\Helpers\LCAHelper;

class LCAProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // @mkdir(base_path('resources/laraadmin'));
        // @mkdir(base_path('database/migrations/laraadmin'));
        /*
        $this->publishes([
            __DIR__.'/Templates' => base_path('resources/laraadmin'),
            __DIR__.'/config.php' => base_path('config/laraadmin.php'),
            __DIR__.'/Migrations' => base_path('database/migrations/laraadmin')
        ]);
        */
        //echo "Laracrm Migrations started...";
        // Artisan::call('migrate', ['--path' => "vendor/dwij/laraadmin/src/Migrations/"]);
        //echo "Migrations completed !!!.";
        // Execute by php artisan vendor:publish --provider="Vignesh\Laracrm\LCAProvider"

		/*
        |--------------------------------------------------------------------------
        | Blade Directives for Entrust not working in Laravel 5.3
        |--------------------------------------------------------------------------
        */
		if(LCAHelper::laravel_ver() == 5.5) {

			// Call to Entrust::hasRole
			Blade::directive('role', function($expression) {
				return "<?php if (\\Entrust::hasRole({$expression})) : ?>";
			});

			// Call to Entrust::can
			Blade::directive('permission', function($expression) {
				return "<?php if (\\Entrust::can({$expression})) : ?>";
			});

			// Call to Entrust::ability
			Blade::directive('ability', function($expression) {
				return "<?php if (\\Entrust::ability({$expression})) : ?>";
			});
		}
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        include __DIR__.'/routes.php';

		// For LCAEditor
		if(file_exists(__DIR__.'/../../lcaeditor')) {
			include __DIR__.'/../../lcaeditor/src/routes.php';
		}

        /*
        |--------------------------------------------------------------------------
        | Providers
        |--------------------------------------------------------------------------
        */

        // Collective HTML & Form Helper
        $this->app->register(\Collective\Html\HtmlServiceProvider::class);
        // For Datatables
        $this->app->register(\Yajra\Datatables\DatatablesServiceProvider::class);
        // For Gravatar
        $this->app->register(\Creativeorange\Gravatar\GravatarServiceProvider::class);
        // For Entrust
        $this->app->register(\Zizaco\Entrust\EntrustServiceProvider::class);
        // For Spatie Backup
        $this->app->register(\Spatie\Backup\BackupServiceProvider::class);

        /*
        |--------------------------------------------------------------------------
        | Register the Alias
        |--------------------------------------------------------------------------
        */

        $loader = AliasLoader::getInstance();

        // Collective HTML & Form Helper
        $loader->alias('Form', \Collective\Html\FormFacade::class);
        $loader->alias('HTML', \Collective\Html\HtmlFacade::class);

        // For Gravatar User Profile Pics
        $loader->alias('Gravatar', \Creativeorange\Gravatar\Facades\Gravatar::class);

        // For LaraAdmin Code Generation
        $loader->alias('CodeGenerator', \Vignesh\Laracrm\CodeGenerator::class);

        // For LaraAdmin Form Helper
        $loader->alias('LCAFormMaker', \Vignesh\Laracrm\LCAFormMaker::class);

        // For LaraAdmin Helper
        $loader->alias('LCAHelper', \Vignesh\Laracrm\Helpers\LCAHelper::class);

        // LaraAdmin Module Model
        $loader->alias('Module', \Vignesh\Laracrm\Models\Module::class);

		// For LaraAdmin Configuration Model
		$loader->alias('LCAConfigs', \Vignesh\Laracrm\Models\LCAConfigs::class);

        // For Entrust
		$loader->alias('Entrust', \Zizaco\Entrust\EntrustFacade::class);
        $loader->alias('role', \Zizaco\Entrust\Middleware\EntrustRole::class);
        $loader->alias('permission', \Zizaco\Entrust\Middleware\EntrustPermission::class);
        $loader->alias('ability', \Zizaco\Entrust\Middleware\EntrustAbility::class);

        /*
        |--------------------------------------------------------------------------
        | Register the Controllers
        |--------------------------------------------------------------------------
        */

        $this->app->make('Vignesh\Laracrm\Controllers\ModuleController');
        $this->app->make('Vignesh\Laracrm\Controllers\FieldController');
        $this->app->make('Vignesh\Laracrm\Controllers\MenuController');

		// For LCAEditor
		if(file_exists(__DIR__.'/../../lcaeditor')) {
			$this->app->make('Vignesh\Lcaeditor\Controllers\CodeEditorController');
		}

		/*
        |--------------------------------------------------------------------------
        | Blade Directives
        |--------------------------------------------------------------------------
        */

        // LCAForm Input Maker
        Blade::directive('lca_input', function($expression) {
			if(LCAHelper::laravel_ver() == 5.5) {
				$expression = "(".$expression.")";
			}
            return "<?php echo LCAFormMaker::input$expression; ?>";
        });

        // LCAForm Form Maker
        Blade::directive('lca_form', function($expression) {
			if(LCAHelper::laravel_ver() == 5.5) {
				$expression = "(".$expression.")";
			}
            return "<?php echo LCAFormMaker::form$expression; ?>";
        });

        // LCAForm Maker - Display Values
        Blade::directive('lca_display', function($expression) {
			if(LCAHelper::laravel_ver() == 5.5) {
				$expression = "(".$expression.")";
			}
            return "<?php echo LCAFormMaker::display$expression; ?>";
        });

        // LCAForm Maker - Check Whether User has Module Access
        Blade::directive('lca_access', function($expression) {
			if(LCAHelper::laravel_ver() == 5.5) {
				$expression = "(".$expression.")";
			}
            return "<?php if(LCAFormMaker::lca_access$expression) { ?>";
        });
        Blade::directive('endlca_access', function($expression) {
            return "<?php } ?>";
        });

        // LCAForm Maker - Check Whether User has Module Field Access
        Blade::directive('lca_field_access', function($expression) {
			if(LCAHelper::laravel_ver() == 5.5) {
				$expression = "(".$expression.")";
			}
            return "<?php if(LCAFormMaker::lca_field_access$expression) { ?>";
        });
        Blade::directive('endlca_field_access', function($expression) {
            return "<?php } ?>";
        });

        /*
        |--------------------------------------------------------------------------
        | Register the Commands
        |--------------------------------------------------------------------------
        */

		$commands = [
            \Vignesh\Laracrm\Commands\Migration::class,
            \Vignesh\Laracrm\Commands\Crud::class,
            \Vignesh\Laracrm\Commands\Packaging::class,
            \Vignesh\Laracrm\Commands\LCAInstall::class
        ];

		// For LCAEditor
		if(file_exists(__DIR__.'/../../laeditor')) {
			$commands[] = \Vignesh\Laeditor\Commands\LCAEditor::class;
		}

        $this->commands($commands);
    }
}
