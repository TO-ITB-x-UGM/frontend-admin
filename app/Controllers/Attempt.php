<?php

namespace App\Controllers;

class Attempt extends BaseController
{
    function index($exam_id)
    {
        $result = $this->api->getAttempts($exam_id);

        $tryout = $result->data->exam;
        $attempts = $result->data->attempts;
        return view('attempt_list', [
            'title' => 'Peserta Tryout: ' . $tryout->title,
            'exam_id' => $tryout->id,
            'attempts' => $attempts
        ]);
    }

    function add($exam_id)
    {
        return view('attempt_edit', [
            'title' => 'Tambah Peserta Manual',
            'exam_id' => $exam_id,
            'id' => '',
            'email' => '',
            'started_at' => '',
            'ended_at' => '',
            'score_agregate' => '',
            'user_name' => '',
            'user_id' => ''
        ]);
    }

    function save($exam_id)
    {
        if (!$this->validate([
            'exam_id' => 'required',
            'user_id' => 'required',
            'started_at' => 'required',
            'ended_at' => 'required',
        ])) {
            $errors = "Input error";
            foreach ($this->validator->getErrors() as $error) {
                $errors .= ", $error";
            }
            setAlert($errors);
            return redirect()->back()->withInput();
        };

        if ($this->request->getPost('id')) {
            $result = $this->api->editAttempt($this->request->getPost('id'), [
                'id'            => $this->request->getPost('id'),
                'user_id'       => $this->request->getPost('user_id'),
                'started_at'    => strtotime($this->request->getPost('started_at')),
                'ended_at'      => strtotime($this->request->getPost('ended_at')),
                'exam_id'       => $exam_id,
            ]);

            if ($result->ok) {
                setAlert("Data pengerjaan peserta telah diubah", 'success');
                return redirect()->to(base_url("tryout/$exam_id/participant/" . $this->request->getPost('id')));
            }
        } else {
            $result = $this->api->createAttempt([
                'user_id'       => $this->request->getPost('user_id'),
                'started_at'    => strtotime($this->request->getPost('started_at')),
                'ended_at'      => strtotime($this->request->getPost('ended_at')),
                'exam_id'       => $exam_id,
            ]);

            if ($result->ok) {
                setAlert("Peserta telah ditambahkan", 'success');
                return redirect()->to(base_url("tryout/$exam_id/participant"));
            }
        }
    }

    function edit($exam_id, $attempt_id)
    {
        $result = $this->api->getAttempt($attempt_id);

        if ($result->ok) {
            return view('attempt_edit', [
                'title'             => 'Edit Status Pengerjaan',
                'exam_id'         => $exam_id,
                'id'                => $result->data->attempt->id,
                'email'             => $result->data->user->email,
                'started_at'        => $result->data->attempt->started_at,
                'ended_at'          => $result->data->attempt->ended_at,
                'score_agregate'    => $result->data->attempt->score_agregate,
                'user_name'         => $result->data->user->name,
                'user_id'           => $result->data->attempt->user_id
            ]);
        }
    }

    function detail($exam_id, $attempt_id)
    {
        $result = $this->api->getAttempt($attempt_id);
        // dd($result);
        if ($result->ok) {
            return view('attempt_detail', [
                'title'             => 'Detail Pengerjaan',
                'exam_id'           => $exam_id,
                'tryout'            => $result->data->exam,
                'user'              => $result->data->user,
                'attempt'           => $result->data->attempt,
                'subattempts'       => array_merge($result->data->subattempts->tps, $result->data->subattempts->tka)
            ]);
        }
    }

    function ajaxDelete($id)
    {
        $this->response->setJSON((array)$this->api->deleteAttempt($id), true);
        $this->response->send();
    }

    function subtest($exam_id, $subtest_id)
    {
        $result = $this->api->getSubattemptsBySubtestId($subtest_id);

        if ($result->ok) {
            return view('subattempt_list', [
                'title' => 'Pengerjaan Subtest: ' . $result->data->subtest->title,
                'exam_id' => $exam_id,
                'subtest_id' => $subtest_id,
                'subattempts' => $result->data->subattempts
            ]);
        }
    }

    function ajaxSubattemptDelete($subattempt_id)
    {
        $this->response->setJSON((array)$this->api->deleteSubattempt($subattempt_id), true);
        $this->response->send();
    }

    function subattempt($exam_id, $attempt_id, $subattempt_id)
    {
        // $subattempt = $this->api->getSubattempt($subattempt_id);
        // $attempt = $this->api->getAttempt($attempt_id);
        // $subtest = $this->api->getSubtest($subattempt->subtest_id);
        $result = $this->api->reviewSubattempt($subattempt_id);
        // dd($result);
        // dd($subattempt);

        return view('subattempt_review', [
            'title' => 'Pengerjaan Subtest',
            'exam_id'           => $exam_id,
            'exam'              => $result->data->exam,
            'user'              => $result->data->account,
            'subtest'           => $result->data->subtest,
            'subattempt'        => $result->data->subattempt,
            'attempt_id'        => $attempt_id,
            'answers'           => $result->data->answers
        ]);
    }
}
