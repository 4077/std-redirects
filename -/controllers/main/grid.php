<?php namespace std\redirects\controllers\main;

class Grid extends \Controller
{
    public function reload()
    {
        $this->jquery()->replace($this->view());
    }

    public function view()
    {
        $v = $this->v();

        $v->assign([
                       'CONTENT' => $this->c('\std\ui\grid~:view|' . $this->_nodeId(), [
                           'defaults' => [
                               'model'   => \std\redirects\models\Redirect::class,
                               'pager'   => ['page' => 1, 'per_page' => 20],
                               'sorter'  => ['source' => 'ASC'],
                               'columns' => $this->getColumns()
                           ]
                       ])
                   ]);

        $this->e('std/redirects/create')->rebind(':reload');
        $this->e('std/redirects/delete')->rebind(':reload');

        $this->css();

        return $v;
    }

    private function getColumns()
    {
        return [
            'enabled'        => [
                'label'         => 'Включен',
                'label_visible' => false,
                'sortable'      => true,
                'width'         => 33,
                'control'       => [
                    '>controls/enabled:view',
                    [
                        'redirect' => '%model'
                    ]
                ]
            ],
            'type'           => [
                'label'    => 'Тип',
                'sortable' => true,
                'width'    => 45,
                'control'  => [
                    '>controls/type:view',
                    [
                        'redirect' => '%model'
                    ]
                ]
            ],
            'source'         => [
                'label'    => 'Откуда',
                'sortable' => true,
                'width'    => 300,
                'control'  => [
                    '>controls/route:view',
                    [
                        'redirect' => '%model',
                        'field'    => 'source'
                    ]
                ]
            ],
            'target'         => [
                'label'    => 'Куда',
                'sortable' => true,
                'width'    => 300,
                'control'  => [
                    '>controls/route:view',
                    [
                        'redirect' => '%model',
                        'field'    => 'target'
                    ]
                ]
            ],
            'triggers_count' => [
                'label'    => 'Срабатываний',
                'sortable' => true,
                'content'  => '%value'
            ],
            'actions'        => [
                'label'         => 'Действия',
                'label_visible' => false,
                'width'         => 33,
                'field'         => false,
                'control'       => [
                    '>controls/actions:view',
                    [
                        'redirect' => '%xpack'
                    ]
                ]
            ]
        ];
    }
}
