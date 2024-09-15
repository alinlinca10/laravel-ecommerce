<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FrontendController extends Controller
{
    public $restful = true;

    // pages in root folder
    public function pages($page_name = null)
    {
 
      if(!$page_name)
        $page_name = Page::homepage();

        $page = Page::getOnePage($page_name);

        if ($page) {
            $user = Auth::check() ? Auth::user() : null;
            if ($page->access_level > 0 && (!$user || $user->access_level < $page->access_level)) {
                return abort(404);
            }

           

            // return view('frontend/templates/template-' . $page->template)
            return view('frontend/layouts/app')
                ->with(compact('page'))
                ->with(compact('user'));

        } elseif (view()->exists('frontend/pages.' . $page_name)) {
            // pages from view
            return view('frontend/pages.' . $page_name);
        } elseif (view()->exists('frontend/pages/' . $page_name . '.index')) {
            // home folder from view
            return view('frontend/pages/' . $page_name . '.index');
        } else {
            abort(404);
        }

    }

    // pages in other folders
    public function pages_in_dir($path, $page_name, $id = null)
    {
 
        $page = Page::getOnePage($page_name, $path);
        if ($page) {
            $user = Auth::check() ? Auth::user() : null;

            if ($page->access_level > 0 && (!$user || $user->access_level < $page->access_level)) {
                return abort(404);
            }

            return view('frontend/templates/template-' . $page->template)
                ->with(compact('page'))
                ->with(compact('user'))
                ->with(compact('id'));

        } elseif (view()->exists('frontend/pages/' . $path . '.' . $page_name)) {
            // page from view
            return view('frontend/pages/' . $path . '.' . $page_name);
        } elseif (is_numeric($page_name)) {
            // if last segment in url is numeric
            $id   = $page_name;
            $path = explode('/', $path);
            end($path);
            $page_name = array_pull($path, key($path));
            return $this->pages_in_dir(implode("/", $path), $page_name, $id);
        } else {
            abort(404);
        }

    }
}
