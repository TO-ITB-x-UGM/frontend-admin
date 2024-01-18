<?php

namespace App\Libraries;

use Config\Services;
use Exception;

class Api
{
    protected string $baseURL;

    function __construct()
    {
        $this->baseURL = env('Server_Base_URL');
    }

    function request(string $method, string $endpoint, array $data = [])
    {

        $ch = curl_init();
        $url = $this->baseURL . $endpoint;
        switch ($method) {
            case "POST":
                curl_setopt($ch, CURLOPT_POST, 1);
                if ($data)
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                break;
            case "PATCH":
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
                if ($data)
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                break;
            case "DELETE":
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }

        $session = Services::session();
        $headers[] = "Content-Type: application/json";
        if ($session->has('user_logged_in')) {
            $user = $session->get('user_logged_in');
            $token = $user['access_token'];
            $headers[] = "Authorization: Bearer $token";
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20); //timeout in seconds
        $result = curl_exec($ch);
        curl_close($ch);

        // process result
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($httpcode == 0) {
            throw new Exception("Server unavailable: $this->baseURL");
        } else {
            return $result;
        }
    }

    function builder(string $method, string $endpoint, array $data = [])
    {
        $result = $this->request($method, $endpoint, $data);
        if (!$result) {
            throw new Exception("Connection Failure: No data received", 599);
        } else {

            $resultfinal = json_decode($result);
            if (!$resultfinal) {
                dd($result);
            }
            if (!property_exists($resultfinal, 'ok')) {
                // throw new Exception("Server Exception");
                dd($resultfinal);
            }

            if ($resultfinal->ok) {
                return $resultfinal;
            } else {
                if ($resultfinal->message == "Expired token") {
                    $session = \Config\Services::session();
                    $session->destroy();
                    throw new Exception("Session Expired");
                }

                return $resultfinal;
            }
        }
    }

    function ping()
    {
        return $this->builder('GET', '/ping');
    }

    // Accounts

    function login(string $credential)
    {
        return $this->builder('POST', '/auth/google', [
            'credential' => $credential
        ]);
    }

    function loginEmail(string $email, string $password)
    {
        return $this->builder('POST', '/auth/login', [
            'email' => $email,
            'password' => $password
        ]);
    }

    function getUserParticipant($limit = 0, $offset = 0)
    {
        return $this->builder('GET', '/user/participant', [
            'limit' => $limit,
            'offset' => $offset
        ]);
    }

    function getUserCommitte($limit = null, $offset = 0)
    {
        return $this->builder('GET', '/user/committe', [
            'limit' => $limit,
            'offset' => $offset
        ]);
    }

    function createUser($data)
    {
        return $this->builder('POST', '/user', $data);
    }

    function createUserBatch($users)
    {
        return $this->builder('POST', '/user/batch', [
            'users' => $users
        ]);
    }

    function getUser($user_id)
    {
        return $this->builder("GET", "/user/$user_id");
    }

    function getUserByEmail($email)
    {
        return $this->builder("GET", "/user?email=$email");
    }

    function editUser($user_id, $data)
    {
        return $this->builder('PATCH', "/user/$user_id", $data);
    }

    function deleteUser($user_id)
    {
        return $this->builder('DELETE', "/user/$user_id");
    }

    // Tryouts

    function getTryouts()
    {
        return $this->builder('GET', '/exam');
    }

    function getTryout($tryout_id)
    {
        return $this->builder('GET', "/exam/$tryout_id");
    }

    function createTryout($data)
    {
        return $this->builder('POST', '/exam', $data);
    }

    function editTryout($tryout_id, $data)
    {
        return $this->builder('PATCH', "/exam/$tryout_id", $data);
    }

    function deleteTryout($tryout_id)
    {
        return $this->builder('DELETE', "/exam/$tryout_id");
    }

    // Subtests

    function getSubtests($tryout_id)
    {
        return $this->builder('GET', "/exam/subtest?exam=$tryout_id");
    }

    function getSubtest($subtest_id)
    {
        return $this->builder('GET', "/exam/subtest/$subtest_id");
    }

    function createSubtest($data)
    {
        return $this->builder('POST', "/exam/subtest", $data);
    }

    function editSubtest($subtest_id, $data)
    {
        return $this->builder('PATCH', "/exam/subtest/$subtest_id", $data);
    }

    function deleteSubtest($subtest_id)
    {
        return $this->builder('DELETE', "/exam/subtest/$subtest_id");
    }

    // Questions

    function getQuestionsByPackage($package_id)
    {
        return $this->builder('GET', "/qbank/package/$package_id/questions");
    }

    function getQuestion($question_id)
    {
        return $this->builder('GET', "/qbank/question/$question_id");
    }

    function createQuestion($data)
    {
        return $this->builder('POST', "/qbank/question", $data);
    }

    function editQuestion($question_id, $data)
    {
        return $this->builder('PATCH', "/qbank/question/$question_id", $data);
    }

    function deleteQuestion($question_id)
    {
        return $this->builder('DELETE', "/qbank/question/$question_id");
    }

    // Packages

    function getPackages()
    {
        return $this->builder('GET', "/qbank/package");
    }

    function getPackage($package_id)
    {
        return $this->builder('GET', "/qbank/package/$package_id");
    }

    function createPackage($data)
    {
        return $this->builder('POST', "/qbank/package", $data);
    }

    function editPackage($package_id, $data)
    {
        return $this->builder('PATCH', "/qbank/package/$package_id", $data);
    }

    function deletePackage($package_id)
    {
        return $this->builder('DELETE', "/qbank/package/$package_id");
    }

    // Subtest's questions

    function getQuestionsBySubtestId($subtest_id)
    {
        return $this->builder('GET', "/exam/question?subtest=$subtest_id");
    }

    function addQuestion($question_id, $subtest_id)
    {
        return $this->builder('POST', "/exam/question", [
            'subtest_id' => $subtest_id,
            'question_id' => $question_id
        ]);
    }

    function removeQuestion($question_index_id)
    {
        return $this->builder('DELETE', "/exam/question/$question_index_id");
    }

    // function importQuestion($subtest_id, $package_id)
    function importQuestion($subtest_id, $package_id)
    {
        return $this->builder('POST', "/exam/question/import", [
            'subtest_id' => $subtest_id,
            'package_id' => $package_id
        ]);
    }

    // Attempts / Pengerjaan

    function getAttempts($tryout_id)
    {
        return $this->builder('GET', "/exam/attempt?exam=$tryout_id");
    }

    function getAttempt($attempt_id)
    {
        return $this->builder('GET', "/exam/attempt/$attempt_id");
    }

    function createAttempt($data)
    {
        return $this->builder('POST', "/exam/attempt", $data);
    }

    function editAttempt($attempt_id, $data)
    {
        return $this->builder('PATCH', "/exam/attempt/$attempt_id", $data);
    }

    function deleteAttempt($attempt_id)
    {
        return $this->builder('DELETE', "/exam/attempt/$attempt_id");
    }

    // Subattempts

    function getSubattemptsBySubtestId($subtest_id)
    {
        return $this->builder('GET', "/exam/subattempt?subtest=$subtest_id");
    }

    function getSubattemptsByAttemptId($attempt_id)
    {
        return $this->builder('GET', "/exam/subattempt?attempt=$attempt_id");
    }

    function getSubattempt($subattempt_id)
    {
        return $this->builder('GET', "/exam/subattempt/$subattempt_id");
    }

    function deleteSubattempt($subattempt_id)
    {
        return $this->builder('DELETE', "/exam/subattempt/$subattempt_id");
    }

    function reviewSubattempt($subattempt_id)
    {
        return $this->builder('GET', "/exam/subattempt/$subattempt_id/review");
    }

    // Scoring

    function getSubtestSummaryResult($subtest_id)
    {
        return $this->builder('GET', "/exam/ranker/irt-summary?subtest=$subtest_id");
    }

    function runPreparing($subtest_id)
    {
        return $this->builder('POST', "/exam/ranker/preparing/$subtest_id");
    }

    function runWeighting($subtest_id)
    {
        return $this->builder('POST', "/exam/ranker/weighting/$subtest_id");
    }

    function runDistributing($subtest_id)
    {
        return $this->builder('POST', "/exam/ranker/distributing/$subtest_id");
    }

    function runSummarizing($subtest_id)
    {
        return $this->builder('POST', "/exam/ranker/summarizing/$subtest_id");
    }

    function runAgregating($exam_id)
    {
        return $this->builder('POST', "/exam/ranker/agregating/$exam_id");
    }

    function getRankExam($exam_id)
    {
        return $this->builder('GET', "/exam/ranker/agregate/$exam_id");
    }

    function getRankSubtest($subtest_id)
    {
        return $this->builder('GET', "/exam/ranker/subtest/$subtest_id");
    }

    function getStats($exam_id)
    {
        return $this->builder('GET', "/exam/ranker/stats/$exam_id");
    }

    function getFullRank($exam_id)
    {
        return $this->builder('GET', "/exam/ranker/agregate-full/$exam_id");
    }
}
