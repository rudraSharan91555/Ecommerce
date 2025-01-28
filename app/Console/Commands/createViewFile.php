<?php
 
namespace App\Console\Commands;
 
use Illuminate\Console\Command;
use File;
 
class createViewFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:view {view}';
 
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create a new view file';
 
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $viewname = $this->argument('view');
 
        $viewname = $viewname.'.blade.php';
 
        $pathname = "resources/views/{$viewname}";
 
        if(File::exists($pathname)){
            $this->error("file {$pathname} is already exist " );
            return;
        }
        $dir = dirname($pathname);
        if(!file_exists($dir))
        {
          mkdir($dir,0777,true);
        }
 
        $content = '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Document</title>
        </head>
        <body>
           
        </body>
        </html>';
 
        File::put($pathname , $content);
 
        $this->info("File {$pathname} is created");
       
    }
}
