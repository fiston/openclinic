<?php
/**
 * This file is part of OpenClinic
 *
 * Copyright (c) 2002-2004 jact
 * Licensed under the GNU GPL. For full terms see the file LICENSE.
 *
 * $Id: staff_new.php,v 1.2 2004/04/23 20:36:51 jact Exp $
 */

/**
 * staff_new.php
 ********************************************************************
 * Staff member addition process
 ********************************************************************
 * Author: jact <jachavar@terra.es>
 */

  ////////////////////////////////////////////////////////////////////
  // Controlling vars
  ////////////////////////////////////////////////////////////////////
  $tab = "admin";
  $nav = "staff";
  //$restrictInDemo = true;
  $errorLocation = "../admin/staff_new_form.php?type=" . $_GET['type'];

  ////////////////////////////////////////////////////////////////////
  // Checking for post vars. Go back to form if none found.
  ////////////////////////////////////////////////////////////////////
  if (count($_POST) == 0)
  {
    header("Location: " . $errorLocation);
    exit();
  }

  require_once("../shared/read_settings.php");
  require_once("../shared/login_check.php");
  require_once("../classes/Staff_Query.php");
  require_once("../lib/error_lib.php");

  ////////////////////////////////////////////////////////////////////
  // Validate data
  ////////////////////////////////////////////////////////////////////
  $staff = new Staff();

  require_once("../admin/staff_validate_post.php");

  ////////////////////////////////////////////////////////////////////
  // Insert new staff member
  ////////////////////////////////////////////////////////////////////
  $staffQ = new Staff_Query();
  $staffQ->connect();
  if ($staffQ->errorOccurred())
  {
    showQueryError($staffQ);
  }

  if ($staffQ->existLogin($staff->getLogin()))
  {
    $loginUsed = true;
  }
  else
  {
    if ( !$staffQ->insert($staff) )
    {
      $staffQ->close();
      showQueryError($staffQ);
    }
  }
  $staffQ->close();
  unset($staffQ);

  ////////////////////////////////////////////////////////////////////
  // Destroy form values and errors
  ////////////////////////////////////////////////////////////////////
  unset($_SESSION["postVars"]);
  unset($_SESSION["pageErrors"]);

  ////////////////////////////////////////////////////////////////////
  // Show success page
  ////////////////////////////////////////////////////////////////////
  $title = _("Staff Members");
  require_once("../shared/header.php");

  $returnLocation = "../admin/staff_list.php";

  ////////////////////////////////////////////////////////////////////
  // Navigation links
  ////////////////////////////////////////////////////////////////////
  require_once("../shared/navigation_links.php");
  $links = array(
    _("Admin") => "../admin/index.php",
    _("Staff Members") => $returnLocation,
    $title => ""
  );
  showNavLinks($links, "staff.png");
  unset($links);

  echo '<p>';
  echo (isset($loginUsed) && $loginUsed)
    ? sprintf(_("Login, %s, already exists. The changes have no effect."), $staff->getLogin())
    : sprintf(_("Staff member, %s %s %s, has been added."), $staff->getFirstName(), $staff->getSurname1(), $staff->getSurname2());
  echo "</p>\n";

  unset($staff);

  echo '<p><a href="' . $returnLocation . '">' . _("Return to staff list") . "</a></p>\n";

  require_once("../shared/footer.php");
?>