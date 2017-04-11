<?php
namespace Admin\Controller;

use Admin\Controller\AppController;
use Cake\Core\Configure;

use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\StreamOutput;
use Composer\Console\Application;

class ToolsController extends AppController
{

    public function index()
    {
    }

    public function composer($data = []) {
    }

    public function ajax()
    {
        $this->autoRender = false;
        if($this->request->is('ajax')) {
            $act = @$this->request->query['act'];
            $data = @$this->request->data;

            if ($act == 'composer') {
                $this->ajaxComposer($data);
            }
        }
    }

    protected function ajaxComposer($data = [])
    {
        $command = @$data['command'];
        if ($command) {
            ini_set('memory_limit', '256M');
            putenv('COMPOSER_HOME=' . __DIR__ . '/vendor/composer/composer/bin/composer');
            $path = str_ireplace('\\', '/', ROOT);
            $input = new StringInput($command.' -vvv -d '.$path);
            $output = new StreamOutput(fopen('php://output','w'));
            $app = new Application();
            $app->run($input, $output);
        }
    }

}
