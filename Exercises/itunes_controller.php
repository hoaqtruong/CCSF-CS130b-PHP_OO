<?php

    class ItunesController extends ApplicationController {

        public $playlist = 'TheClash.xml';
        public $sort_by  = 'Name';
        public $sort_direction  = 'up';
        public $songs = array();
        static $xmlDir = '';
        
        function __construct($request)
        {
            self::$xmlDir = XML . 'itunes/';
            parent::__construct($request);
            if(!isset($this->id)) $this->id = 0;
            if(isset($this->r->playlist) && is_file(XML.basename($this->r->playlist))) {
               $this->playlist = basename($this->r->playlist);
            }
            $playlists = $this->getPlaylists();
            $this->lists = array();
            foreach($playlists as $k => $v) {
               $this->lists[$k] = $v;
            }
            if(isset($this->r->sort_by)) {
               $this->sort_by = $this->r->sort_by;
            }
        }
        function forNavigation()
        {
           $dh = opendir(XML.'itunes/');
           $files = array();
           $flipped = array_flip($this->lists);
           while($f = readdir($dh)) {
              if(strstr($f,'.xml')) {
                 $files[] = $flipped[$f];
              }
           }
           return $files;
        }

        function getPlaylists()
        {
           $dh = opendir(self::$xmlDir);
           $out = array();
           while($x = readdir($dh)) {
              if(strstr($x, '.xml')) {
                 $out[] = $x;
              }
           }
           return $out;
        }

        function show() {
        }

        function index() {
           $this->getSongs();
        }

        function getSongs() {
           $sort_by = $this->sort_by;
           $sort_direction = $this->sort_direction;
           $this->songs = array();
           $xml = null;

           $dom = new DomDocument();

           if(!$dom->load(self::$xmlDir.$this->lists[$this->id])) {
              return false;
           }

           $root = $dom->documentElement;

           $children = $root->childNodes;           

           foreach($children as $child) {
              if($child->nodeName == 'dict') {
                $root = $child;
                break;
              }
           }

           $children = $root->childNodes;           
           foreach ($children as $child){
              if ($child->nodeName=="dict") {
               $root = $child;
                break;
              }   
           } 

           // Go through this process again
           $children = $root->childNodes;           

           foreach($children as $child) {
              if($child->nodeName == 'dict') {
                 $song = null;
                 $elements = $child->childNodes;
                 for($i = 0; $i < $elements->length; $i++) {
                    if($elements->item($i)->nodeName == "key") {
                       $key = $elements->item($i)->textContent;
                       $i++;
                       $value = $elements->item($i)->textContent;
                       $song[$key] = $value;
                    }
                 }
                 if($song) $this->songs[] = $song;
              }
           }
           uasort($this->songs,'sort_by');

        }
    }

