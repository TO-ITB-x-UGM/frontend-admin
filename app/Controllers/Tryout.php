<?php

namespace App\Controllers;

class Tryout extends BaseController
{
    function index()
    {
        $result = $this->api->getTryouts();
        if ($result->ok) {
            return view('tryout_list', [
                'title' => 'Tryout',
                'tryouts' => $result->data->exams
            ]);
        }
    }

    function create()
    {
        return view('tryout_edit', [
            'title' => 'Buat Tryout Baru',
            'id' => '',
            'tryout_title' => '',
            'description' => '',
            'attempt_open_at' => '',
            'attempt_closed_at' => '',
            'attempt_duration' => '',
        ]);
    }

    function save()
    {
        // dd($this->request->getPost());
        if (!$this->validate([
            'title'             => 'required',
            'attempt_open_at'   => 'required',
            'attempt_closed_at' => 'required',
            'attempt_duration'  => 'required'
        ])) {
            $errors = "Input error";
            foreach ($this->validator->getErrors() as $error) {
                $errors .= ", $error";
            }
            setAlert($errors);
            return redirect()->back()->withInput();
        }

        if ($this->request->getPost('id')) {

            $result = $this->api->editTryout($this->request->getPost('id'), [
                'id'                => $this->request->getPost('id'),
                'title'             => $this->request->getPost('title'),
                'description'       => $this->request->getPost('description'),
                'attempt_open_at'   => strtotime($this->request->getPost('attempt_open_at')),
                'attempt_closed_at' => strtotime($this->request->getPost('attempt_closed_at')),
                'attempt_duration'  => (int)$this->request->getPost('attempt_duration'),
            ]);
            if ($result->ok) {
                setAlert("Tryout telah diupdate", 'success', 'Tryout Updated!');
                return redirect()->to(base_url("tryout/" . $result->data->exam_id));
            }
        } else {
            $result = $this->api->createTryout([
                'id'                => $this->request->getPost('id'),
                'title'             => $this->request->getPost('title'),
                'description'       => $this->request->getPost('description'),
                'attempt_open_at'   => strtotime($this->request->getPost('attempt_open_at')),
                'attempt_closed_at' => strtotime($this->request->getPost('attempt_closed_at')),
                'attempt_duration'  => (int)$this->request->getPost('attempt_duration'),
            ]);
            if ($result->ok) {
                setAlert("Tryout baru telah dibuat", 'success', 'Tryout Created!');
                return redirect()->to(base_url('tryout/' . $result->data->exam_id));
            }
        }
    }

    function detail($exam_id)
    {
        $tryoutRequest = $this->api->getTryout($exam_id);

        if (!$tryoutRequest->ok) {
            if ($tryoutRequest->status_code == 404) {
                setAlert("Tryout with id $exam_id not found");
                return redirect()->to(base_url('tryout'));
            }
        }

        $subtestsRequest = $this->api->getSubtests($exam_id);

        return view('tryout_detail', [
            'title' => 'Tryout Detail',
            'exam_id' => $exam_id,
            'tryout' => $tryoutRequest->data->exam,
            'subtests' => $subtestsRequest->data->subtests
        ]);
    }

    function edit($exam_id)
    {
        $result = $this->api->getTryout($exam_id);
        if ($result->ok) {
            $tryout = $result->data->exam;
            return view('tryout_edit', [
                'title'             => 'Tryout Edit',
                'id'                => $tryout->id,
                'tryout_title'      => $tryout->title,
                'description'       => $tryout->description,
                'attempt_open_at'   => $tryout->attempt_open_at,
                'attempt_closed_at' => $tryout->attempt_closed_at,
                'attempt_duration'  => $tryout->attempt_duration,
            ]);
        }
    }

    function ajaxDelete($exam_id)
    {
        $result = $this->api->deleteTryout($exam_id);
        $this->response->setJSON((array)$result, true);
        $this->response->send();
    }
}
