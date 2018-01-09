<?php namespace Satudata\Lpeprovinsi\Console\Commands;

use Illuminate\Console\Command;
use File;

/**
 * The LpeprovinsiCommand class.
 *
 * @package Satudata\Lpeprovinsi
 * @author  MKI <info@mkitech.net>
 */
class LpeprovinsiCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'satudata:lpeprovinsi';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Controllers, Models, seeds, and Routes command for Modul LPEProvinsi Satudata package';

    /**
     * The console command variable.
     *
     * @var string
     */
    protected $stubsController = [
        'controllers' => [
            'LpeprovinsiController.stub'
        ]
    ];
    protected $stubsModel = [
        'models' => [
            'LpeProvinsi.stub',
            'MasterWilayah.stub'
        ]
    ];
    protected $stubsSeeds = [
        'seeds' => [
            'MasterKotaSeeder.stub',
            'MasterProvinsiSeeder.stub'
        ]
    ];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    protected function controllerViewCreate()
    {
        foreach($this->stubsController['controllers'] as $stub)
        {
            File::put(base_path('app/Http/Controllers/').str_replace('stub','php',$stub),File::get(__DIR__.'/../../stubs/Controllers/'.$stub));
        }
    }
    protected function modelViewCreate()
    {
        foreach($this->stubsModel['models'] as $stub)
        {
            File::put(base_path('app/').str_replace('stub','php',$stub),File::get(__DIR__.'/../../stubs/Models/'.$stub));
        }
    }
    protected function routeViewCreate()
    {
        File::append(base_path('routes/web.php'),File::get(__DIR__.'/../../stubs/routesweb.stub'));
    }
    protected function seedsViewCreate()
    {
        foreach($this->stubsSeeds['seeds'] as $stub)
        {
            File::put(base_path('database/seeds/').str_replace('stub','php',$stub),File::get(__DIR__.'/../../stubs/seeds/'.$stub));
        }
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->controllerViewCreate();
        $this->modelViewCreate();
        $this->routeViewCreate();
        $this->seedsViewCreate();
        $this->info('Create Controllers, Models, seeds, and Routes command for Modul LPEProvinsi Satudata package success');
    }
}
