<?php namespace std\redirects\controllers\main;

class App extends \Controller
{
    public function redirect()
    {
        if ($this->app->route && $redirect = \std\redirects\models\Redirect::where('source', $this->app->route)->where('enabled', true)->first()) {
            $this->app->response->redirect(abs_url($redirect->target), $redirect->type);

            $redirect->triggers_count++;
            $redirect->save();

            return true;
        }
    }
}
