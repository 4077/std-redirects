<?php namespace std\redirects\controllers\main\grid\controls;

class Route extends \Controller
{
    private $redirect;

    private $field;

    public function __create()
    {
        $this->redirect = $this->unpackModel('redirect') or $this->lock();

        if (in($this->data('field'), 'source, target')) {
            $this->field = $this->data['field'];
        } else {
            $this->lock();
        }
    }

    public function view()
    {
        $redirect = $this->redirect;
        $field = $this->field;

        return $this->c('\std\ui txt:view', [
            'path'                       => $this->_p('~xhr:updateRoute'),
            'data'                       => [
                'redirect' => xpack_model($redirect),
                'field'    => $field
            ],
            'fitInputToClosest'          => '.cell',
            'editTriggerClosestSelector' => '.cell',
            'class'                      => 'txt',
            'content'                    => $redirect->{$field}
        ]);
    }
}
