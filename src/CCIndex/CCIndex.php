<?php
/**
* Standard controller layout.
* 
* @package ZeldaCore
*/
class CCIndex implements IController {

   /**
    * Implementing interface IController. All controllers must have an index action.
    */
   public function Index() {   
      global $ze;
      $ze->data['title'] = "The Index Controller";
      $ze->data['main'] = "<h1>The Index Controller</h1>";
   }
}

?>