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

            if(date('Y-m-01') == date('Y-m-d') && $data->last_update != date('Y-m-d')) {
                $this->iot->updateCumulative();
            }
            
            $data->time = date("Y-m-d H:i:s");
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
            
            $time = date("Y-m-d H:i:s");
            $day = $time[8].$time[9];
            $month = $time[5].$time[6];
            $year = $time[2].$time[3];
            $hour = $time[11].$time[12];
            $minute = $time[14].$time[15];

            echo 'AckOk'.','
            .str_pad($data->manhours_completed, 2, '0', STR_PAD_LEFT).','
            .str_pad($data->fatalities, 2, '0', STR_PAD_LEFT).','
            .str_pad($data->near_misses_reported, 2, '0', STR_PAD_LEFT).','
            .str_pad($data->lost_time_incident, 2, '0', STR_PAD_LEFT).','
            .str_pad($data->environmental_incidents, 2, '0', STR_PAD_LEFT).','
            .str_pad($data->first_aid_case, 2, '0', STR_PAD_LEFT).','
            .str_pad($data->emergency_drills, 2, '0', STR_PAD_LEFT).','
            .str_pad($data->c_manhours_completed, 4, '0', STR_PAD_LEFT).','
            .str_pad($data->c_fatalities, 4, '0', STR_PAD_LEFT).','
            .str_pad($data->c_near_misses_reported, 4, '0', STR_PAD_LEFT).','
            .str_pad($data->c_lost_time_incident, 4, '0', STR_PAD_LEFT).','
            .str_pad($data->c_environmental_incidents, 4, '0', STR_PAD_LEFT).','
            .str_pad($data->c_first_aid_case, 4, '0', STR_PAD_LEFT).','
            .str_pad($data->c_emergency_drills, 4, '0', STR_PAD_LEFT).','
            .$day.','
            .$month.','
            .$year.','
            .$hour.','
            .$minute;
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
        
        if($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            echo json_encode($this->response(200, 'Preflight Accepted'));
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
        $c_manhours_completed       = $input['c_manhours_completed'];
        $c_fatalities               = $input['c_fatalities'];
        $c_near_misses_reported     = $input['c_near_misses_reported'];
        $c_lost_time_incident       = $input['c_lost_time_incident'];
        $c_environmental_incidents  = $input['c_environmental_incidents'];
        $c_first_aid_case           = $input['c_first_aid_case'];
        $c_emergency_drills         = $input['c_emergency_drills'];

        $data = [ 
            'manhours_completed'        => $manhours_completed,
            'fatalities'                => $fatalities,
            'near_misses_reported'      => $near_misses_reported,
            'lost_time_incident'        => $lost_time_incident,
            'environmental_incidents'   => $environmental_incidents,
            'first_aid_case'            => $first_aid_case,
            'emergency_drills'          => $emergency_drills,
            'c_manhours_completed'      => $c_manhours_completed,
            'c_fatalities'              => $c_fatalities,
            'c_near_misses_reported'    => $c_near_misses_reported,
            'c_lost_time_incident'      => $c_lost_time_incident,
            'c_environmental_incidents' => $c_environmental_incidents,
            'c_first_aid_case'          => $c_first_aid_case,
            'c_emergency_drills'        => $c_emergency_drills
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
        // if (!is_object($this->user)) {
        //     echo json_encode($this->response(401, 'Permission Denied', 'error', $this->user));
        //     exit;
        // }
        
        if($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            echo json_encode($this->response(200, 'Preflight Accepted'));
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
                'manhours_completed'        => empty($input['manhours_completed']) ? $get->manhours_completed : $input['manhours_completed'],
                'fatalities'                => empty($input['fatalities'] )? $get->fatalities : $input['fatalities'],
                'near_misses_reported'      => empty($input['near_misses_reported']) ? $get->near_misses_reported : $input['near_misses_reported'],
                'lost_time_incident'        => empty($input['lost_time_incident']) ? $get->lost_time_incident : $input['lost_time_incident'],
                'environmental_incidents'   => empty($input['environmental_incidents']) ? $get->environmental_incidents : $input['environmental_incidents'],
                'first_aid_case'            => empty($input['first_aid_case']) ? $get->first_aid_case : $input['first_aid_case'],
                'emergency_drills'          => empty($input['emergency_drills']) ? $get->emergency_drills : $input['emergency_drills'],
                'id'                        => $this->route_params['id'],
                'c_manhours_completed'      => empty($input['c_manhours_completed']) ? $get->manhours_completed : $input['c_manhours_completed'],
                'c_fatalities'              => empty($input['c_fatalities'] )? $get->fatalities : $input['c_fatalities'],
                'c_near_misses_reported'    => empty($input['c_near_misses_reported']) ? $get->near_misses_reported : $input['c_near_misses_reported'],
                'c_lost_time_incident'      => empty($input['c_lost_time_incident']) ? $get->lost_time_incident : $input['c_lost_time_incident'],
                'c_environmental_incidents' => empty($input['c_environmental_incidents']) ? $get->environmental_incidents : $input['c_environmental_incidents'],
                'c_first_aid_case'          => empty($input['c_first_aid_case']) ? $get->first_aid_case : $input['c_first_aid_case'],
                'c_emergency_drills'        => empty($input['c_emergency_drills']) ? $get->emergency_drills : $input['c_emergency_drills']
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