<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Events\Dispatcher;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Dispatcher $events)
    {
        //

        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {
            // Add some items to the menu...
            $event->menu->add('MAIN NAVIGATION');
            $event->menu->add([
                'text' => 'Arsip',
                'url' => route('admin.data.index'),
            ]);

            $event->menu->add([
                'text' => 'Personil',
                'url' => route('admin.personil.index'),
            ]);


            

            // $event->menu->add([
            //     'text' => 'Laporan',
            //     'url' => route('admin.laporan.index')
            // ]);

            $event->menu->add('SETTING');
            $event->menu->add([
                'text' => 'Data Type',
                'url' => route('admin.post-type.index'),
                'can'=>'is_supper'
            ]);

          
            $event->menu->add([
                'text' => 'Taxonomy',
                'url' => route('admin.taxonomy.index'),
                'can'=>'is_supper'

            ]);

            $event->menu->add([
                'text' => 'User',
                'url' => route('admin.users.index'),
                'can'=>'is_supper'
                
            ]);

        });
    }
}
