<?php

class AdminController extends AppController {

    var $name = 'Admin';
    var $uses = array();

    function index() {
        $admin = $this->Session->read('Admin');
        if (empty($admin)) {
            $this->redirect(array('action' => 'login'));
        } else {
            $this->redirect(array('controller' => 'empresas', 'action' => 'view'));
        }
    }

    function login() {
        $admin = $this->Session->read('Admin');
        if (!empty($admin)) {
            $this->redirect(
                    array(
                        'action' => 'index'
                    )
            );
        } else {
            if (!empty($this->request->data)) {
                if ($this->request->data['email'] == 'admin@admin.com') {
                    if ($this->request->data['pass'] == 'admin1234') {
                        $this->Session->write('Admin', $this->request->data);
                        $this->redirect(
                                array(
                                    'action' => 'index'
                                )
                        );
                    } else {
                        $this->Session->setFlash('Contraseña incorrecta.', 'error');
                    }
                } else {
                    $this->Session->setFlash('El usuario es incorrecto.', 'success');
                }
            }
        }
    }

    function logout() {
        $admin = $this->Session->read('Admin');
        if (!$admin) {
            $this->Session->setFlash(__('No has iniciado sesión.'), 'error');
            $this->redirect(
                    array(
                        'controller' => 'usuarios',
                        'action' => 'index'
                    )
            );
        } else {
            $this->Session->delete('Admin');
            $this->redirect(
                    array(
                        'controller' => 'usuarios',
                        'action' => 'index'
                    )
            );
        }
    }

    public function env() {
        pr($_ENV);
        pr($_SERVER);
        pr($_POST);
        pr($_GET);die;
    }
}