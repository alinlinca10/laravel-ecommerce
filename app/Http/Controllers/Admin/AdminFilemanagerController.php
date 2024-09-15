<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Barryvdh\Elfinder\Session\LaravelSession;
use Barryvdh\Elfinder\Connector;
use Illuminate\Foundation\Application;
use Illuminate\Filesystem\FilesystemAdapter;

use Auth;
use General;
use Settings;

class AdminFilemanagerController extends Controller
{

    public $restful = true;
    public $folder = 'admin/filemanager';
    public $link = '/admin/file';
    public $section = 'File manager';
    public $pags = 50;

    protected $package = 'elfinder';

    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function index()
    {
        return view($this->folder . '.home')
            ->with('title', 'Filemanager');
    }

    public function standalone()
    {
        $base_path = '';

        $dir = 'packages/barryvdh/' . $this->package;
        $locale = str_replace("-",  "_", $this->app->config->get('app.locale'));
        if (!file_exists($this->app['path.public'] . "/$dir/js/i18n/elfinder.$locale.js")) {
            $locale = false;
        }
        $csrf = true;


        return view($this->folder . '.standalone')
            ->with('title', 'Filemanager')
            ->with('base_path', $base_path)
            ->with(compact('dir', 'locale', 'csrf'));
    }

    public function ckeditor()
    {
        $base_path = '';

        return view($this->folder . '.ckeditor')
            ->with('title', 'Filemanager')
            ->with('base_path', $base_path);
    }

    public function showConnector()
    {
        $roots = app()->config->get('elfinder.roots', []);
        if (empty($roots)) {

            $dirs = (array) app('config')->get('elfinder.dir', []);
            foreach ($dirs as $dir) {
               $dir_user = $dir;
                if (!is_dir($dir_user))
                    mkdir($dir_user, 0755, true);

                $roots[] = [
                    'driver' => 'LocalFileSystem', // driver for accessing file system (REQUIRED)
                    'path' => public_path($dir_user), // path to files (REQUIRED)
                    'URL' => url($dir_user), // URL to files (REQUIRED)
                    'accessControl' => app('config')->get('elfinder.access'), // filter callback (OPTIONAL)
                ];
            }

            $disks = (array) app('config')->get('elfinder.disks', []);
            foreach ($disks as $key => $root) {
                if (is_string($root)) {
                    $key = $root;
                    $root = [];
                }
                $disk = app('filesystem')->disk($key);
                dd($disk);
                if ($disk instanceof FilesystemAdapter) {
                    $defaults = [
                        'driver' => 'Flysystem',
                        'filesystem' => $disk->getDriver(),
                        'alias' => $key,
                    ];
                    $roots[] = array_merge($defaults, $root);
                }
            }
        }

        if (app()->bound('session.store')) {
            $sessionStore = app('session.store');
            $session = new LaravelSession($sessionStore);
        } else {
            $session = null;
        }

        $rootOptions = app('config')->get('elfinder.root_options', array());
        foreach ($roots as $key => $root) {
            if (Settings::get('optimize_images', 1)) {
                $roots[$key] = array_merge($rootOptions, $root);
            }
        }

        $opts = [];
        if (Settings::get('optimize_images', 1)) {
            $opts = app('config')->get('elfinder.options', array());
        }
        $opts = array_merge($opts, ['roots' => $roots, 'session' => $session]);


        // run elFinder
        $connector = new Connector(new \elFinder($opts));
        $connector->run();

        return $connector->getResponse();
    }
}
