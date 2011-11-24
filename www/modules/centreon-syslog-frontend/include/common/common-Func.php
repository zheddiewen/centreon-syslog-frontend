<?php
/*
 * Copyright 2005-2011 MERETHIS
 * Centreon is developped by : Julien Mathis and Romain Le Merlus under
 * GPL Licence 2.0.
 * 
 * This program is free software; you can redistribute it and/or modify it under 
 * the terms of the GNU General Public License as published by the Free Software 
 * Foundation ; either version 2 of the License.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A 
 * PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License along with 
 * this program; if not, see <http://www.gnu.org/licenses>.
 * 
 * Linking this program statically or dynamically with other modules is making a 
 * combined work based on this program. Thus, the terms and conditions of the GNU 
 * General Public License cover the whole combination.
 * 
 * As a special exception, the copyright holders of this program give MERETHIS 
 * permission to link this program with independent modules to produce an executable, 
 * regardless of the license terms of these independent modules, and to copy and 
 * distribute the resulting executable under terms of MERETHIS choice, provided that 
 * MERETHIS also meet, for each linked independent module, the terms  and conditions 
 * of the license of that module. An independent module is a module which is not 
 * derived from this program. If you modify this program, you may extend this 
 * exception to your version of the program, but you are not obliged to do so. If you
 * do not wish to do so, delete this exception statement from your version.
 * 
 * For more information : contact@centreon.com
 * 
 * Project name : Centreon Syslog
 * Module name: Centreon-Syslog-Frontend
 * 
 * SVN : $URL$
 * SVN : $Id$
 * 
 */
	include ("@CENTREON_ETC@centreon.conf.php");
	
	/*
	 * Make PEAR DB object to connect to MySQL DB
	 */
	require_once $centreon_path . "www/modules/centreon-syslog-frontend/class/syslogDB.class.php";
	$pearDB = new SyslogDB("centreon");

	/**
	 * 
	 * Get syslog collectors configuration
	 * @param int $collector_id
	 * @return array
	 */
	function getSyslogOption($collector_id) {
		global $pearDB;
		
		$cfg_syslog = array();

		$DBRESULT =& $pearDB->query("SELECT * FROM `mod_syslog_collector` WHERE `collector_id` = '".$collector_id."'");
		/*
		 * Set base value
		 */
		$cfg_syslog = array_map("myDecode", $DBRESULT->fetchRow());
		$DBRESULT->free();
		return $cfg_syslog;
	}

	/**
	*
	* Get list of Hosts
	* @return array
	*/
	function getFilterHosts() {
		global $pearSyslogDB, $cfg_syslog;

		$query = "SELECT distinct(value) as host FROM " . $cfg_syslog["db_table_cache"] . " WHERE type= \"HOST\" ORDER BY host ASC";
			
		$res =& $pearSyslogDB->query($query);
		if (PEAR::isError($pearSyslogDB)) {
			print "Mysql Error : ". $pearSyslogDB->getMessage()."\n";
		}
		# Set base value
		$FilterHosts  =  array("" => "");
		
		while ($host =& $res->fetchRow())
			$FilterHosts[$host['host']] = $host['host']; 
			
		$FilterHosts = array_map("myDecode",$FilterHosts);
			
		return $FilterHosts;
	}

	/**
	 * 
	 * Get list of Hosts from merge table
	 * @param PEAR::DB $pearSyslogDB
	 * @param array $cfg_syslog
	 * @return array
	 */
	function getFilterHostsMerge($pearSyslogDB, $cfg_syslog) {
		$query = "SELECT distinct(value) as host FROM " . $cfg_syslog["db_table_cache_merge"] . " WHERE type= \"HOST\" ORDER BY host ASC";
		
		$res =& $pearSyslogDB->query($query);
		if (PEAR::isError($pearSyslogDB)) {
			print "Mysql Error : ". $pearSyslogDB->getMessage()."\n";
		}
		# Set base value
		$FilterHosts  =  array("" => "");
		
		while ($host =& $res->fetchRow())
			$FilterHosts[$host['host']] = $host['host']; 
			
		$FilterHosts = array_map("myDecode",$FilterHosts);
			
		return $FilterHosts;
	}

	/**
	*
	* Get list of Facilities
	* @return array
	*/
	function getFilterFacilities() {
		global $pearSyslogDB, $cfg_syslog;

		$query = "SELECT distinct(value) as facility FROM " . $cfg_syslog["db_table_cache"] . " WHERE type= \"FACILITY\"  ORDER BY facility ASC";

		$res =& $pearSyslogDB->query($query);
		if (PEAR::isError($pearSyslogDB)) {
			print "Mysql Error : ". $pearSyslogDB->getMessage()."\n";
		}
		# Set base value
		$FilterFacilities  =  array("" => "");
		
		while ($facility =& $res->fetchRow())
			$FilterFacilities[$facility['facility']] = $facility['facility']; 
			
		$FilterFacilities = array_map("myDecode",$FilterFacilities );
		return $FilterFacilities;
	}

	/**
	*
	* Get list of Facilities from merge table
	* @return array
	*/
	function getFilterFacilitiesMerge() {
		global $pearSyslogDB, $cfg_syslog;

		$query = "SELECT distinct(value) as facility FROM " . $cfg_syslog["db_table_cache_merge"] . " WHERE type= \"FACILITY\"  ORDER BY facility ASC";

		$res =& $pearSyslogDB->query($query);
		if (PEAR::isError($pearSyslogDB)) {
			print "Mysql Error : ". $pearSyslogDB->getMessage()."\n";
		}
		# Set base value
		$FilterFacilities  =  array("" => "");
		
		while ($facility =& $res->fetchRow())
			$FilterFacilities[$facility['facility']] = $facility['facility']; 
			
		$FilterFacilities = array_map("myDecode",$FilterFacilities );
		return $FilterFacilities;
	}

	/**
	*
	* Get list of Priotirites
	* @return array
	*/
	function getFilterPriorities() {
		global $pearSyslogDB, $cfg_syslog;

		$query = "SELECT distinct(value) as priority FROM " . $cfg_syslog["db_table_cache"] . " WHERE type= \"PRIORITY\"  ORDER BY priority ASC";

		$res =& $pearSyslogDB->query($query);
		if (PEAR::isError($pearSyslogDB)) {
			print "Mysql Error : ". $pearSyslogDB->getMessage()."\n";
		}
		# Set base value
		$FilterPriorities  =  array("" => "");
		
		while ($priority =& $res->fetchRow())
			$FilterPriorities[$priority['priority']] = $priority['priority']; 
			
		$FilterPriorities = array_map("myDecode",$FilterPriorities );
		return $FilterPriorities;
	}

	/**
	*
	* Get list of Priotirites from merge table
	* @return array
	*/
	function getFilterPrioritiesMerge() {
		global $pearSyslogDB, $cfg_syslog;

		$query = "SELECT distinct(value) as priority FROM " . $cfg_syslog["db_table_cache_merge"] . " WHERE type= \"PRIORITY\"  ORDER BY priority ASC";

		$res =& $pearSyslogDB->query($query);
		if (PEAR::isError($pearSyslogDB)) {
			print "Mysql Error : ". $pearSyslogDB->getMessage()."\n";
		}
		# Set base value
		$FilterPriorities  =  array("" => "");
		
		while ($priority =& $res->fetchRow())
			$FilterPriorities[$priority['priority']] = $priority['priority']; 
			
		$FilterPriorities = array_map("myDecode",$FilterPriorities );
		return $FilterPriorities;
	}

	/**
	*
	* Get list of Levels
	* @return array
	*/
	function getFilterLevels() {
		global $pearSyslogDB, $cfg_syslog;

		$query = "SELECT distinct(value) as level FROM " . $cfg_syslog["db_table_cache"] . " WHERE type= \"LEVEL\"  ORDER BY level ASC";

		$res =& $pearSyslogDB->query($query);
		if (PEAR::isError($pearSyslogDB)) {
			print "Mysql Error : ". $pearSyslogDB->getMessage()."\n";
		}
		# Set base value
		$FilterLevels  = array("" => "");
		
		while ($level =& $res->fetchRow())
			$FilterLevels[$level['level']] = $level['level']; 
			
		$FilterLevels = array_map("myDecode",$FilterLevels );
		return $FilterLevels;
	}

	/**
	*
	* Get list of Levels from merge table
	* @return array
	*/
	function getFilterLevelsMerge() {
		global $pearSyslogDB, $cfg_syslog;

		$query = "SELECT distinct(value) as level FROM " . $cfg_syslog["db_table_cache_merge"] . " WHERE type= \"LEVEL\"  ORDER BY level ASC";

		$res =& $pearSyslogDB->query($query);
		if (PEAR::isError($pearSyslogDB)) {
			print "Mysql Error : ". $pearSyslogDB->getMessage()."\n";
		}
		# Set base value
		$FilterLevels  = array("" => "");
		
		while ($level =& $res->fetchRow())
			$FilterLevels[$level['level']] = $level['level']; 
			
		$FilterLevels = array_map("myDecode",$FilterLevels );
		return $FilterLevels;
	}

	/**
	 * 
	 * Get list of Programs
	 * @return array
	 */
	function getFilterPrograms() {
		global $pearSyslogDB, $cfg_syslog;

		$query = "SELECT distinct(value) as program FROM " . $cfg_syslog["db_table_cache"] . " WHERE type= \"PROGRAM\"  ORDER BY program ASC";

		$res =& $pearSyslogDB->query($query);
		
		if (PEAR::isError($pearSyslogDB)) {
			print "Mysql Error : ". $pearSyslogDB->getMessage()."\n";
		}
		# Set base value
		$FilterPrograms  = array("" => "");
		
		while ($program =&$res->fetchRow())
				$FilterPrograms[$program['program']] = $program['program'] ; 
		
		$FilterPrograms  = array_map("myDecode",$FilterPrograms );
		return $FilterPrograms ;
	}

	/**
	 * 
	 * Get list of available programs from merge table
	 * @param PEAR::DB $pearSyslogDB
	 * @param array $cfg_syslog
	 * @return array
	 */
	function getFilterProgramsMerge($pearSyslogDB, $cfg_syslog) {

		$query = "SELECT distinct(value) as program FROM " . $cfg_syslog["db_table_cache_merge"] . " WHERE type= \"PROGRAM\"  ORDER BY program ASC";

		$res =& $pearSyslogDB->query($query);
		
		if (PEAR::isError($pearSyslogDB)) {
			print "Mysql Error : ". $pearSyslogDB->getMessage()."\n";
		}
		# Set base value
		$FilterPrograms  = array("" => "");
		
		while ($program =&$res->fetchRow())
				$FilterPrograms[$program['program']] = $program['program'] ; 
		
		$FilterPrograms  = array_map("myDecode",$FilterPrograms );
		return $FilterPrograms ;
	}

	/**
	 * 
	 * Get complete list of Facilities
	 * @return array list of Facilities
	 */
	function getSyslogFacility() {
		global $pearDB;
		
		$cfg_syslog_facility = array();

		$DBRESULT =& $pearDB->query("SELECT * FROM `mod_syslog_filters_facility`");
		/*
		 * Set base value
		 */
		$cfg_syslog_facility = array_map("myDecode", $DBRESULT->fetchRow());
		$DBRESULT->free();
		return $cfg_syslog_facility;
	}

	/**
	 * 
	 * Get complete list of Priorities
	 * @return array list of Priorities
	 */
	function getSyslogPriority() {
		global $pearDB;
		
		$cfg_syslog_priority = array();

		$DBRESULT =& $pearDB->query("SELECT * FROM `mod_syslog_filters_priority`");
		/*
		 * Set base value
		 */
		$cfg_syslog_priority = array_map("myDecode", $DBRESULT->fetchRow());
		$DBRESULT->free();
		return $cfg_syslog_priority;
	}

	/**
	 * 
	 * Get list of selected facilities
	 * @param string $severity
	 * @param string $Fseverity
	 * @return array list of selected facilities
	 */
	function getListOfFacilities($facility, $Ffacility) {
		global $pearDB;
		
		if ((strcmp($facility, "") == 0) || (strcmp($facility, "undefined") == 0)) {
			return array("null" => "null");
		}
		
		$query = "SELECT value FROM `mod_syslog_filters_facility` WHERE `key` LIKE '".$facility."'";
		$res =& $pearDB->query($query);
		
		if (PEAR::isError($pearDB)) {
			print "Mysql Error : ". $pearDB->getMessage()."\n";
		}
		$intFacility = &$res->fetchRow();
		
		if (strcmp($Ffacility, "") == 0) {
			$math = "=";
		} else {
			$math = $Ffacility;
		}

		$query = "SELECT * FROM `mod_syslog_filters_facility` WHERE `value` ".$math." ".$intFacility["value"];
		$res =& $pearDB->query($query);

		if (PEAR::isError($pearDB)) {
			print "Mysql Error : ". $pearDB->getMessage()."\n";
		}

		$list_priorities = array();
		while ($tab =&$res->fetchRow()) {
            $list_priorities[$tab['key']] = $tab['value'] ;
		}
		$res->free();
		return $list_priorities;
	}

	/**
	 * 
	 * Get list of selected severities
	 * @param string $severity
	 * @param string $Fseverity
	 * @return array list of selected severities
	 */
	function getListOfSeverities($severity, $Fseverity) {
		global $pearDB;
		
		if ((strcmp($severity, "") == 0) || (strcmp($severity, "undefined") == 0)) {
			return array("null" => "null");
		}
		
		$query = "SELECT value FROM `mod_syslog_filters_priority` WHERE `key` LIKE '".$severity."'";
		$res =& $pearDB->query($query);
		
		if (PEAR::isError($pearDB)) {
			print "Mysql Error : ". $pearDB->getMessage()."\n";
		}
		$intSeverity = &$res->fetchRow();

		if (strcmp($Fseverity, "") == 0) {
			$math = "=";
		} else {
		    $math = $Fseverity;
		}

		$query = "SELECT * FROM `mod_syslog_filters_priority` WHERE `value` ".$math." ".$intSeverity["value"];
		$res =& $pearDB->query($query);

		if (PEAR::isError($pearDB)) {
			print "Mysql Error : ". $pearDB->getMessage()."\n";
		}
		
		$list_severities = array();
		while ($tab =&$res->fetchRow()) {
				$list_severities[$tab['key']] = $tab['value'] ;
		}
		$res->free();
		return $list_severities;
	}

	/**
	 * 
	 * Get list of Facilities from specific table
	 * @return array list of facilities
	 */
	function getAllFacilities() {
		global $pearDB;

		$res =& $pearDB->query("SELECT * FROM mod_syslog_filters_facility ORDER BY CAST(value AS UNSIGNED) ASC");
		if (PEAR::isError($pearDB)) {
			print "Mysql Error : ". $pearDB->getMessage()."\n";
		}
		# Set base value
		$FilterFacilities  =  array("" => "");
		
		while ($facility =& $res->fetchRow())
			$FilterFacilities[$facility['key']] = $facility['key']; 
			
		return $FilterFacilities;
	}

	/**
	 * 
	 * Get list of Severities from specific table
	 * @return array list of severities
	 */
	function getAllSeverities() {
		global $pearDB;

		$res =& $pearDB->query("SELECT * FROM mod_syslog_filters_priority ORDER BY CAST(value AS UNSIGNED) ASC");
		if (PEAR::isError($pearDB)) {
			print "Mysql Error : ". $pearDB->getMessage()."\n";
		}
		# Set base value
		$FilterSeverities  =  array("" => "");
		
		while ($severity =& $res->fetchRow())
			$FilterSeverities[$severity['key']] = $severity['key']; 
			
		$FilterSeverities = array_map("myDecode",$FilterSeverities );
		return $FilterSeverities;
	}

	/**
	 * 
	 * Enter description here ...
	 * @return array list of collectors
	 */
	function getCollectorList() {
	    global $pearDB;

		$res =& $pearDB->query("SELECT `collector_id`, `collector_name` FROM `mod_syslog_collector` ");
		if (PEAR::isError($pearDB)) {
			print "Mysql Error : ". $pearDB->getMessage()."\n";
		}
		# Set base value
		$collectorsList =  array("" => "");
		
		while ($element =& $res->fetchRow()) {
			$collectorsList[$element['collector_id']] = $element['collector_name']; 
		}

		return $collectorsList;
	}

	/**
	 * 
	 * Get event details
	 * @param PEAR::DB $pearSyslogDB
	 * @param array $cfg_syslog
	 * @param array $options
	 */
	function getEvent($pearSyslogDB, $cfg_syslog, $options) {
		$query = " SELECT * FROM " . $cfg_syslog["db_table_logs_merge"] ." ";
		$query .= "WHERE host = \"".$options['host']."\" ";
		$query .= "AND 	facility = \"".$options['facility']."\" ";
		$query .= "AND 	priority = \"".$options['priority']."\" ";
		$query .= "AND 	datetime = \"".$options['datetime']."\" ";
		$query .= "AND 	program = \"".$options['program']."\" ";

		$res =& $pearSyslogDB->query($query);
		if (PEAR::isError($pearSyslogDB)) {
			print "Mysql Error : ". $pearSyslogDB->getMessage()."\n";
		}
		# Set base value
		$eventDetails = array();
				
		$event =& $res->fetchRow();
		
		$eventDetails = array(
			'host' 		=> $event['host'],
			'facility' 	=> $event['facility'],
			'priority' 	=> $event['priority'],
			'tag' 		=> $event['tag'],
			'datetime'	=> $event['datetime'],
			'program'	=> $event['program'],
			'msg'		=> $event['msg'],
			'seq'		=> $event['seq'],
			'counter'	=> $event['counter'],
			'fo'		=> $event['fo'],
			'lo'		=> $event['lo']
		);
		
		return $eventDetails;
	}
?>
