<?php
   // print DOCTYPE
   // print head
   // print body
   // print cotents
   // 93 tags + attributes 

   class HTML {
      static $html = null;
      static private $style = array();
      static private $instance = null;

      private function __construct($doctype='html4transitional') {

      }

      static function getInstance() {
         if(is_null(self::$instance)) {
            self::$instance = new HTML();
         }
         return self::$instance;
      }

      function html($data,$extra='') {
         return '<html ' .$extra.'>'.$data.'</html>';
      }
      function render($data=null) {
         return $this->doctype() . 
            $this->html($this->head() . 
                $this->body($data)
         );
      }
      function head($title = 'Test Class') {
         return '<head><title>'.$title.'</title>' .
            '<style type="text/css">' .
            implode("\n",self::$style) .'</style></head>
         ';
      }
      function body($data,$extra='') {
         return '<body ' .$extra.'>'.$data.'</body>';
      }
      function doctype($type='xhtml_strict') {
         $doctypes = array('xhtml_strict' =>
          '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
         "http://www.w3.org/TR/html4/loose.dtd">'); 
         return $doctypes[$type];
      }
      function table($data,$extra='') {
         return '<table ' .$extra.'>'.$data.'</table>';
      }
      function tr($data,$extra='') {
         return '<tr ' .$extra.'>'.$data.'</tr>';
      }
      function td($data,$extra='') {
         return '<td ' .$extra.'>'.$data.'</td>';
      }
      function blockquote($data,$extra='') {
         return '<blockquote ' .$extra.'>'.$data.'</blockquote>';
      }
      function ol($data,$extra=''){
         return '<ol ' .$extra.'>'.$data.'</ol>';
      }
      function ul($data,$extra=''){
         return '<ul ' .$extra.'>'.$data.'</ul>';
      }
      function li($data,$extra=''){
         return '<li ' .$extra.'>'.$data.'</li>';
      }
      function br() {
         return '<br />';
      }
      function pre($data,$extra='') {
         return '<pre ' .$extra.'>'.$data.
'</pre>';
      }
      function hr($extra='',$extra='') {
         return '<hr '.$extra.'/>';
      }
      function span($data,$extra='') {
         return '<span ' .$extra.'>'.$data.'</span>';
      }
      function style($style) {
         self::$style[] = $style;
      }
      function h($data,$n=1,$extra='') {
         return '<h'.$n.$extra.'>'.$data.'</h'.$n.'>';
      }

   }

   $h = HTML::getInstance();

   $h->style(".highlight { background:yellow;}");
   $h->style("body{ background:darkcyan;color:white;}");

   print $h->render(
        $h->h('Welcome',2).
        $blockquote = $h->blockquote(
           $h->table(
              $h->tr(
                 $h->td($h->h('Lab 1').'This is a table cell','class="highlight"')
              )
           ) 
       )
   );
