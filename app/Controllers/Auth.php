<?php

namespace App\Controllers;

use Exception;

class Auth extends BaseController
{
    function login()
    {
        if ($this->session->has('user_logged_in')) {
            return redirect()->to(base_url('dashboard'));
        }

        return view('login', [
            'google_client_id' => env('Google_Client_Id')
        ]);
    }

    function loginEmail()
    {
        // echo $this->request->getPost('email');
        // echo $this->request->getPost('password');
        try {
            $result = $this->api->loginEmail($this->request->getPost('email'), $this->request->getPost('password'));
            if (!$result->ok) {
                throw new Exception($result->message, $result->status_code);
            }

            // if ($result->data->account->role_id != 9) {
            //     throw new Exception("Forbidden", 403);
            // }


            $this->session->set('user_logged_in', [
                'access_token' => $result->data->access_token,
                'name' => $result->data->account->name,
                'email' => $result->data->account->email,
                'picture' => $result->data->account->picture
            ]);

            return redirect()->to(base_url('dashboard'));
        } catch (\Throwable $th) {
            setAlert($th->getMessage(), 'danger', 'Login error');
            return redirect()->to(base_url('login'));
        }
    }

    function trylogin()
    {
        echo $this->request->getPost('credential');
        echo $this->request->getPost('id_token');
        try {
            $result = $this->api->login($this->request->getPost('credential'));
            if (!$result->ok) {
                throw new Exception($result->message, $result->status_code);
            }

            // if ($result->data->account->role_id != 9) {
            //     throw new Exception("Forbidden", 403);
            // }


            $this->session->set('user_logged_in', [
                'access_token' => $result->data->access_token,
                'name' => $result->data->account->name,
                'email' => $result->data->account->email,
                'picture' => $result->data->account->picture
            ]);

            return redirect()->to(base_url('dashboard'));
        } catch (\Throwable $th) {
            setAlert($th->getMessage(), 'danger', 'Login error');
            return redirect()->to(base_url('login'));
        }
    }

    function logout()
    {
        $this->session->destroy();
        setAlert('Logout success', 'success');
        return redirect()->to(base_url('login'));
    }
}
