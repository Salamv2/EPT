<?php
include_once 'CronInit.php';

$conf = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', APPLICATION_ENV);

try {
    $db = Zend_Db::factory($conf->resources->db);
    Zend_Db_Table::setDefaultAdapter($db);
    
        date_default_timezone_set('GMT');
        $filename = UPLOAD_PATH . DIRECTORY_SEPARATOR . "pt-reminder.csv";

        if (!file_exists($filename) || !is_readable($filename))
            return FALSE;    
        $data = array();
        ini_set('auto_detect_line_endings', TRUE);
        if (($handle = fopen($filename, 'r')) !== false) {
            while (($line = fgetcsv($handle)) !== false) {
                $data[] = ($line);
            }
            fclose($handle);
        }
        ini_set('auto_detect_line_endings', FALSE);
        unset($data[0]);
        
        $commonService = new Application_Service_Common();
        foreach ($data as $participant) {

            


            if((isset($participant[7]) && trim($participant[7])!= '')){

                

                $to = $participant[7];
                $cc = $participant[8];
                $bcc = 'pt@vlsmartconnect.com';
                $subject = '';
                $message = '';
                $fromMail = '';
                $fromName = '';
                //Subject
                //$subject.= "Notice for CDC 2017-2nd PT shipment for EID and VL - ". $participant[0]." | ".$participant[1] ;
                $subject.= "[IMPORTANT] REMINDER - 2018 2nd CDC EID and VL PT | Lab ID : ". $participant[0] . " | ". $participant[1];
                //Message
                $message.= '<table border="0" cellspacing="0" cellpadding="0" style="width:100%;background-color:#FFF;">';
                    $message.= '<tr><td align="center">';
                      $message.= '<table cellpadding="3" style="width:98%;font-family:Helvetica,Arial,sans-serif;margin:30px 0px 30px 0px;padding:2% 0% 0% 2%;background-color:#ffffff;text-align:justify;">';
                      
                        $message.= '<tr><td colspan="2">Dear PT Participants,</td></tr>';

                        

                        $message.= '<tr><td colspan="2">This is a friendly reminder that the results due date is <strong>19 Oct 2018</strong> for CDC 2018 2nd shipment for EID and VL PT panels. Late results will not be accepted for evaluation.</td></tr>';
                        $message.= '<tr><td colspan="2">Our record indicates that we have not received results submission from your laboratory.</td></tr>';
                        $message.= '<tr><td colspan="2">Please submit your results via online ePT system at https://ept.vlsmartconnect.com/auth/login using your username and password.  If you do not have a username and password, please send an email request to gappt@cdc.gov and pt@vlsmartconnect.com.</td></tr>';
                        
                        $message.= '<tr><td width="12%">If you are unable to submit your results, please provide your "reason for no results submission" via email to gappt@cdc.gov. Please disregard this email if you have submitted your results already. Laboratory that does not submit results AND do not provide a "reason for no results submission" for their 2018  2nd PT panels will be excluded from the CDC future PT shipments.</td></tr>';
                        
                        $message.= '<tr><td colspan="2"></td></tr>';
                        
                        $message.= '<tr><td colspan="2">Please contact us at gappt@cdc.gov if you have not received your PT shipment by 20 September 2018.</td></tr>';

                        $message.= '<tr><td colspan="2">Sincerely,</td></tr>';
                        $message.= '<tr><td colspan="2">Online PT Team</td></tr>';
                        $message.= '<tr><td colspan="2"></td></tr>';
                        //$message.= '<tr><td colspan="2"><small>This is a system generated mail. Please do not reply to this email</small></td></tr>';
                        
                        $message.= '<tr><td colspan="2"></td></tr>';
                        
                      $message.= '</table>';
                    $message.= '</td></tr>';
                $message.= '</table>';
                $commonService->insertTempMail($to, $cc,$bcc, $subject, $message, $fromMail = null, $fromName = null);
            }
        }
} catch (Exception $e) {
    error_log($e->getMessage());
    error_log($e->getTraceAsString());
    error_log('whoops! Something went wrong in cron/SendParticipantLoginDetails.php');
}
