<?php
/**
* A model for a guestbok, to show off some basic controller & model-stuff.
* 
* @package ZeldaCore
*/
class CMGuestbook extends CObject implements IHasSQL, IModule {

  /**
   * Constructor
   */
  public function __construct() {
    parent::__construct();
  }

  /**
   * Implementing interface IHasSQL. Encapsulate all SQL used by this class.
   *
   * @param string $key the string that is the key of the wanted SQL-entry in the array.
   */
  public static function SQL($key=null) {
    $queries = array(
      'create table guestbook'  => "CREATE TABLE IF NOT EXISTS Guestbook (id INTEGER PRIMARY KEY, entry TEXT, created DATETIME default (datetime('now')));",
      'insert into guestbook'   => 'INSERT INTO Guestbook (entry,created) VALUES (?,?);',
      'select * from guestbook' => 'SELECT * FROM Guestbook ORDER BY id DESC;',
      'delete from guestbook'   => 'DELETE FROM Guestbook;',
     );
    if(!isset($queries[$key])) {
      throw new Exception("SQL-frågan, '$key' hittades inte.");
    }
    return $queries[$key];
  }

  /**
   * Implementing interface IModule. Manage install/update/deinstall and equal actions.
   */
  public function Manage($action=null) {
    switch($action) {
      case 'install': 
        try {
          $this->db->ExecuteQuery(self::SQL('create table guestbook'));
          return array('notice', 'Databastabell skapad (om den inte redan fanns).');
        } catch(Exception$e) {
          die("$e<br/>Databaskopplingen misslyckades: " . $this->config['database'][0]['dsn']);
        }
      break;
      
      default:
        throw new Exception('Otillåten aktivitet för denna modul.');
      break;
    }
  }

  /**
   * Init the guestbook and create appropriate tables.
   */
  /*public function Init() {
    try {
      $this->db->ExecuteQuery(self::SQL('create table guestbook'));
      $this->session->AddMessage('notice', 'Databastabell skapad (om den inte redan fanns).');
    } catch(Exception$e) {
      die("$e<br/>Databaskopplingen misslyckades: " . $this->config['database'][0]['dsn']);
    }
  }*/
  
  /**
   * Add a new entry to the guestbook and save to database.
   */
  public function Add($entry) {
    $this->db->ExecuteQuery(self::SQL('insert into guestbook'), array($entry, date('Y-m-d H:i:s')));
    $this->session->AddMessage('success', 'Meddelande sparat.');
    if($this->db->rowCount() != 1) {
      die('Det gick inte att spara meddelandet i databasen.');
    }
  }
  
  /**
   * Delete all entries from the guestbook and database.
   */
  public function DeleteAll() {
    $this->db->ExecuteQuery(self::SQL('delete from guestbook'));
    $this->session->AddMessage('info', 'Alla meddelanden raderade.');
  }
    
  /**
   * Read all entries from the guestbook & database.
   */
  public function ReadAll() {
    try {
      return $this->db->ExecuteSelectQueryAndFetchAll(self::SQL('select * from guestbook'));
    } catch(Exception$e) {
      return array();    
    }
  } 
}

?>