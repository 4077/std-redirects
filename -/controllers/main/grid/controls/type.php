<?php namespace std\redirects\controllers\main\grid\controls;

class Type extends \Controller
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
                           'path'    => '~xhr:toggleType',
                           'data'    => [
                               'redirect' => xpack_model($redirect)
                           ],
                           'class'   => 'button type_' . $redirect->type,
                           'content' => $redirect->type
                       ])
                   ]);

        $this->css();

        $this->e('std/redirects/update/type')->rebind(':reload');

        return $v;
    }
}
