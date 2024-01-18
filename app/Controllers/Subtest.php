<?php

namespace App\Controllers;

use Exception;

class Subtest extends BaseController
{

    function create($exam_id)
    {
        return view('subtest_edit', [
            'title' => 'Buat Subtest',
            'id' => '',
            'subtest_title' => '',
            'exam_id' => $exam_id,
            'attempt_duration' => ''
        ]);
    }

    function edit($exam_id, $subtest_id)
    {
        $result = $this->api->getSubtest($subtest_id);

        if (!$result->ok) {
            if ($result->status_code == 404) {
                setAlert("Subtest with id '$subtest_id' not found");
                return redirect()->to(base_url("tryout/$exam_id"));
            }
        }

        $subtest = $result->data->subtest;
        return view('subtest_edit', [
            'title' => 'Edit Subtest',
            'id' => $subtest->id,
            'subtest_title' => $subtest->title,
            'exam_id' => $subtest->exam_id,
            'attempt_duration' => $subtest->attempt_duration
        ]);
    }

    function save($exam_id)
    {
        try {
            if (!$this->validate([
                'title' => 'required',
                'attempt_duration' => 'required|numeric'
            ])) {
                $errors = "Input error: ";
                foreach ($this->validator->getErrors() as $error) {
                    $errors .= ", $error";
                }
                setAlert($errors);
                return redirect()->back()->withInput();
            }

            if ($this->request->getPost('id')) {
                $result = $this->api->editSubtest($this->request->getPost('id'), $this->request->getPost());
                if ($result->ok) {
                    setAlert('Subtest berhasil ditambahkan', 'success');
                    return redirect()->to(base_url("tryout/$exam_id"));
                } else {
                    throw new Exception(500, $result->message);
                }
            } else {
                $result = $this->api->createSubtest($this->request->getPost());
                if ($result->ok) {
                    setAlert('Subtest berhasil ditambahkan', 'success');
                    return redirect()->to(base_url("tryout/$exam_id"));
                } else {
                    throw new Exception(500, $result->message);
                }
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    function ajaxDelete($subtest_id)
    {
        $result = $this->api->deleteSubtest($subtest_id);
        $this->response->setJSON((array)$result);
        $this->response->send();
        die;
    }
}
