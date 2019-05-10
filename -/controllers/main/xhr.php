<?php namespace std\redirects\controllers\main;

class Xhr extends \Controller
{
    public $allow = self::XHR;

    public function create()
    {
        \std\redirects\models\Redirect::create();

        $this->e('std/redirects/create')->trigger();
    }

    public function delete()
    {
        if ($this->data('discarded')) {
            $this->c('\std\ui\dialogs~:close:deleteConfirm|std/redirects');
        } else {
            if ($redirect = $this->unxpackModel('redirect')) {
                if ($this->data('confirmed')) {
                    $redirect->delete();

                    $this->c('\std\ui\dialogs~:close:deleteConfirm|std/redirects');

                    $this->e('std/redirects/delete', ['redirect_id' => $redirect->id])->trigger(['redirect' => $redirect]);
                } else {
                    $this->c('\std\ui\dialogs~:open:deleteConfirm|std/redirects', [
                        'path'            => '\std dialogs/confirm~:view',
                        'data'            => [
                            'confirm_call' => $this->_abs([':delete', ['redirect' => $this->data['redirect']]]),
                            'discard_call' => $this->_abs([':delete', ['redirect' => $this->data['redirect']]]),
                            'message'      => 'Удалить редирект <b>' . ($redirect->source ? $redirect->source : '...') . ' > ' . ($redirect->target ? $redirect->target : '...') . '</b>?'
                        ],
                        'forgot_on_close' => true,
                        'pluginOptions'   => [
                            'resizable' => 'false'
                        ]
                    ]);
                }
            }
        }
    }

    public function toggleEnabled()
    {
        if ($redirect = $this->unpackModel('redirect')) {
            $redirect->enabled = !$redirect->enabled;
            $redirect->save();

            $this->e('std/redirects/update/enabled')->trigger(['redirect' => $redirect]);
        }
    }

    public function toggleType()
    {
        if ($redirect = $this->unpackModel('redirect')) {
            if ($redirect->type == '301') {
                $redirect->type = '303';
            } else {
                $redirect->type = '301';
            }

            $redirect->save();

            $this->e('std/redirects/update/type')->trigger(['redirect' => $redirect]);
        }
    }

    public function updateRoute()
    {

        if ($redirect = $this->unpackModel('redirect')) {
            if ($field = $this->data('field') and in($field, 'source, target')) {
                $txt = \std\ui\Txt::value($this);

                $cuts = $this->d('~:cuts');

                $value = $txt->value;

                foreach ($cuts as $cut) {
                    $value = str_replace($cut, '', $value);
                }

                $value = trim_slashes($value);

                $redirect->{$field} = $value;
                $redirect->save();

                $txt->response($value);
            }
        }
    }
}
