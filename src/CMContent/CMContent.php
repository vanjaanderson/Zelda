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
      'create table content'    => "CREATE TABLE IF NOT EXISTS Content (id INTEGER PRIMARY KEY, key TEXT KEY, type TEXT, filter TEXT, title TEXT, data TEXT, idUser INT, created DATETIME default (datetime('now')), updated DATETIME default NULL, deleted DATETIME default NULL, FOREIGN KEY(idUser) REFERENCES User(id));",
      'insert content'          => 'INSERT INTO Content (key,type,filter,title,data,idUser) VALUES (?,?,?,?,?,?);',
      'select * by id'          => 'SELECT c.*, u.acronym as owner FROM Content AS c INNER JOIN User as u ON c.idUser=u.id WHERE c.id=?;',
      'select * by key'         => 'SELECT c.*, u.acronym as owner FROM Content AS c INNER JOIN User as u ON c.idUser=u.id WHERE c.key=?;',
      'select * by type'        => "SELECT c.*, u.acronym as owner FROM Content AS c INNER JOIN User as u ON c.idUser=u.id WHERE type=? ORDER BY {$order_by} {$order_order};",
      'select *'                => 'SELECT c.*, u.acronym as owner FROM Content AS c INNER JOIN User as u ON c.idUser=u.id;',
      'update content'          => "UPDATE Content SET key=?, type=?, filter=?, title=?, data=?, updated=datetime('now') WHERE id=?;",
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
      $this->db->ExecuteQuery(self::SQL('insert content'), array('hello-world',             'post', 'plain',          'Hej världen',                      "Detta är ett demoinlägg.", $this->user['id']));
      $this->db->ExecuteQuery(self::SQL('insert content'), array('hello-world-again',       'post', 'plain',          'Hej igen, världen',                "Detta är ett annat demoinlägg.", $this->user['id']));
      $this->db->ExecuteQuery(self::SQL('insert content'), array('hello-world-once-more',   'post', 'plain',          'Hej världen, återigen',            "Ytterligare ett demoinlägg.", $this->user['id']));
      /*$this->db->ExecuteQuery(self::SQL('insert content'), array('home',                    'page', 'plain',          'Hemsidan',                         "Detta är en demosida, det skulle kunna vara din personliga startsida.", $this->user['id']));
      $this->db->ExecuteQuery(self::SQL('insert content'), array('about',                   'page', 'plain',          'Om-sida',                          "Detta är en demosida, det skulle kunna vara din personliga om-sida.", $this->user['id']));
      $this->db->ExecuteQuery(self::SQL('insert content'), array('download',                'page', 'plain',          'Nedladdningssida',                 "Detta är en demosida, det skulle kunna vara din personliga nedladdningssida.", $this->user['id']));*/
      $this->db->ExecuteQuery(self::SQL('insert content'), array('Filter test',             'page', 'plain',          'Testsida CTextFilter',             'Här kan du testa olika filter genom att redigera sidan, se längst ner ovanför foten.

Med filtret "Plain", som är default, konverteras ingen kod i texten. Men generellt görs en tom rad vid radbrytning med enter. Detta sköter funktionen nl2br() om.

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
      /*$this->db->ExecuteQuery(self::SQL('insert content'), array('bbcode',                  'post', 'bbcode',         'Inlägg med BBCode',                  "Detta är en sida med BBCode-formattering.\n\n[b]Fet text[/b] och [i]kursiv text[/i] och [url=http://dbwebb.se]länk till dbwebb.se[/url]. Du kan även infoga bilder, såsom Zelda favicon: [img]http://www.student.bth.se/~vaan12/phpmvc/kmom04/zelda/themes/core/favicon_32x32.png[/img]", $this->user['id']));
      $this->db->ExecuteQuery(self::SQL('insert content'), array('htmlpurify',              'post', 'htmlpurify',     'Inlägg med HTMLPurifier',            "Detta är en demosida med HTML-kod som körs igenom <a href='http://htmlpurifier.org/'>HTMLPurify</a>. Ändra texten, skriv in lite HTML-kod för att kontrollera att det fungerar.\n\n<b>Fet text</b> och <i>kursiv text</i> och <a href='http://dbwebb.se'>en länk till dbwebb.se</a>. JavaScript: <javascript>alert('hej');</javascript> kommer att tas bort.", $this->user['id']));
      $this->db->ExecuteQuery(self::SQL('insert content'), array('make-clickable',          'post', 'make_clickable',  'Inlägg med make clickable',          "Om man bara använder filtret make_clickable så tillåts ingen html-kod eller bb-kod. Däremot görs länkar som till exempel http://www.dbwebb.se automatiskt klickbara. Skillnaden mot filtret plain är att inga radbrytningar görs när man använder make_clickable.", $this->user['id']));*/
      
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
      $data = CTextFilter::filter($data,"plain");
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