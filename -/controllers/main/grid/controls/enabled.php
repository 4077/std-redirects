<?php namespace std\redirects\controllers\main\grid\controls;

class Enabled extends \Controller
{
    private $redirect;

    public function __create()
    {
        if ($this->redirect = $this->unpackModel('redirect')) {
            $this->instance_($this->redirect->id);
        } else {
            $this->lock();
        }
    }

    public function reload()
    {
        $this->jquery('|')->replace($this->view());
    }

    public function view()
    {
        $v = $this->v('|');

        $redirect = $this->redirect;

        $v->assign([
                       'CONTENT' => $this->c('\std\ui button:view', [
                           'path'                        => $this->_p('~xhr:toggleEnabled'),
                           'data'                        => [
                               'redirect' => xpack_model($redirect)
                           ],
                           'eventTriggerClosestSelector' => '.cell',
                           'class'                       => 'button ' . ($redirect->enabled ? 'checked' : ''),
                           'title'                       => $redirect->enabled ? 'Выключить' : 'Включить',
                           'content'                     => '<div class="icon"></div>'
                       ])
                   ]);

        $this->css(':\js\jquery\ui icons');

        $this->e('std/redirects/update/enabled')->rebind(':reload');

        return $v;
    }
}
