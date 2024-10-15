<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeWebService extends Command
{
    protected $signature = 'make:webservice {name}';
    protected $description = 'This command is for creating web servies only.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $name = $this->argument('name');
        $path = app_path("Services/WebServices/{$name}.php");

        if (File::exists($path)) {
            $this->error("Service {$name} already exists!");
            return;
        }

        if (!File::isDirectory(app_path('Services/WebServices'))) {
            File::makeDirectory(app_path('Services/WebServices'), 0755, true);
        }

        File::put($path, $this->generateServiceContent($name));

        $this->info("Service {$name} created successfully.");
    }

    protected function generateServiceContent($name)
    {
        return <<<EOT
        <?php

        namespace App\Services\WebServices;

        use App\DAO\WebDao\{};
        
        class {$name}{
        
            public function __construct()
            {
                // Initialize DAO service
            }

            public function functionNameHere()
            {
            
            }
        }

        EOT;
    }

}
