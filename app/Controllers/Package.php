<?php

namespace App\Controllers;

class Package extends BaseController
{
    function index()
    {
        $result = $this->api->getPackages();

        $packages = $result->data->packages;
        return view('package_list', [
            'title' => 'Paket Soal',
            'packages' => $packages
        ]);
    }

    function create()
    {
        return view('package_edit', [
            'title' => 'Buat Paket Soal',
            'id' => '',
            'package_title' => ''
        ]);
    }

    function edit($package_id)
    {
        $result = $this->api->getPackage($package_id);

        if ($result->status_code == 404) {
            setAlert("Package not found");
            return redirect()->to(base_url('package'));
        }

        $package = $result->data->package;
        return view('package_edit', [
            'title' => 'Edit Paket Soal',
            'id' => $package->id,
            'package_title' => $package->title
        ]);
    }

    function save()
    {
        if (!$this->validate([
            'title' => 'required'
        ])) {
            $errors = "Input error";
            foreach ($this->validator->getErrors() as $error) {
                $errors .= ", $error";
            }
            setAlert($errors);
            return redirect()->back()->withInput();
        }

        if ($this->request->getPost('id')) {
            $result = $this->api->editPackage($this->request->getPost('id'), [
                'title' => $this->request->getPost('title')
            ]);

            if ($result->ok) {
                setAlert("Paket soal telah diupdate", 'success', 'User Updated!');
                return redirect()->to(base_url('package'));
            }
        } else {
            $result = $this->api->createPackage($this->request->getPost());

            if ($result->ok) {
                setAlert("Paket soal telah dibuat", 'success', 'User Updated!');
                return redirect()->to(base_url('package'));
            }
        }
    }

    function ajaxDelete($id)
    {
        $this->response->setJSON((array)$this->api->deletePackage($id), true);
        $this->response->send();
    }
}
