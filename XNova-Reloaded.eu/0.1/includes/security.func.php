<?php

/*
Wichtige Funktionen f�r die Sicherheit des Scriptes
*/

/*
Name: unregister_globals();
Funktion:
Entfernt alle Variablen welche mit register_globals erstellt wurden.

*/

function unregister_globals() {
    // �berpr�fung, ob Register Globals l�uft
    if(ini_get("register_globals") == "1") {
        // Erstellen einer Liste der Superglobals
        $superglobals=array("_GET", "_POST", "_REQUEST", "_ENV", "_FILES", "_SESSION", "_COOKIES", "_SERVER");
        foreach($GLOBALS as $key => $value) {
            // �berpr�fung, ob die Variablen/Arrays zu den Superglobals geh�ren, andernfalls l�schen
            if(!in_array($key, $superglobals) && $key != "GLOBALS") {
                unset($GLOBALS[$key]);
            }
        }
        return true;
    }
    else {
        // L�uft Register Globals nicht, gibt es nichts zu tun.
        return true;
    }
}

/** 
 * @name 		class security
 * @author 		gianluca311
 * @project 	xnova-reloaded.de
 * @features 	checkt die $_GET Methode nach nicht im System registrierten Seiten
 */
class security {

	protected $_db = NULL;

	public function __construct($db) {
		if(!is_object($db)) {
			throw new Exception("Error. DB vari isn't a db object :: Huch. Fehler. Die DB Vari ist kein Objekt");
			exit();
		}
		$this->check();
		$this->_db = $db;
	}
	
	public function check() {
		$DB = $this->_db;
		require_once("switch.php");
		if(isset($_GET['action'])) {
			foreach($actions as $action) {
				if($_GET['action'] != $action) {
					die("This site isn't registered in the system");
					$Query = $DB->prepare("INSERT INTO ".PREFIX."security (ip, time, uri) VALUES('".$_SERVER['REMOTE_ADDR']."', '".time()."', :uri");
					$Query->bindParam(":uri", $_SERVER['REQUEST_URI']);
					$Query->execute();
				}
			}
		}
		elseif(isset($_GET) && !isset($_GET['action'])) {
			die("This site isn't registered in the system");
					$Query = $DB->prepare("INSERT INTO ".PREFIX."security (ip, time, uri) VALUES('".$_SERVER['REMOTE_ADDR']."', '".time()."', :uri");
					$Query->bindParam(":uri", $_SERVER['REQUEST_URI']);
					$Query->execute();
		}
	}
}
?>