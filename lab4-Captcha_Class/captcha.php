<?php

class captcha
{

//
//    PUBLIC PARAMS
//
    public $tempfolder;
    public $chars        = 6;  
    public $use_only_md5 = FALSE;  
    public $minsize    = 20;   
    public $maxsize    = 40;   
    public $maxrotation = 25;
    public $noise        = TRUE;
    public $websafecolors = FALSE;    
    public $maxtry        = 3;
    public $refreshlink = TRUE;
    public $secretposition = 21;
    public $secretstring = "This is a very secret string. Nobody should know it, =:)";  
    public $form_action_method = 'POST';


//
//    PRIVATE PARAMS
//	
	private $lx;                   // width of picture
	private $ly;                   // height of picture
	private $TTF_file;             // holds the current selected TrueTypeFont
	private $public_K;
	private $private_K;
	private $key;                  // md5-key
	private $filename;             // filename of captcha picture
	private $current_try = 0;
	protected $public_key;         // public key
	protected $msg1;
	protected $msg2;
	protected $buttontext = 'submit';
	protected $refreshbuttontext = 'new ID';
	protected $QUERY_STRING;       // keeps the ($_GET) Querystring of the original Request


	public function __construct()
	{

		// set all messages	
		$this->msg1 = 'Type the characters that you see in the box (<b>'.$this->chars.' characters</b>). The code can include characters <b>0 to 9</b> and <b>A to Z</b>.';
		$this->msg2 = 'I cannot read the characters. Generate a ';		
		
		$_method = strtoupper($this->form_action_method)==='GET' ? '_GET' : '_POST';
		
		// sanitize pathes
		$this->tempfolder = '../../images/_tmp/';
		$this->tempfolder = str_replace(array('\\'), array('/'), $this->tempfolder);
		$this->TTF_file = '../../fonts/actionj.ttf'; 

		// set dimension of image
		$this->lx = ($this->chars + 1) * (int)(($this->maxsize + $this->minsize) / 1.5);
		$this->ly = (int)(2.4 * $this->maxsize);

		// keep params from original GET-request
		if($this->form_action_method !== 'GET')
		{
			$this->QUERY_STRING = strlen(trim($_SERVER['QUERY_STRING'])) > 0 ? '?'.strip_tags($_SERVER['QUERY_STRING']) : '';
			$refresh = $_SERVER['PHP_SELF'].$this->QUERY_STRING;
		}

		// check Form_Vars
		$pub  = $this->get_form_var('captcha_public_key');
		$priv = $this->get_form_var('captcha_private_key');
		$try  = $this->get_form_var('captcha');

		if($pub!==NULL)  $this->public_K = substr($pub,0,$this->chars);
		if($priv!==NULL) $this->private_K = substr($priv,0,$this->chars);


		if(!isset($GLOBALS[$_method]['captcha_refresh'])) $this->current_try++;

		// generate Keys
		$this->key = md5($this->secretstring);
		$this->public_key = substr(md5(uniqid(rand(),true)), 0, $this->chars);
	}


//
//    PUBLIC METHODS
//

	public function display_form($only_body=FALSE)
	{
		$s = '';
		if(!$only_body)
		{
			$s .= '<div id="captcha">';
			$s .= '<form class="captcha" name="captcha1" action="'.$_SERVER['PHP_SELF'].$this->QUERY_STRING.'" method="POST">'."\n";
		}
		$s .= '<input type="hidden" name="captcha" value="">'."\n";
		$s .= '<p class="captcha_1">'.$this->display_captcha()."</p>\n";
		$s .= '<p class="captcha_1">'.$this->msg1.'</p>';
		$s .= '<p class="captcha_1"><input class="captcha" type="text" name="captcha_private_key" value="" maxlength="'.$this->chars.'" size="'.$this->chars.'">&nbsp;&nbsp;';
		if($this->refreshlink)
		{
			$s .= '<p class="captcha_2">'.$this->msg2;
			$s .= ' <input class="captcha_2" type="submit" name="captcha_refresh" value="'.$this->refreshbuttontext.'">'."</p>\n";
		}
		$s .= '<input class="captcha" type="submit" value="'.$this->buttontext.'">'."</p>\n";
		if(!$only_body)
		{
			$s .= '</form>'."\n";
			$s .= '</div>';
		}
		return $s;
	}


	public function display_form_part($which='all')
	{
		$ret = '';
		$which = strtolower($which);

		if($which==='all')
		{
			$ret .= $this->display_form(TRUE);
			return $ret;
		}

		if($which==='image')
		{
			$try = $this->get_try(FALSE);
			$ret .= '<input type="hidden" name="captcha" value="'.$try.'">'."\n";
			$ret .= $this->display_captcha()."\n";
		}

		if($which==='input')
		{
			$ret .= '<input class="captcha" type="text" name="captcha_private_key" value="" maxlength="'.$this->chars.'" size="'.$this->chars.'">'."\n";
		}

		if($which==='text')
		{
			$ret .= $this->msg1."\n";
		}

		if($which==='text_notvalid')
		{
			$ret .= $this->notvalid_msg()."\n";
		}


		if($which==='refresh_text' || $which==='refreshtext')
		{
			$ret .= $this->msg2."\n";
		}

		if($which==='refresh_button' || $which==='refreshbutton')
		{
			$this->refreshlink = TRUE;
			$ret .= '<input class="captcha" type="submit" name="captcha_refresh" value="'.$this->refreshbuttontext.'">'."\n";
		}

		return $ret;
	}

    /**
          *
          * @shortdesc validates POST-vars and return result
          * @public
          * @type integer
          * @return 0 = first call | 1 = valid submit | 2 = not valid | 3 = not valid and has reached maximum try's
          *
          **/
	public function validate_submit()
	{
		if($this->check_captcha($this->public_K,$this->private_K))
		{
			return 1;
		}
		else
		{
			if($this->current_try > $this->maxtry)
			{
				return 3;
			}
			elseif($this->current_try > 0)
			{
				return 2;
			}
			else
			{
				return 0;
			}
		}
	}


//
//    PRIVATE METHODS
//

	/** @private **/
	private function generate_private($public='')
	{
		if($public==='') $public = $this->public_key;
		if($this->use_only_md5)
		{
			$key = substr(md5($this->key.$public), 16 - (int)($this->chars / 2), $this->chars);
		}
		else
		{
			$key = substr(base64_encode(md5($this->key.$public)), 16 - (int)($this->chars / 2), $this->chars);
			$key = strtr($key, '0OoIi1B8+-_/=', 'WXxLL7452369H');
		}
		return $key;
	}


	/** @private **/
	private function display_captcha($onlyTheImage=FALSE)
	{
		$this->make_captcha();
		$is = getimagesize($this->get_filename());
		$ret = "\n".'<img class="captchapict" src="'.$this->get_filename_url().'" '.$is[3].' alt="This is a captcha-picture. It is used to prevent mass-access by robots. (see: www.captcha.net)" title="">'."\n";
		return $onlyTheImage ? $ret : $this->public_key_input().$ret;
	}

	/** @private **/
	private function public_key_input()
	{
		return '<input type="hidden" name="captcha_public_key" value="'.$this->public_key.'">';
	}

	/** @private **/
	private function random_color($min,$max)
	{
		srand((double)microtime() * 1000000);
		$this->r = intval(rand($min,$max));
		srand((double)microtime() * 1000000);
		$this->g = intval(rand($min,$max));
		srand((double)microtime() * 1000000);
		$this->b = intval(rand($min,$max));
		//echo " (".$this->r."-".$this->g."-".$this->b.") ";
	}
		
	/** @private **/
	private function make_captcha()
	{
		$private_key = $this->generate_private();	

		$im = ImageCreate($this->lx,$this->ly);
		
		// Set Backgroundcolor
		$this->random_color(224, 255);
		$back =  imagecolorallocate($im, $this->r, $this->g, $this->b);
		ImageFilledRectangle($im,0,0,$this->lx,$this->ly,$back);
		
		// generate grid
		for($i=0; $i < $this->lx; $i += (int)($this->minsize / 1.5))
		{
			$this->random_color(160, 224);
			$color    = imagecolorallocate($im, $this->r, $this->g, $this->b);
			@imageline($im, $i, 0, $i, $this->ly, $color);
		}
		
		for($i=0 ; $i < $this->ly; $i += (int)($this->minsize / 1.8))
		{
			$this->random_color(160, 224);
			$color    = imagecolorallocate($im, $this->r, $this->g, $this->b);
			imageline($im, 0, $i, $this->lx, $i, $color);
		}
		
		// Write text

		$textcolor = ImageColorAllocate($im, 191, 120, 120);



		$y = 50;

		for($i = 0; $i < $this->chars; $i++)
		{
			$char = $private_key[$i];
			$factor = 30;
			$x = ($factor * ($i + 1)) - 6;
			$angle = rand(1, 15);
			$size    = intval(rand($this->minsize, $this->maxsize));
			imagettftext($im, $size, $angle, $x, $y, $textcolor, $this->TTF_file, $char);			
		}
		
		//generate fracments
		for ($i =0; $i<3; $i++) {
			imageellipse($im, rand(1,200), rand(1,150), rand(1,300), rand(1,200), $textcolor);
			imageellipse($im, rand(1,200), rand(1,150), rand(1,30), rand(1,40), $textcolor);
			imagerectangle($im, rand(1,200), rand(1,150), rand(1,200), rand(1,200), $textcolor);
			imagerectangle($im, rand(1,200), rand(1,150), rand(1,10), rand(1,10), $textcolor);			
		}



		ImageJPEG($im, $this->get_filename(), 70);
		$res = file_exists($this->get_filename());
	
		ImageDestroy($im);
		if(!$res) die('Unable to save captcha-image.');
	}
	
	/** @private **/
	private function check_captcha($public,$private)
	{
		$res = 'FALSE';
		
		if(file_exists($this->get_filename($public)))
		{
			$res = @unlink($this->get_filename($public)) ? 'TRUE' : 'FALSE';
			$res = (strtolower($private)===strtolower($this->generate_private($public))) ? 'TRUE' : 'FALSE';
		}
		return $res==='TRUE' ? TRUE : FALSE;
	}
		
	/** @protected **/
	protected function get_filename($public='')
	{
		if($public==='') $public = $this->public_key;
		return $this->tempfolder.$public.'.jpg';
	}

	/** @protected **/
	protected function get_filename_url($public='')
	{
		if($public==='') $public = $this->public_key;
		return 'http://hills.ccsf.edu/~htruong3/images/_tmp/'.$public.'.jpg';
	}

	/** @private **/
	private function get_form_var($varname)
	{
		if($this->form_action_method==='POST')
		{
			if(isset($_POST[$varname]))
			{
				return strip_tags($_POST[$varname]);
			}
		}
		if($this->form_action_method==='GET')
		{
			if(isset($_GET[$varname]))
			{
				return strip_tags($_GET[$varname]);
			}
		}
		return NULL;
	}




} // END CLASS captcha

?>