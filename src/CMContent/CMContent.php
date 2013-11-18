<?php
/**
* A model for content stored in database.
* 
* @package ZeldaCore
*/
class CMContent extends CObject implements IHasSQL, ArrayAccess {

  /**
   * Properties
   */
  public $data;

  /**
   * Constructor
   */
  public function __construct($id=null) {
    parent::__construct();
    if($id) {
      $this->LoadById($id);
    } else {
      $this->data = array();
    }
  }

  /**
   * Implementing ArrayAccess for $this->data
   */
  public function offsetSet($offset, $value) { if (is_null($offset)) { $this->data[] = $value; } else { $this->data[$offset] = $value; }}
  public function offsetExists($offset) { return isset($this->data[$offset]); }
  public function offsetUnset($offset) { unset($this->data[$offset]); }
  public function offsetGet($offset) { return isset($this->data[$offset]) ? $this->data[$offset] : null; }

  /**
   * Implementing interface IHasSQL. Encapsulate all SQL used by this class.
   *
   * @param string $key the string that is the key of the wanted SQL-entry in the array.
   */
  public static function SQL($key=null, $args=null) {
    $order_order  = isset($args['order-order']) ? $args['order-order'] : 'ASC';
    $order_by     = isset($args['order-by'])    ? $args['order-by'] : 'id';    
    $queries = array(
      'drop table content'      => "DROP TABLE IF EXISTS Content;",
      'create table content'    => "CREATE TABLE IF NOT EXISTS Content (id INTEGER PRIMARY KEY, key TEXT KEY, type TEXT, title TEXT, data TEXT, filter TEXT, idUser INT, created DATETIME default (datetime('now')), updated DATETIME default NULL, deleted DATETIME default NULL, FOREIGN KEY(idUser) REFERENCES User(id));",
      'insert content'          => 'INSERT INTO Content (key,type,title,data,filter,idUser) VALUES (?,?,?,?,?,?);',
      'select * by id'          => 'SELECT c.*, u.acronym as owner FROM Content AS c INNER JOIN User as u ON c.idUser=u.id WHERE c.id=?;',
      'select * by key'         => 'SELECT c.*, u.acronym as owner FROM Content AS c INNER JOIN User as u ON c.idUser=u.id WHERE c.key=?;',
      'select * by type'        => "SELECT c.*, u.acronym as owner FROM Content AS c INNER JOIN User as u ON c.idUser=u.id WHERE type=? ORDER BY {$order_by} {$order_order};",
      'select *'                => 'SELECT c.*, u.acronym as owner FROM Content AS c INNER JOIN User as u ON c.idUser=u.id;',
      'update content'          => "UPDATE Content SET key=?, type=?, title=?, data=?, filter=?, updated=datetime('now') WHERE id=?;",
     );
    if(!isset($queries[$key])) {
      throw new Exception("SQL-frågan, '$key' hittades ej.");
    }
    return $queries[$key];
  }

  /**
   * Init the database and create appropriate tables.
   */
  public function Init() {
    try {
      $this->db->ExecuteQuery(self::SQL('drop table content'));
      $this->db->ExecuteQuery(self::SQL('create table content'));
      $this->db->ExecuteQuery(self::SQL('insert content'), array('hello-world', 'post', 'Hej världen', 'Detta är ett demoinlägg.', 'plain', $this->user['id']));
      $this->db->ExecuteQuery(self::SQL('insert content'), array('hello-world-again', 'post', 'Hej igen, världen', 'Detta är ett annat demoinlägg.', 'plain', $this->user['id']));
      $this->db->ExecuteQuery(self::SQL('insert content'), array('hello-world-once-more', 'post', 'Hej världen, återigen', 'Ytterligare ett demoinlägg.', 'plain', $this->user['id']));
      $this->db->ExecuteQuery(self::SQL('insert content'), array('home', 'page', 'Hemsidan', 'Detta är en demosida, det skulle kunna vara din personliga startsida.', 'plain', $this->user['id']));
      $this->db->ExecuteQuery(self::SQL('insert content'), array('about', 'page', 'Om-sida', 'Detta är en demosida, det skulle kunna vara din personliga om-sida.', 'plain', $this->user['id']));
      $this->db->ExecuteQuery(self::SQL('insert content'), array('download', 'page', 'Nedladdningssida', 'Detta är en demosida, det skulle kunna vara din personliga nedladdningssida.', 'plain', $this->user['id']));
      $this->db->ExecuteQuery(self::SQL('insert content'), array('bbcode', 'page', 'Sida med BBCode', "Detta är en sida med BBCode-formattering.\n\n[b]Fet text[/b] och [i]kursiv text[/i] och [url=http://dbwebb.se]länk till dbwebb.se[/url]. 
        Du kan även infoga bilder, såsom Zelda favicon: [img]http://www.student.bth.se/~vaan12/phpmvc/kmom04/zelda/themes/core/favicon_32x32.png[/img]", 'bbcode', $this->user['id']));
      $this->AddMessage('success', 'Databastabeller och inlägg "Hej världen" skapades, med dig som författare.');
    } catch(Exception$e) {
      die("$e<br/>Databaskopplingen misslyckades: " . $this->config['database'][0]['dsn']);
    }
  }
  
  /**
   * Save content. If it has a id, use it to update current entry or else insert new entry.
   *
   * @returns boolean true if success else false.
   */
  public function Save() {
    $msg = null;
    if($this['id']) {
      $this->db->ExecuteQuery(self::SQL('update content'), array($this['key'], $this['type'], $this['title'], $this['data'], $this['filter'], $this['id']));
      $msg = 'uppdaterat';
    } else {
      $this->db->ExecuteQuery(self::SQL('insert content'), array($this['key'], $this['type'], $this['title'], $this['data'], $this['filter'], $this->user['id']));
      $this['id'] = $this->db->LastInsertId();
      $msg = 'skapat';
    }
    $rowcount = $this->db->RowCount();
    if($rowcount) {
      $this->AddMessage('success', "Innehåll {$msg} '" . htmlEnt($this['key']) . "'.");
    } else {
      $this->AddMessage('error', "Misslyckades att {$msg} innehåll '" . htmlEnt($this['key']) . "'.");
    }
    return $rowcount === 1;
  }
    
  /**
   * Load content by id.
   *
   * @param id integer the id of the content.
   * @returns boolean true if success else false.
   */
  public function LoadById($id) {
    $res = $this->db->ExecuteSelectQueryAndFetchAll(self::SQL('select * by id'), array($id));
    if(empty($res)) {
      $this->AddMessage('error', "Laddande av innehållet med id '$id' misslyckades.");
      return false;
    } else {
      $this->data = $res[0];
    }
    return true;
  }
    
  /**
   * List all content.
   *
   * @param $args array with various settings for the request. Default is null.
   * @returns array with listing or null if empty.
   */
  public function ListAll($args=null) {    
    try {
      if(isset($args) && isset($args['type'])) {
        return $this->db->ExecuteSelectQueryAndFetchAll(self::SQL('select * by type', $args), array($args['type']));
      } else {
        return $this->db->ExecuteSelectQueryAndFetchAll(self::SQL('select *', $args));
      }
    } catch(Exception $e) {
      echo $e;
      return null;
    }
  }

  /**
   * Filter content according to a filter.
   *
   * @param $data string of text to filter and format according its filter settings.
   * @returns string with the filtered data.
   */
  public static function Filter($data, $filter) {
    switch($filter) {
      /*case 'php': $data = nl2br(makeClickable(eval('?>'.$data))); break;
      case 'html': $data = nl2br(makeClickable($data)); break;*/
      case 'bbcode': $data = nl2br(bbcode2html(htmlEnt($data))); break;
      case 'plain':
      default: $data = nl2br(makeClickable(htmlEnt($data))); break;
    }
    return $data;
  }
   
  /**
   * Get the filtered content.
   *
   * @returns string with the filtered data.
   */
  public function GetFilteredData() {
    return $this->Filter($this['data'], $this['filter']);
  }
}

?>