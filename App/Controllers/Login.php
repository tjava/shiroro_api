<?php

namespace App\Controllers;

use \App\Models\User;
use \App\Auth;
use \App\Jwt;

/**
 * Login controller
 *
 * PHP version 7.0
 */
class Login extends \Core\Controller
{

    /**
     * Log in a user
     *
     * @return void
     */
    public function createAction()
    {
        if($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode($this->response(405, 'Method Not Allowed'));
            exit;
        }

        $input = json_decode(file_get_contents('php://input'), true);

        $user = User::authenticate($input['email'], $input['password']);
        
        $iss = 'localhost';
        $iat = time();
        $exp = $iat + 15780000;
        $user_data = [
            $user->id,
            $user->name,
            $user->email
        ];

        $payload = json_encode([
            'iss' => $iss,
            'iat' => $iat,
            'exp' => $exp,
            'user' => $user_data
        ]);

        $jwt = Jwt::encode($payload);

        if ($user) {

            echo json_encode($this->response(200, 'Login Successful', 'data', ['access token' => $jwt]));
            exit;

        } else {

            echo json_encode($this->response(401, 'Authentication Failed', 'errors', ['Incorrect Cridential']));
            exit;
        }
    }

    /**
     * Log out a user
     *
     * @return void
     */
    public function destroyAction()
    {
        Auth::logout();

        $this->redirect('/login/show-logout-message');
    }
}