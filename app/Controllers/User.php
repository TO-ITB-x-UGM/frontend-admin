<?php

namespace App\Controllers;

use Exception;

class User extends BaseController
{
    public function committe()
    {
        $result = $this->api->getUserCommitte();
        if ($result->ok) {
            return view('user_list', [
                'title' => 'Panitia',
                'role' => 'committe',
                'role_id' => 9,
                'users' => $result->data->users
            ]);
        } else {
            dd($result);
        }
    }

    public function participant()
    {
        $result = $this->api->getUserParticipant();
        return view('user_list', [
            'title' => 'Peserta',
            'role_id' => 1,
            'role' => 'participant',
            'users' => $result->data->users
        ]);
    }

    public function create()
    {
        return view('user_edit', [
            'title' => "Create New User",
            'selected_role_id' => $this->request->getGet('role'),
            'id'                => '',
            'name'              => '',
            'email'             => '',
	    'password'		=> '',
            'school'            => '',
            'role'              => $this->request->getGet('role') == 9 ? 'committe' : 'participant',
            'phone_number'      => '',
        ]);
    }

    public function save()
    {
        if (!$this->validate([
            'name'      => 'required',
            'role_id'   => 'required'
        ])) {
            $errors = "Input error";
            foreach ($this->validator->getErrors() as $error) {
                $errors .= ", $error";
            }
            setAlert($errors);
            return redirect()->back()->withInput();
        }

        if ($this->request->getPost('id')) {
            $result = $this->api->editUser($this->request->getPost('id'), $this->request->getPost());

            if ($result->ok) {
                if ($this->request->getPost('role_id') == 9) {
                    $path = 'user/committe';
                } else {
                    $path = 'user/participant';
                }
                setAlert("Userdata telah diupdate", 'success', 'User Updated!');
                return redirect()->to(base_url($path));
            }
        } else {

            $result = $this->api->createUser($this->request->getPost());

            if ($result->ok) {
                if ($this->request->getPost('role_id') == 9) {
                    $path = 'user/committe';
                } else {
                    $path = 'user/participant';
                }
                $name = $result->data->account->name;
                setAlert("User $name telah dibuat", 'success', 'User Created!');
                return redirect()->to(base_url($path));
            }
        }
    }

    function importForm()
    {
        return view('user_import', [
            'title' => 'Import Users',
            'selected_role_id' => $this->request->getGet('role')
        ]);
    }

    public function import()
    {
        $xlsx = $this->request->getFile('file');
        // $ext = pathinfo($xlsx, PATHINFO_EXTENSION);
        
        if (!$xlsx->isValid()) {
            throw new \RuntimeException($xlsx->getErrorString() . '(' . $xlsx->getError() . ')');
        }else if (!preg_match("/\.(xlsx|csv)$/", $xlsx)){
            echo "hoaks";
        }else{
        

            $newName = $xlsx->getRandomName();
            $xlsx->move(WRITEPATH . 'uploads/xlsx', $newName);

            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load(WRITEPATH . 'uploads/xlsx/' . $newName);
            $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

            $finaldata = [];
            helper('text');
            foreach ($sheetData as $i => $row) {
                if ($i == 1) {
                    continue;
                }

                $finaldata[] = [
                    'name'          => $row['A'],
                    'email'         => $row['B'],
                    'school'        => $row['C'],
                    'phone_number'  => $row['D'],
                    'role_id'       => $row['E']
                ];
            }

            $result = $this->api->createUserBatch($finaldata);

            if ($result->ok) {
                return view('user_import_done', [
                    'title' => 'Import Users',
                    'users' => $result->data->users
                ]);
            }
        }
    }

    function edit($user_id)
    {
        $result = $this->api->getUser($user_id);
        if ($result->ok) {
            $account = $result->data->account;
            return view('user_edit', [
                'title'             => 'Edit User',
                'id'                => $account->id,
                'name'              => $account->name,
                'email'             => $account->email,
		'password'          => $account->password,
                'school'            => $account->school,
                'phone_number'      => $account->phone_number,
                'selected_role_id'  => $account->role_id,
                'role'              => ($account->role_id == 9) ? 'committe' : 'participant'
            ]);
        }
    }

    function ajaxDelete($user_id)
    {
        $result = $this->api->deleteUser($user_id);
        $this->response->setJSON((array)$result, true);
        $this->response->send();
    }

    function check()
    {
        $email = $this->request->getGet('email');
        $result = $this->api->getUserByEmail($email);
        $this->response->setJSON((array)$result);
        $this->response->send();
    }
}
