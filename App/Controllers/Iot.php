<?php

namespace App\Controllers;

use \App\Auth;
use \App\Dbgeter;

/**
 * Home controller
 *
 * PHP version 7.0
 */
class Iot extends \Core\Controller
{
    /**
     * Before filter - called before each action method
     *
     * @return void
     */
    protected function before()
    {
        parent::before();

        $this->user = Auth::getUser();

        $this->iot = Dbgeter::Iot();
    }

    /**
     * Get to database
     *
     * @return void
     */
    public function getAction()
    {

        if($_SERVER['REQUEST_METHOD'] !== 'GET') {
            echo json_encode($this->response(405, 'Method Not Allowed'));
            exit;
        }

        $data = $this->iot->data(1);

        if ($data) {

            echo json_encode($this->response(200, 'Successful', 'data', $data));
            exit;

        } else {

            echo json_encode($this->response(404, 'Data Not Found'));
            exit;

        }

    }

    /**
     * Get to database
     *
     * @return void
     */
    public function dataAction()
    {

        if($_SERVER['REQUEST_METHOD'] !== 'GET') {
            echo json_encode($this->response(405, 'Method Not Allowed'));
            exit;
        }

        $data = $this->iot->data(1);

        if ($data) {

            echo $data->manhours_completed.','.$data->fatalities.','.$data->near_misses_reported.','.$data->lost_time_incident.','.$data->environmental_incidents.','.$data->first_aid_case.','.$data->emergency_drills;
            exit;

        } else {

            echo 'Data Not Found';
            exit;

        }

    }

    /**
     * Incoming save to database
     *
     * @return void
     */
    public function createAction()
    {
        if (!is_object($this->user)) {
            echo json_encode($this->response(401, 'Permission Denied'));
            exit;
        }

        if($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode($this->response(405, 'Method Not Allowed'));
            exit;
        }

        $input = json_decode(file_get_contents('php://input'), true);

        $manhours_completed         = $input['manhours_completed'];
        $fatalities                 = $input['fatalities'];
        $near_misses_reported       = $input['near_misses_reported'];
        $lost_time_incident         = $input['lost_time_incident'];
        $environmental_incidents    = $input['environmental_incidents'];
        $first_aid_case             = $input['first_aid_case'];
        $emergency_drills           = $input['emergency_drills'];

        $data = [ 
            'manhours_completed'        => $manhours_completed,
            'fatalities'                => $fatalities,
            'near_misses_reported'      => $near_misses_reported,
            'lost_time_incident'        => $lost_time_incident,
            'environmental_incidents'   => $environmental_incidents,
            'first_aid_case'            => $first_aid_case,
            'emergency_drills'          => $emergency_drills
        ];

        if ($this->iot->save($data)) {

            echo json_encode($this->response(201, 'Data Created'));
            exit;

        } else {

            echo json_encode($this->response(400, 'Oops Something Went Wrong'));
            exit;

        }

    }

    /**
     * Get to database
     *
     * @return void
     */
    public function updateAction()
    {
        if (!is_object($this->user)) {
            echo json_encode($this->response(401, 'Permission Denied', 'error', $this->user));
            exit;
        }
        
        if($_SERVER['REQUEST_METHOD'] !== 'PUT') {
            echo json_encode($this->response(405, 'Method Not Allowed'));
            exit;
        }

        $input = json_decode(file_get_contents('php://input'), true);

        $get = $this->iot->data($this->route_params['id']);
        
        if ($get) {

            $data = [ 
                'manhours_completed'        => $input['manhours_completed'] ?? $get->manhours_completed,
                'fatalities'                => $input['fatalities'] ?? $get->fatalities,
                'near_misses_reported'      => $input['near_misses_reported'] ?? $get->near_misses_reported,
                'lost_time_incident'        => $input['lost_time_incident'] ?? $get->lost_time_incident,
                'environmental_incidents'   => $input['environmental_incidents'] ?? $get->environmental_incidents,
                'first_aid_case'            => $input['first_aid_case'] ?? $get->first_aid_case,
                'emergency_drills'          => $input['emergency_drills'] ?? $get->emergency_drills,
                'id'                        => $this->route_params['id']
            ];
    
            $this->iot->updateData($data);
            
            echo json_encode($this->response(200, 'Data Updated', 'data', $data));
            exit;

        } else {

            echo json_encode($this->response(404, 'Data Not Found'));
            exit;

        }

    }
}