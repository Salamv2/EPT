<?php

class Application_Service_Participants {
	
	public function getUsersParticipants($userSystemId = null){
		if($userSystemId == null){
			$authNameSpace = new Zend_Session_Namespace('Zend_Auth');
			$userSystemId = $authNameSpace->UserSystemID;
		}
		
		$participantDb = new Application_Model_DbTable_Participants();
		return $participantDb->getParticipantsByUserSystemId($userSystemId);
		
	}
	
	public function getParticipantDetails($partSysId){
		
		$participantDb = new Application_Model_DbTable_Participants();
		return $participantDb->getParticipant($partSysId);
		
	}
	
	public function addParticipant($params){
		$participantDb = new Application_Model_DbTable_Participants();
		return $participantDb->addParticipant($params);
    }
	public function updateParticipant($params){
		$participantDb = new Application_Model_DbTable_Participants();
		return $participantDb->updateParticipant($params);
	}
	public function getAllParticipants($params){
		$participantDb = new Application_Model_DbTable_Participants();
		return $participantDb->getAllParticipants($params);
	}
	
	public function getAllEnrollments($params){
		$enrollments = new Application_Model_DbTable_Enrollments();
		return $enrollments->getAllEnrollments($params);
	}
	public function getEnrollmentDetails($pid,$sid){
	    $db = Zend_Db_Table_Abstract::getDefaultAdapter();
	    $shipmentTable = 'shipment_'.strtolower($sid);
	    $participantIdColumn =  (($sid == 'dts') ? 's.ParticipantID' : 's.participant_id');
	    $sql = $db->select()->from(array('p'=>'participant'))
				->joinLeft(array('s'=>$shipmentTable),'p.ParticipantSystemID='.$participantIdColumn)
				->where("p.ParticipantSystemID=".$pid);
	    return $db->fetchAll($sql);
	}

}