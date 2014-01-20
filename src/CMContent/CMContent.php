<?php
/**
* A model for content stored in database.
* 
* @package ZeldaCore
*/
class CMContent extends CObject implements IHasSQL, ArrayAccess, IModule {

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
      'create table content'    => "CREATE TABLE IF NOT EXISTS Content (id INTEGER PRIMARY KEY, key TEXT KEY, type TEXT, filter TEXT, title TEXT, data TEXT, idUser INT, created DATETIME default (datetime('now')), updated DATETIME default NULL, deleted DATETIME default NULL, FOREIGN KEY(idUser) REFERENCES User(id));",
      'insert content'          => 'INSERT INTO Content (key,type,filter,title,data,idUser) VALUES (?,?,?,?,?,?);',
      'select * by id'          => 'SELECT c.*, u.acronym as owner FROM Content AS c INNER JOIN User as u ON c.idUser=u.id WHERE c.id=?;',
      'select * by key'         => 'SELECT c.*, u.acronym as owner FROM Content AS c INNER JOIN User as u ON c.idUser=u.id WHERE c.key=?;',
      'select * by type'        => "SELECT c.*, u.acronym as owner FROM Content AS c INNER JOIN User as u ON c.idUser=u.id WHERE type=? ORDER BY {$order_by} {$order_order};",
      'select *'                => 'SELECT c.*, u.acronym as owner FROM Content AS c INNER JOIN User as u ON c.idUser=u.id;',
      'update content'          => "UPDATE Content SET key=?, type=?, filter=?, title=?, data=?, updated=datetime('now') WHERE id=?;",
      'update content as deleted' => "UPDATE Content SET deleted=datetime('now') WHERE id=?;",
     );
    if(!isset($queries[$key])) {
      throw new Exception("SQL-frågan, '$key' hittades ej.");
    }
    return $queries[$key];
  }

  /**
   * Implementing interface IModule. Manage install/update/deinstall and equal actions.
   * Filters to use: htmlpurify, bbcode, plain, make_clickable, markdownextra or smartypants.
   */
  public function Manage($action=null) {
    switch($action) {
      case 'install': 
        try {
          $this->db->ExecuteQuery(self::SQL('drop table content'));
          $this->db->ExecuteQuery(self::SQL('create table content'));   
          $this->db->ExecuteQuery(self::SQL('insert content'), array('welcome-to-zelda',                 'page', 'markdownextra',   'Välkommen till Zelda', "Denna sida är förinställd att visas i menyn.\n\nÄndra innehållet till det du vill, eller skapa en ny sida som du sedan bestämmer ska vara defaultsida (i filen <code>site/themes/mytheme/my_config.php</code>).", $this->user['id']));
          $this->db->ExecuteQuery(self::SQL('insert content'), array('ett-rykande-farskt-inlagg',       'post', 'markdownextra',  'Ett rykande färskt inlägg',     "Detta är ett demoinlägg för att se hur ett sådant ser ut.\n\nDu skapar nya inlägg, raderar eller redigerar de som finns.\n\nAnvänder du markdownextra som filter, kan du skriva rubriker, fet text, kursiv text etc, på ett enkelt sätt. Se sidan med [CTextFilter](/Zelda-master/page/view/4/).\n\nEtt stort lycka till!", $this->user['id']));
          $this->db->ExecuteQuery(self::SQL('insert content'), array('hello-world-once-more',   'post', 'plain',          'Hej världen, återigen', "Ytterligare ett demoinlägg.", $this->user['id']));
          $this->db->ExecuteQuery(self::SQL('insert content'), array('Filter test',             'page', 'plain',          'Testsida CTextFilter',  'Här kan du testa olika filter genom att redigera sidan, se längst ner ovanför foten.

Med filtret "Plain", som är default, konverteras ingen kod i texten. Men generellt görs en tom rad vid radbrytning med enter. Detta sköter funktionen nl2p() om.

Med filtret "Make Clickable" så görs textsträngar med http://xxx eller https://xxx automatiskt klickbara.

Med filtret "Smarty Pants (Typographer)" konverteras texten till typografiskt riktiga tecken. Bland annat blir citattecken och tankstreck (två bindestreck) snyggare. Tusentalsavgränsare blir icke brytande mellanslag. Exempel: 20 000 000 000 000 000 000 000 000 000 000 000 000 -- 100 000 000 000 000 000 000 000 000 000 000 000 000 kommer ej att radbrytas mellan siffergrupperna och får ett snyggt från -- till tecken (m dash).

[h2]BBCode[/h2]
Med filtret "BBCode" kan du formattera [b]fet text[/b], [i]kursiv text[/i] eller länk till [url=http://vanjaanderson.com]vanjaanderson.com[/url].
Du kan även infoga bilder, såsom Zelda favicon: [img]http://www.student.bth.se/~vaan12/phpmvc/kmom04/zelda/themes/core/favicon_32x32.png[/img]

<h2>HTML Purifier</h2>
Med filtret "HMTL Purifier" kan du formattera <b>fet text</b>, <i>kursiv text</i> eller länk till <a href="http://vanjaanderson.com">vanjaanderson.com</a>. 
JavaScript-taggar: <javascript>alert("hej");</javascript> kommer att tas bort.

Markdown (Extra)
------------------
Med filtret "Markdown Extra" kan man formattera **fet text**, *kursiv text* eller länk till [vanjaanderson.com](http://vanjaanderson.com) på ett enkelt sätt. Vanliga HTML-taggar fungerar också, vilket gör att html-taggarna i HTML Purifier-stycket även fungerar med detta filter.

###Onumrerad lista
* Gordon
* Iggy
* Sixten
* Baloo

###Numrerad lista
1. Gordon
2. Iggy
3. Sixten
4. Baloo

###Blockcitat
> Katter är sköna typer!

###Tabell
| Namn (vänsterställd) | Ras (centrerad) | Färg (högerställd) |
|:---------------------|:---------------:|-------------------:|
| Gordon               | Devon Rex       | Rödspotted         |
| Iggy                 | Devon Rex       | Svart smoke        |
| Sixten               | Huskatt         | Svart/Grå          |
| Baloo                | Huskatt         | Grå                | ', $this->user['id']));
      return array('notice', 'Databastabeller och inlägg skapades, med dig som författare.');
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
   * Save content. If it has a id, use it to update current entry or else insert new entry.
   *
   * @returns boolean true if success else false.
   */
  public function Save() {
    $msg = null;
    if($this['id']) {
      $this->db->ExecuteQuery(self::SQL('update content'), array($this['key'], $this['type'], $this['filter'], $this['title'], $this['data'], $this['id']));
      $msg = 'uppdaterat';
    } else {
      $this->db->ExecuteQuery(self::SQL('insert content'), array($this['key'], $this['type'], $this['filter'], $this['title'], $this['data'], $this->user['id']));
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
   * Delete content. Set its deletion-date to enable wastebasket functionality.
   *
   * @returns boolean true if success else false.
   */
  public function Delete() {
    if($this['id']) {
      $this->db->ExecuteQuery(self::SQL('update content as deleted'), array($this['id']));
    }
    $rowcount = $this->db->RowCount();
    if($rowcount) {
      $this->AddMessage('success', "Innehåll '" . htmlEnt($this['key']) . "' är satt som borttaget.");
    } else {
      $this->AddMessage('error', "Misslyckades med att sätta innehåll '" . htmlEnt($this['key']) . "' som borttaget.");
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
    $accepted_filters = array('htmlpurify','bbcode','plain','make_clickable','markdownextra', 'smartypants');
    if(in_array($filter,$accepted_filters)) {
      $data = CTextFilter::filter($data,$filter);
    } else {
      $data = CTextFilter::filter($data,'plain');
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