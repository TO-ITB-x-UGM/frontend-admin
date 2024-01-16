<?php

namespace App\Controllers;

class Ranker extends BaseController
{
    function index()
    {
        $result = $this->api->getTryouts();

        if ($result->ok) {
            return view('scoring_tryout_list', [
                'title' => 'Scoring Tryout',
                'exams' => $result->data->exams
            ]);
        }
    }

    function rankTryout($exam_id)
    {
        $result = $this->api->getRankExam($exam_id);
        if ($result->ok) {
            return view('rank_tryout', [
                'title' => "Ranking: " . $result->data->exam->title,
                'exam_id' => $exam_id,
                'exam' => $result->data->exam,
                'participants' => $result->data->rank
            ]);
        }
    }

    function rankSubtest($exam_id, $subtest_id)
    {
        $result = $this->api->getRankSubtest($subtest_id);
        // dd($result);
        if ($result->ok) {
            return view('rank_subtest', [
                'title' => "Ranking: " . $result->data->subtest->title . " (" . $result->data->exam->title . ")",
                'exam_id' => $exam_id,
                'exam' => $result->data->exam,
                'participants' => $result->data->rank
            ]);
        }
    }

    function subtest($exam_id, $subtest_id)
    {
        $result = $this->api->getSubtestSummaryResult($subtest_id);
        if ($result->ok) {
            return view('scoring_item_list', [
                'title' => 'Scoring Subtest: ' . $result->data->subtest->title,
                'exam_id' => $exam_id,
                'subtest_id' => $subtest_id,
                'questions' => $result->data->questions
            ]);
        }
    }

    function preparing($subtest_id)
    {
        $result = $this->api->runPreparing($subtest_id);
        $this->response->setJSON((array)$result);
        $this->response->send();
    }

    function weighting($subtest_id)
    {
        $result = $this->api->runWeighting($subtest_id);
        $this->response->setJSON((array)$result);
        $this->response->send();
    }

    function distributing($subtest_id)
    {
        $result = $this->api->runDistributing($subtest_id);
        $this->response->setJSON((array)$result);
        $this->response->send();
    }

    function summarizing($subtest_id)
    {
        $result = $this->api->runSummarizing($subtest_id);
        $this->response->setJSON((array)$result);
        $this->response->send();
    }

    function agregating($exam_id)
    {
        $result = $this->api->runAgregating($exam_id);
        $this->response->setJSON((array)$result);
        $this->response->send();
    }

    function printExamRank($exam_id)
    {
        $result = $this->api->getFullRank($exam_id);
        // dd($result);
        return view('print_rank', [
            'title' => 'Peringkat ' . $result->data->exam->title,
            'subtests' => $result->data->subtests,
            'participants' => $result->data->rank
        ]);
    }

    function printEval($attempt_id)
    {
        return view('print_eval', [
            'title' => 'Evaluasi Hasil Tryout',
        ]);
    }

    function printExamQuestionsAnalysis($exam_id)
    {
        // $this->api->
    }

    function printSubtestQuestionsAnalysis($subtest_id)
    {
    }
}
