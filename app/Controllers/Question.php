<?php

namespace App\Controllers;

class Question extends BaseController
{
    function index($package_id)
    {
        $result = $this->api->getPackage($package_id);

        if ($result->status_code == 404) {
            setAlert("Package not found");
            return redirect()->to(base_url('package'));
        }

        return view('question_list', [
            'title' => 'Paket Soal: ' . $result->data->package->title,
            'package_id' => $package_id,
            'questions' => $result->data->questions
        ]);
    }

    function create($package_id, $type = null)
    {
        $title = 'Tambah Soal';
        $id = '';
        $question_type = ($type === 'multiple_choice') ? '0' : '1';
        $question_text = '';
        $question_img = '';
        $option_text_1 = '';
        $option_text_2 = '';
        $option_text_3 = '';
        $option_text_4 = '';
        $option_text_5 = '';
        $correct_option_id = '';

        if ($type === 'multiple_choice') {
            $option_text_1 = '';
            $option_text_2 = '';
            $option_text_3 = '';
            $option_text_4 = '';
            $option_text_5 = '';
            $correct_option_id = '';
        }
        if ($type === 'multiple_choice') {
            return view('question_edit', compact(
                'title',
                'id',
                'package_id',
                'question_type',
                'question_text',
                'question_img',
                'option_text_1',
                'option_text_2',
                'option_text_3',
                'option_text_4',
                'option_text_5',
                'correct_option_id'
            ));
        } else {
            return view('question_form_edit', compact(
                'title',
                'id',
                'package_id',
                'question_type',
                'question_text',
                'question_img',
                'option_text_1',
                'option_text_2',
                'option_text_3',
                'option_text_4',
                'option_text_5',
                'correct_option_id'
            ));
        }
    }

    function edit($package_id, $question_id)
    {
        $result = $this->api->getQuestion($question_id);
        if ($result->ok) {
            if ($result->data->question->question_type == 0) {
                return view('question_edit', [
                    'title' => 'Edits Soal',
                    'id'            => $question_id,
                    'package_id'    => $package_id,
                    'question_type' => $result->data->question->question_type,
                    'question_text' => $result->data->question->question_text,
                    'question_img'  => $result->data->question->question_img,
                    'option_text_1' => $result->data->question->option_text_1,
                    'option_text_2' => $result->data->question->option_text_2,
                    'option_text_3' => $result->data->question->option_text_3,
                    'option_text_4' => $result->data->question->option_text_4,
                    'option_text_5' => $result->data->question->option_text_5,
                    'correct_option_id' => $result->data->question->correct_option_id,
                ]);
            } else {
                return view('question_form_edit', [
                    'title' => 'Edits Soal',
                    'id'            => $question_id,
                    'package_id'    => $package_id,
                    'question_type' => $result->data->question->question_type,
                    'question_text' => $result->data->question->question_text,
                    'question_img'  => $result->data->question->question_img,
                    'option_text_1' => $result->data->question->option_text_1,
                    'option_text_2' => $result->data->question->option_text_2,
                    'option_text_3' => $result->data->question->option_text_3,
                    'option_text_4' => $result->data->question->option_text_4,
                    'option_text_5' => $result->data->question->option_text_5,
                    'correct_option_id' => $result->data->question->correct_option_id,
                ]);
            }
        }
    }

    function save($package_id)
    {
        if (!$this->validate([
            'package_id' => 'required',
            'question_text' => 'required',
            // 'option_text_1' => 'required',
            // 'option_text_2' => 'required',
            // 'option_text_3' => 'required',
            // 'option_text_4' => 'required',
            // 'option_text_5' => 'required',
            'correct_option_id' => 'required'
        ])) {
            $errors = "Input error: ";
            foreach ($this->validator->getErrors() as $error) {
                $errors .= ", $error";
            }
            setAlert($errors);
            return redirect()->back()->withInput();
        }

        $questionType = $this->request->getPost('question_type');

        if ($this->request->getPost('id')) {
            $result = $this->api->editQuestion($this->request->getPost('id'), [
                'id'            => $this->request->getPost('id'),
                'package_id' => $package_id,
                'question_type' => $questionType,
                'question_text' => $this->request->getPost('question_text'),
                'option_text_1' => $this->request->getPost('option_text_1'),
                'option_text_2' => $this->request->getPost('option_text_2'),
                'option_text_3' => $this->request->getPost('option_text_3'),
                'option_text_4' => $this->request->getPost('option_text_4'),
                'option_text_5' => $this->request->getPost('option_text_5'),
                'correct_option_id' => $this->request->getPost('correct_option_id'),
            ]);

            if ($result->ok) {
                setAlert('Soal telah diupdate', 'success');
                return redirect()->to(base_url("package/$package_id"));
            }
        } else {
            $result = $this->api->createQuestion([
                'package_id' => $package_id,
                'question_type' => $questionType,
                'question_text' => $this->request->getPost('question_text'),
                'option_text_1' => $this->request->getPost('option_text_1'),
                'option_text_2' => $this->request->getPost('option_text_2'),
                'option_text_3' => $this->request->getPost('option_text_3'),
                'option_text_4' => $this->request->getPost('option_text_4'),
                'option_text_5' => $this->request->getPost('option_text_5'),
                'correct_option_id' => $this->request->getPost('correct_option_id'),
            ]);

            if ($result->ok) {
                setAlert('Soal telah dibuat', 'success');
                return redirect()->to(base_url("package/$package_id"));
            }
        }
    }

    function ajaxDelete($id)
    {
        $this->response->setJSON((array)$this->api->deleteQuestion($id), true);
        $this->response->send();
    }
}
