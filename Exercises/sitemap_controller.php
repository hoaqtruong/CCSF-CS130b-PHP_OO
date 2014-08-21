<?php
    class sitemapController extends ApplicationController {

        function index() {}

        function links() {
            $dh = opendir(VIEWS);
            $this->links = array();
            $dirs = array();
            while ($d = readdir($dh)) {
                if($d == '.' || $d == '..' || $d=='layouts') continue;
                if(!is_dir(VIEWS.$d)) continue;
                $dirs[] = $d;
            }
            sort($dirs);
            $this->dirs = array();
            foreach($dirs as $d) {
                $files = array();
                $dh2 = opendir(VIEWS.$d);
                $rootname = '';
                while($f = readdir($dh2)) {
                    if($f == '.' || $f == '..' || $f=='layouts') continue;
                    $rootname = substr($f,0,strpos($f,'.html'));
                    $files[] = $rootname;//'<a href="/~dputnam/cs130b/index.php?_r='.$d.'/'.$rootname.'">'.ucwords($rootname).'</a>'."\n";
                }
                $this->dirs[$d] = $files;
            }
        }
    }
