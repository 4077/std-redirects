<?php namespace std\redirects\controllers;

class Main extends \Controller
{
    public function redirect()
    {
        $this->c_('>app:redirect');
    }

    public function reload()
    {
        $this->jquery()->replace($this->view());
    }

    public function view()
    {
        $v = $this->v();

        $d = &$this->d(false, [
            'cuts' => []
        ]);

        remap($d['cuts'], $this->data, 'cuts');

        $v->assign([
                       'GRID'          => $this->c('>grid:view'),
                       'CREATE_BUTTON' => $this->c('\std\ui button:view', [
                           'path'    => '>xhr:create',
                           'class'   => 'create_button green',
                           'content' => 'Создать редирект'
                       ])
                   ]);

        $this->c('\std\ui\dialogs~:addContainer:std/redirects');

        $this->css(':\css\std~');

        return $v;
    }
}
