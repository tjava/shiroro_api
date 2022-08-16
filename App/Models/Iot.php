<?php

namespace App\Models;

use PDO;

/**
 * User model
 *
 * PHP version 7.0
 */
class Iot extends \Core\Model
{

    /**
     * Class constructor
     *
     * @param array $data  Initial property values (optional)
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Save data
     *
     * @return boolean  True if the data was saved, false otherwise
     */
    public function save($data)
    {
        $manhours_completed         = $data['manhours_completed'];
        $fatalities                 = $data['fatalities'];
        $near_misses_reported       = $data['near_misses_reported'];
        $lost_time_incident         = $data['lost_time_incident'];
        $environmental_incidents    = $data['environmental_incidents'];
        $first_aid_case             = $data['first_aid_case'];
        $emergency_drills           = $data['emergency_drills'];


        if ($data) {

            $sql = 'INSERT INTO iot (manhours_completed, fatalities, near_misses_reported, lost_time_incident, environmental_incidents, first_aid_case, emergency_drills, time)
                    VALUES (:manhours_completed, :fatalities, :near_misses_reported, :lost_time_incident, :environmental_incidents, :first_aid_case, :emergency_drills, :time)';

            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':manhours_completed', $manhours_completed, PDO::PARAM_STR);
            $stmt->bindValue(':fatalities', $fatalities, PDO::PARAM_STR);
            $stmt->bindValue(':near_misses_reported', $near_misses_reported, PDO::PARAM_STR);
            $stmt->bindValue(':lost_time_incident', $lost_time_incident, PDO::PARAM_STR);
            $stmt->bindValue(':environmental_incidents', $environmental_incidents, PDO::PARAM_STR);
            $stmt->bindValue(':first_aid_case', $first_aid_case, PDO::PARAM_STR);
            $stmt->bindValue(':emergency_drills', $emergency_drills, PDO::PARAM_STR);
            $stmt->bindValue(':time', date('m/d/Y'), PDO::PARAM_STR);

            return $stmt->execute();

            
        }

        return false;
    }

    /**
     * show all
     *
     * @param string 
     *
     * @return mixed 
     */
    public function data($id)
    {
        $sql = 'SELECT * FROM iot WHERE id = :id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetch();
    }

    /**
     * show all
     *
     * @param string 
     *
     * @return mixed 
     */
    public function updateData($data)
    {
        $manhours_completed         = $data['manhours_completed'];
        $fatalities                 = $data['fatalities'];
        $near_misses_reported       = $data['near_misses_reported'];
        $lost_time_incident         = $data['lost_time_incident'];
        $environmental_incidents    = $data['environmental_incidents'];
        $first_aid_case             = $data['first_aid_case'];
        $emergency_drills           = $data['emergency_drills'];
        $id                         = $data['id'];
        $c_manhours_completed       = $data['c_manhours_completed'];
        $c_fatalities               = $data['c_fatalities'];
        $c_near_misses_reported     = $data['c_near_misses_reported'];
        $c_lost_time_incident       = $data['c_lost_time_incident'];
        $c_environmental_incidents  = $data['c_environmental_incidents'];
        $c_first_aid_case           = $data['c_first_aid_case'];
        $c_emergency_drills         = $data['c_emergency_drills'];

        $sql = 'UPDATE iot
                SET manhours_completed = :manhours_completed,
                fatalities = :fatalities,
                near_misses_reported = :near_misses_reported,
                lost_time_incident = :lost_time_incident,
                environmental_incidents = :environmental_incidents,
                first_aid_case = :first_aid_case,
                emergency_drills = :emergency_drills
                c_manhours_completed = :c_manhours_completed,
                c_fatalities = :c_fatalities,
                c_near_misses_reported = :c_near_misses_reported,
                c_lost_time_incident = :c_lost_time_incident,
                c_environmental_incidents = :c_environmental_incidents,
                c_first_aid_case = :c_first_aid_case,
                c_emergency_drills = :c_emergency_drills
                WHERE id = :id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':manhours_completed', $manhours_completed, PDO::PARAM_STR);
        $stmt->bindValue(':fatalities', $fatalities, PDO::PARAM_STR);
        $stmt->bindValue(':near_misses_reported', $near_misses_reported, PDO::PARAM_STR);
        $stmt->bindValue(':lost_time_incident', $lost_time_incident, PDO::PARAM_STR);
        $stmt->bindValue(':environmental_incidents', $environmental_incidents, PDO::PARAM_STR);
        $stmt->bindValue(':first_aid_case', $first_aid_case, PDO::PARAM_STR);
        $stmt->bindValue(':emergency_drills', $emergency_drills, PDO::PARAM_STR);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT); 
        $stmt->bindValue(':c_manhours_completed', $c_manhours_completed, PDO::PARAM_STR);
        $stmt->bindValue(':c_fatalities', $c_fatalities, PDO::PARAM_STR);
        $stmt->bindValue(':c_near_misses_reported', $c_near_misses_reported, PDO::PARAM_STR);
        $stmt->bindValue(':c_lost_time_incident', $c_lost_time_incident, PDO::PARAM_STR);
        $stmt->bindValue(':c_environmental_incidents', $c_environmental_incidents, PDO::PARAM_STR);
        $stmt->bindValue(':c_first_aid_case', $c_first_aid_case, PDO::PARAM_STR);
        $stmt->bindValue(':c_emergency_drills', $c_emergency_drills, PDO::PARAM_STR);   

        return $stmt->execute();
    }

    /**
     * show all
     *
     * @param string 
     *
     * @return mixed 
     */
    public function updateCumulative()
    {
        $data = $this->data(1);
        
        $manhours_completed         = $data->manhours_completed;
        $fatalities                 = $data->fatalities;
        $near_misses_reported       = $data->near_misses_reported;
        $lost_time_incident         = $data->lost_time_incident;
        $environmental_incidents    = $data->environmental_incidents;
        $first_aid_case             = $data->first_aid_case;
        $emergency_drills           = $data->emergency_drills;
        $id                         = 1;
        $last_update                = date('Y-m-d');

        $sql = 'UPDATE iot
                SET c_manhours_completed = c_manhours_completed + :c_manhours_completed,
                c_fatalities = c_fatalities + :c_fatalities,
                c_near_misses_reported = c_near_misses_reported + :c_near_misses_reported,
                c_lost_time_incident = c_lost_time_incident + :c_lost_time_incident,
                c_environmental_incidents = c_environmental_incidents + :c_environmental_incidents,
                c_first_aid_case = c_first_aid_case + :c_first_aid_case,
                c_emergency_drills = c_emergency_drills + :c_emergency_drills,
                last_update = :last_update
                WHERE id = :id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':c_manhours_completed', $manhours_completed, PDO::PARAM_STR);
        $stmt->bindValue(':c_fatalities', $fatalities, PDO::PARAM_STR);
        $stmt->bindValue(':c_near_misses_reported', $near_misses_reported, PDO::PARAM_STR);
        $stmt->bindValue(':c_lost_time_incident', $lost_time_incident, PDO::PARAM_STR);
        $stmt->bindValue(':c_environmental_incidents', $environmental_incidents, PDO::PARAM_STR);
        $stmt->bindValue(':c_first_aid_case', $first_aid_case, PDO::PARAM_STR);
        $stmt->bindValue(':c_emergency_drills', $emergency_drills, PDO::PARAM_STR);
        $stmt->bindValue(':last_update', $last_update, PDO::PARAM_STR);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);   

        return $stmt->execute();
    }

    /**
     * Delete 
     *
     * @param string 
     *
     * @return mixed 
     */
    public function delete($id)
    {

        $sql = 'DELETE FROM iot WHERE id = :id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        return $stmt->execute();
    }

    /**
     * Delete 
     *
     * @param string 
     *
     * @return mixed 
     */
    public function deleteAll()
    {

        $sql = 'DELETE FROM iot';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        return $stmt->execute();
    }


}