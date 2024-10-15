<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeWebDao extends Command
{
    protected $signature = 'make:webdao {name}';
    protected $description = 'This Command is only for creating web dao only.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $name = $this->argument('name');
        $path = app_path("DAO/WebDao/{$name}.php");

        if (File::exists($path)) {
            $this->error("DAO service {$name} already exists!");
            return;
        }

        // Ensure the directory exists
        if (!File::isDirectory(app_path('DAO/WebDao'))) {
            File::makeDirectory(app_path('DAO/WebDao'), 0755, true);
        }

        // Create the service file
        File::put($path, $this->generateDaoContent($name));

        $this->info("DAO service {$name} created successfully.");
    }

    protected function generateDaoContent($name)
    {
        return <<<EOT
        <?php

        namespace App\DAO\WebDao;

        use App\Models\{};
        
        class {$name}{
            
            public function functionNameHere()
            {

            }
        }

        EOT;
    }
}
