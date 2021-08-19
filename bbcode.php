class bbcode
{

	private $allowed_tags = array();

	public function __construct() {
		if( file_exists('bbcode.conf') ) {
			$conf = file_get_contents( 'bbcode.conf' );
			$lines = explode("\n", $conf);
			$start_tagging = false;
			foreach( $lines as $l ){
				if( $start_tagging ){
					if( substr($l,0,2) != '//' ) {
						$l = preg_replace( '/([^a-z])/', '', strtolower( $l ) );
						if ( strlen( $l ) > 0 ) {
							$this->allowed_tags[ $l ] = true;
						}
					}
				}
				if( $l == '#allowed_tags' ) $start_tagging = true;
			}
		}
	}

	/**
	 * @param $str
	 * @return bool
	 */
	private function allowedTag($str){
		return ( isset($this->allowed_tags[$str]) ) ? true : false;
	}
	
	/**
	 * @param $text
	 * @return string
	 */
	public function run($text){
		//remove " and < > to avoid XSS attacks
		$text = str_replace('"','&quote;',$text);
		$text = str_replace("<", "&lt;", $text);
		$text = str_replace(">", "&gt;", $text);

		$find = array();
		$replace = array();

		if( $this->allowedTag('a') ){
			$find[] = '~\[a\](.*?)\[/a\]~s';
			$replace[] = '<a href="$1">$1</a>';
		}

		if( $this->allowedTag('img') ){
			$find[] = '~\[img\](http(s)?://.*?\.(?:jpg|jpeg|gif|png))\[/img\]~s';
			$replace[] = '<img src="$1" />';
		}

		if( $this->allowedTag('b') ){
			$find[] = '~\[b\](.*?)\[/b\]~s';
			$replace[] = '<b>$1</b>';
		}

		if( $this->allowedTag('u') ){
			$find[] = '~\[u\](.*?)\[/u\]~s';
			$replace[] = '<u>$1</u>';
		}

		if( $this->allowedTag('strong') ){
			$find[] = '~\[strong\](.*?)\[/strong\]~s';
			$replace[] = '<strong>$1</strong>';
		}

		if( $this->allowedTag('script') ){
			$find[] = '~\[script\](.*?)\[/script\]~s';
			$replace[] = '<script>$1</script>';
		}
		
		return preg_replace($find,$replace,$text);
	}

}
