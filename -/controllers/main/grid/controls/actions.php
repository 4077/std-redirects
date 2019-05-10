<?php namespace std\redirects\controllers\main\grid\controls;

class Actions extends \Controller
{
    private $buttons = [
        'delete' => [
            'label' => 'Удалить',
            'class' => 'delete',
            'path'  => '~xhr:delete'
        ]
    ];

    public function view()
    {
        $v = $this->v();

        foreach ($this->buttons as $button) {
            $v->assign('button', [
                'CONTENT' => $this->c('\std\ui button:view', [
                    'path'    => $button['path'],
                    'data'    => [
                        'redirect' => $this->data['redirect']
                    ],
                    'class'   => 'button ' . $button['class'],
                    'content' => '<div class="icon"></div>',
                    'attrs'   => [
                        'title' => $button['label']
                    ]
                ])
            ]);
        }

        $this->css(':\js\jquery\ui icons');

        return $v;
    }
}
