<?php
/**
 * @package    HaruTheme/Haru TeeSpace
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright 2022, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

if ( ! class_exists( 'Haru_SCSSPHP_Theme_Helper' ) ) {
    class Haru_SCSSPHP_Theme_Helper {
        static $instance;

        public function __construct() {
            $this->haru_teespace_includes_files();
        }

        public function haru_teespace_includes_files() {
            require_once( HARU_TEESPACE_CORE_DIR . 'includes/scss/scss-functions.php' );
        }
    }

    $haru_scssphp = new Haru_SCSSPHP_Theme_Helper;
}