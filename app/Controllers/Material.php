<?php

namespace App\Controllers;

class Material extends BaseController
{
    function index($exam_id, $subtest_id)
    {
        $result = $this->api->getQuestionsBySubtestId($subtest_id);
        if ($result->ok) {
            return view('material_list', [
                'subtest_id' => $subtest_id,
                'exam_id' => $exam_id,
                'title' => 'Soal Subtes: ' . $result->data->subtest->title,
                'questions' => $result->data->questions,
                'packages' => $result->data->available_packages
            ]);
        }
    }

    function import($exam_id, $subtest_id)
    {
        $this->response->setJSON((array)$this->api->importQuestion($subtest_id, $this->request->getPost('package_id')), true);
        $this->response->send();
    }

    function ajaxDelete($id)
    {
        $this->response->setJSON((array)$this->api->removeQuestion($id), true);
        $this->response->send();
    }
}
