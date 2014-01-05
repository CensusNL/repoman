<?php
/**
 *
 *
 */
class modTemplateVar_parser extends Repoman_parser {

    public $dir_key = 'tvs_dir';
	public $ext = '*.*';
    public $write_ext = '.tv';	
    public $objecttype = 'modTemplateVar';

	public $dox_start = '<!--';
	public $dox_end = '-->';
    public $dox_pad = ''; // left of line before the @attribute	
	
	/**
	 * Special behavior here for HTML doc blocks.
	 */
	public function prepare_for_pkg($string) {
		// Strip out docblock entirely (i.e. the first comment)
		$string = preg_replace('#('.preg_quote($this->dox_start).')(.*)('.preg_quote($this->dox_end).')#Uis', '', $string,1);
		 
		// Strip out any additional areas
		return parent::prepare_for_pkg($string);	
	}
}
/*EOF*/