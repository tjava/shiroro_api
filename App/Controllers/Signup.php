<?php

namespace App\Controllers;

use \App\Models\User;

/**
 * Signup controller
 *
 * PHP version 7.0
 */
class Signup extends \Core\Controller
{

    /**
     * Sign up a new user
     *
     * @return void
     */
    public function createAction()
    {
        if($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            echo json_encode($this->response(200, 'Preflight Accepted'));
            exit;
        }
        
        if($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode($this->response(405, 'Method Not Allowed'));
            exit;
        }

        $input = json_decode(file_get_contents('php://input'), true);

        $user = new User($input);

        if ($user->save()) {

            echo json_encode($this->response(201, 'Account Created'));
            exit;

        } else {

            echo json_encode($this->response(400, 'Validation Error', 'errors', $user->errors));
            exit;

        }
    }

}