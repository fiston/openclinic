<?php
/**
 * This file is part of OpenClinic
 *
 * Copyright (c) 2002-2004 jact
 * Licensed under the GNU GPL. For full terms see the file LICENSE.
 *
 * $Id: DelPatient_Query.php,v 1.1 2004/01/29 14:24:54 jact Exp $
 */

/**
 * DelPatient_Query.php
 ********************************************************************
 * Contains the class DelPatient_Query
 ********************************************************************
 * Author: jact <jachavar@terra.es>
 * Last modified: 29/01/04 15:24
 */

require_once("../classes/Query.php");

/**
 * DelPatient_Query data access component for deleted patients
 ********************************************************************
 * @author jact <jachavar@terra.es>
 * @version 0.2
 * @access public
 ********************************************************************
 * Methods:
 *  bool insert(Patient $patient, History $historyP, History $historyF, int $idUser, string $login)
 */
class DelPatient_Query extends Query
{
  /**
   * bool insert(Patient $patient, History $historyP, History $historyF, int $idUser, string $login)
   ********************************************************************
   * Inserts a new deleted patient into the database.
   ********************************************************************
   * @param Patient $patient patient to insert
   * @param History $historyP patient's personal antecedents to insert
   * @param History $historyF patient's family antecedents to insert
   * @param int $idUser key of user that makes deletion
   * @param string $login login session of user that makes deletion
   * @return boolean returns false, if error occurs
   * @access public
   */
  function insert($patient, $historyP, $historyF, $idUser, $login)
  {
    $sql = "INSERT INTO deleted_patient_tbl ";
    $sql .= "(id_patient, nif, first_name, surname1, surname2, address, phone_contact, ";
    $sql .= "sex, race, birth_date, birth_place, decease_date, nts, nss, ";
    $sql .= "family_situation, labour_situation, education, insurance_company, ";
    $sql .= "collegiate_number, birth_growth, growth_sexuality, feed, habits, ";
    $sql .= "peristaltic_conditions, psychological, children_complaint, venereal_disease, ";
    $sql .= "accident_surgical_operation, medicinal_intolerance, mental_illness, ";
    $sql .= "parents_status_health, brothers_status_health, spouse_childs_status_health, ";
    $sql .= "family_illness, create_date, id_user, login) VALUES (";
    $sql .= $patient->getIdPatient() . ", ";
    $sql .= ($patient->getNIF() == "") ? "NULL, " : "'" . urlencode($patient->getNIF()) . "', ";
    $sql .= "'" . urlencode($patient->getFirstName()) . "', ";
    $sql .= "'" . urlencode($patient->getSurname1()) . "', ";
    $sql .= "'" . urlencode($patient->getSurname2()) . "', ";
    $sql .= ($patient->getAddress() =="") ? "NULL, " : "'" . urlencode($patient->getAddress()) . "', ";
    $sql .= ($patient->getPhone() == "") ? "NULL, " : "'" . urlencode($patient->getPhone()) . "', ";
    $sql .= "'" . $patient->getSex() . "', ";
    $sql .= ($patient->getRace() == "") ? "NULL, " : "'" . urlencode($patient->getRace()) . "', ";
    $sql .= "'" . $patient->getBirthDate() . "', ";
    $sql .= ($patient->getBirthPlace() == "") ? "NULL, " : "'" . urlencode($patient->getBirthPlace()) . "', ";
    $sql .= "'" . $patient->getDeceaseDate() . "', ";
    $sql .= ($patient->getNTS() == "") ? "NULL, " : "'" . urlencode($patient->getNTS()) . "', ";
    $sql .= ($patient->getNSS() == "") ? "NULL, " : "'" . urlencode($patient->getNSS()) . "', ";
    $sql .= ($patient->getFamilySituation() == "") ? "NULL, " : "'" . urlencode($patient->getFamilySituation()) . "', ";
    $sql .= ($patient->getLabourSituation() == "") ? "NULL, " : "'" . urlencode($patient->getLabourSituation()) . "', ";
    $sql .= ($patient->getEducation() == "") ? "NULL, " : "'" . urlencode($patient->getEducation()) . "', ";
    $sql .= ($patient->getInsuranceCompany() == "") ? "NULL, " : "'" . urlencode($patient->getInsuranceCompany()) . "', ";
    $sql .= ($patient->getCollegiateNumber() == "") ? "NULL, " : "'" . urlencode($patient->getCollegiateNumber()) . "', ";

    $sql .= (($historyP->getBirthGrowth() == "") ? "NULL, " : "'" . urlencode($historyP->getBirthGrowth()) . "', ");
    $sql .= (($historyP->getGrowthSexuality() == "") ? "NULL, " : "'" . urlencode($historyP->getGrowthSexuality()) . "', ");
    $sql .= (($historyP->getFeed() == "") ? "NULL, " : "'" . urlencode($historyP->getFeed()) . "', ");
    $sql .= (($historyP->getHabits() == "") ? "NULL, " : "'" . urlencode($historyP->getHabits()) . "', ");
    $sql .= (($historyP->getPeristalticConditions() == "") ? "NULL, " : "'" . urlencode($historyP->getPeristalticConditions()) . "', ");
    $sql .= (($historyP->getPsychological() == "") ? "NULL, " : "'" . urlencode($historyP->getPsychological()) . "', ");
    $sql .= (($historyP->getChildrenComplaint() == "") ? "NULL, " : "'" . urlencode($historyP->getChildrenComplaint()) . "', ");
    $sql .= (($historyP->getVenerealDisease() == "") ? "NULL, " : "'" . urlencode($historyP->getVenerealDisease()) . "', ");
    $sql .= (($historyP->getAccidentSurgicalOperation() == "") ? "NULL, " : "'" . urlencode($historyP->getAccidentSurgicalOperation()) . "', ");
    $sql .= (($historyP->getMedicinalIntolerance() == "") ? "NULL, " : "'" . urlencode($historyP->getMedicinalIntolerance()) . "', ");
    $sql .= (($historyP->getMentalIllness() == "") ? "NULL, " : "'" . urlencode($historyP->getMentalIllness()) . "', ");

    $sql .= (($historyF->getParentsStatusHealth() == "") ? "NULL, " : "'" . urlencode($historyF->getParentsStatusHealth()) . "', ");
    $sql .= (($historyF->getBrothersStatusHealth() == "") ? "NULL, " : "'" . urlencode($historyF->getBrothersStatusHealth()) . "', ");
    $sql .= (($historyF->getSpouseChildsStatusHealth() == "") ? "NULL, " : "'" . urlencode($historyF->getSpouseChildsStatusHealth()) . "', ");
    $sql .= (($historyF->getFamilyIllness() == "") ? "NULL, " : "'" . urlencode($historyF->getFamilyIllness()) . "', ");

    $sql .= "NOW(), ";
    $sql .= intval($idUser) . ", ";
    $sql .= "'" . urlencode($login) . "');";

    $result = $this->exec($sql);
    if ($result == false)
    {
      $this->_error = "Error inserting new deleted patient information.";
    }

    return $result;
  }
} // end class
?>