<?php

/**
 * The utility functionality of the plugin.
 *
 * @link       https://www.lyra-network.com
 * @since      1.0.0
 *
 * @package    Wp_Attachment_Filter
 * @subpackage Wp_Attachment_Filter/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Attachment_Filter
 * @subpackage Wp_Attachment_Filter/public
 * @author     LYRA NETWORK <david.fieffe@lyra-network.com>
 */


class WpAttachmentFilterUtilities
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;
    const FORMAT_JPG = 'jpg';
    const FORMAT_PNG = 'png';

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string $plugin_name The name of the plugin.
     * @param      string $version The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }


    /**
     * add_loading_bar
     */
    public function add_loading_bar(){

        $output = '<div id="general-loader" class="loader"><div id="seconds" class="seconds"><div id="loading-bar"></div></div></div>';
        echo $output;

    }

    /**
     * display_custom_quickedit_attachment
     *
     * @param $column_name
     * @param $post_type
     */
    public function display_custom_quickedit_attachment( $column_name, $post_type ) {
        static $printNonce = TRUE;
        /*
        if ( $printNonce ) {
            $printNonce = FALSE;
            wp_nonce_field( plugin_basename( __FILE__ ), 'attachment_edit_nonce' );
        }*/

        ?>
        <fieldset class="inline-edit-col-right inline-edit-attachment">
            <div class="inline-edit-col column-<?php echo $column_name; ?>">
                <label class="inline-edit-group">
                    <?php
                    switch ( $column_name ) {
                        case 'Language':
                            ?><span class="title">Language</span><input name="book_author" /><?php
                            break;
                        case 'inprint':
                            ?><span class="title">In Print</span><input name="inprint" type="checkbox" /><?php
                            break;
                    }
                    ?>
                </label>
            </div>
        </fieldset>
        <?php
    }


    public function manage_wp_posts_be_qe_manage_posts_columns( $columns, $post_type ) {
        /**
         * The first example adds our new columns at the end.
         * Notice that we're specifying a post type because our function covers ALL post types.
         *
         * Uncomment this code if you want to add your column at the end
         */
        if ( $post_type == 'attachments' ) {
            $columns[ 'release_date' ] = 'Release Date';
            $columns[ 'coming_soon' ] = 'Coming Soon';
            $columns[ 'film_rating' ] = 'Film Rating';
        }
            
        return $columns;
    }
    
    /**
     * extract
     * Imagick function to extract pdf cover
     *
     * @param string $source      source filepath
     * @param string $destination destination filepath
     * @param string $format      destination format
     *
     * @return bool
     */
    public static function extract($source, $destination, $format = self::FORMAT_JPG)
    {
        if (!extension_loaded('Imagick')) {
            return false;
        }
        $imagick = new \Imagick($source . '[0]');
        $imagick->setFormat($format);
        return $imagick->writeImage($destination);
    }


    /**
     * get_icon_for_attachment
     * add icon to files by mime type
     * @param $post_id
     * @return string
     */
    public function get_icon_for_attachment($post_id) {

        $type = get_post_mime_type($post_id);

        switch ($type) {
            case 'image/jpeg':
            case 'image/png':
            case 'image/gif':
                return '<img class="ico" src="'.get_wp_attachment_filter_plugin_uri().'/public/img/picture.svg"/>';
                break;
            case 'image/x-icon':
                return '<img class="ico" src="'.get_wp_attachment_filter_plugin_uri().'/public/img/ico.svg"/>';
                break;
            case 'video/mpeg':
            case 'video/mp4':
            case 'video/quicktime':
                return '<img class="ico" src="'.get_wp_attachment_filter_plugin_uri().'/public/img/video-camera.svg"/>';
                break;
            case 'image/vnd.adobe.photoshop':
            case 'image/vnd.adobe.illustrator':
                return '<img class="ico" src="'.get_wp_attachment_filter_plugin_uri().'/public/img/ppt.svg"/>';
                break;
            case 'application/pdf':
                return '<img class="ico" src="'.get_wp_attachment_filter_plugin_uri().'/public/img/pdf-file-format-symbol.svg"/>';
                break;
            case 'application/powerpoint':
            case 'application/mspowerpoint':
            case 'application/x-mspowerpoint':
            case 'application/vnd.ms-powerpoint':
                return '<img class="ico" src="'.get_wp_attachment_filter_plugin_uri().'/public/img/ppt.svg"/>';
                break;
            case 'application/msword':
                return '<img class="ico" src="'.get_wp_attachment_filter_plugin_uri().'/public/img/word.svg"/>';
                break;
            case 'application/excel':
            case 'application/x-excel':
                return '<img class="ico" src="'.get_wp_attachment_filter_plugin_uri().'/public/img/excel.svg"/>';
                break;
            case 'application/zip':
            case 'application/x-compressed':
                return '<img class="ico" src="'.get_wp_attachment_filter_plugin_uri().'/public/img/zip.svg"/>';
                break;
            case 'text/csv':
            case 'text/plain':
            case 'text/xml':
                return '<img class="ico" src="'.get_wp_attachment_filter_plugin_uri().'/public/img/text-document.svg"/>';
                break;
            default:
                return '<img class="ico" src="'.get_wp_attachment_filter_plugin_uri().'/public/img/ppt.svg"/>';
        }
    }
    
    
    /**
     * get_ext
     * detect uploaded file type
     * 
     * @param $mime_type
     * @return int|string
     */
    public function get_ext($mime_type){
        $extensions = array(
            'hqx'	=>	array('application/mac-binhex40', 'application/mac-binhex', 'application/x-binhex40', 'application/x-mac-binhex40'),
            'cpt'	=>	'application/mac-compactpro',
            'csv'	=>	array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain'),
            'bin'	=>	array('application/macbinary', 'application/mac-binary', 'application/octet-stream', 'application/x-binary', 'application/x-macbinary'),
            'dms'	=>	'application/octet-stream',
            'lha'	=>	'application/octet-stream',
            'lzh'	=>	'application/octet-stream',
            'exe'	=>	array('application/octet-stream', 'application/x-msdownload'),
            'class'	=>	'application/octet-stream',
            'psd'	=>	array('application/x-photoshop', 'image/vnd.adobe.photoshop'),
            'so'	=>	'application/octet-stream',
            'sea'	=>	'application/octet-stream',
            'dll'	=>	'application/octet-stream',
            'oda'	=>	'application/oda',
            'pdf'	=>	array('application/pdf', 'application/force-download', 'application/x-download', 'binary/octet-stream'),
            'ai'	=>	array('application/pdf', 'application/postscript'),
            'eps'	=>	'application/postscript',
            'ps'	=>	'application/postscript',
            'smi'	=>	'application/smil',
            'smil'	=>	'application/smil',
            'mif'	=>	'application/vnd.mif',
            'xls'	=>	array('application/vnd.ms-excel', 'application/msexcel', 'application/x-msexcel', 'application/x-ms-excel', 'application/x-excel', 'application/x-dos_ms_excel', 'application/xls', 'application/x-xls', 'application/excel', 'application/download', 'application/vnd.ms-office', 'application/msword'),
            'ppt'	=>	array('application/powerpoint', 'application/vnd.ms-powerpoint', 'application/vnd.ms-office', 'application/msword'),
            'pptx'	=> 	array('application/vnd.openxmlformats-officedocument.presentationml.presentation', 'application/x-zip', 'application/zip'),
            'wbxml'	=>	'application/wbxml',
            'wmlc'	=>	'application/wmlc',
            'dcr'	=>	'application/x-director',
            'dir'	=>	'application/x-director',
            'dxr'	=>	'application/x-director',
            'dvi'	=>	'application/x-dvi',
            'gtar'	=>	'application/x-gtar',
            'gz'	=>	'application/x-gzip',
            'gzip'  =>	'application/x-gzip',
            'php'	=>	array('application/x-httpd-php', 'application/php', 'application/x-php', 'text/php', 'text/x-php', 'application/x-httpd-php-source'),
            'php4'	=>	'application/x-httpd-php',
            'php3'	=>	'application/x-httpd-php',
            'phtml'	=>	'application/x-httpd-php',
            'phps'	=>	'application/x-httpd-php-source',
            'js'	=>	array('application/x-javascript', 'text/plain'),
            'swf'	=>	'application/x-shockwave-flash',
            'sit'	=>	'application/x-stuffit',
            'tar'	=>	'application/x-tar',
            'tgz'	=>	array('application/x-tar', 'application/x-gzip-compressed'),
            'z'	=>	'application/x-compress',
            'xhtml'	=>	'application/xhtml+xml',
            'xht'	=>	'application/xhtml+xml',
            'zip'	=>	array('application/x-zip', 'application/zip', 'application/x-zip-compressed', 'application/s-compressed', 'multipart/x-zip'),
            'rar'	=>	array('application/x-rar', 'application/rar', 'application/x-rar-compressed'),
            'mid'	=>	'audio/midi',
            'midi'	=>	'audio/midi',
            'mpga'	=>	'audio/mpeg',
            'mp2'	=>	'audio/mpeg',
            'mp3'	=>	array('audio/mpeg', 'audio/mpg', 'audio/mpeg3', 'audio/mp3'),
            'aif'	=>	array('audio/x-aiff', 'audio/aiff'),
            'aiff'	=>	array('audio/x-aiff', 'audio/aiff'),
            'aifc'	=>	'audio/x-aiff',
            'ram'	=>	'audio/x-pn-realaudio',
            'rm'	=>	'audio/x-pn-realaudio',
            'rpm'	=>	'audio/x-pn-realaudio-plugin',
            'ra'	=>	'audio/x-realaudio',
            'rv'	=>	'video/vnd.rn-realvideo',
            'wav'	=>	array('audio/x-wav', 'audio/wave', 'audio/wav'),
            'bmp'	=>	array('image/bmp', 'image/x-bmp', 'image/x-bitmap', 'image/x-xbitmap', 'image/x-win-bitmap', 'image/x-windows-bmp', 'image/ms-bmp', 'image/x-ms-bmp', 'application/bmp', 'application/x-bmp', 'application/x-win-bitmap'),
            'gif'	=>	'image/gif',
            'jpeg'	=>	array('image/jpeg', 'image/pjpeg'),
            'jpg'	=>	array('image/jpeg', 'image/pjpeg'),
            'jp2'	=>	array('image/jp2', 'video/mj2', 'image/jpx', 'image/jpm'),
            'j2k'	=>	array('image/jp2', 'video/mj2', 'image/jpx', 'image/jpm'),
            'jpf'	=>	array('image/jp2', 'video/mj2', 'image/jpx', 'image/jpm'),
            'jpg2'	=>	array('image/jp2', 'video/mj2', 'image/jpx', 'image/jpm'),
            'jpx'	=>	array('image/jp2', 'video/mj2', 'image/jpx', 'image/jpm'),
            'jpm'	=>	array('image/jp2', 'video/mj2', 'image/jpx', 'image/jpm'),
            'mj2'	=>	array('image/jp2', 'video/mj2', 'image/jpx', 'image/jpm'),
            'mjp2'	=>	array('image/jp2', 'video/mj2', 'image/jpx', 'image/jpm'),
            'png'	=>	array('image/png',  'image/x-png'),
            'tiff'	=>	'image/tiff',
            'tif'	=>	'image/tiff',
            'css'	=>	array('text/css', 'text/plain'),
            'html'	=>	array('text/html', 'text/plain'),
            'htm'	=>	array('text/html', 'text/plain'),
            'shtml'	=>	array('text/html', 'text/plain'),
            'txt'	=>	'text/plain',
            'text'	=>	'text/plain',
            'log'	=>	array('text/plain', 'text/x-log'),
            'rtx'	=>	'text/richtext',
            'rtf'	=>	'text/rtf',
            'xml'	=>	array('application/xml', 'text/xml', 'text/plain'),
            'xsl'	=>	array('application/xml', 'text/xsl', 'text/xml'),
            'mpeg'	=>	'video/mpeg',
            'mpg'	=>	'video/mpeg',
            'mpe'	=>	'video/mpeg',
            'qt'	=>	'video/quicktime',
            'mov'	=>	'video/quicktime',
            'avi'	=>	array('video/x-msvideo', 'video/msvideo', 'video/avi', 'application/x-troff-msvideo'),
            'movie'	=>	'video/x-sgi-movie',
            'doc'	=>	array('application/msword', 'application/vnd.ms-office'),
            'docx'	=>	array('application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/zip', 'application/msword', 'application/x-zip'),
            'dot'	=>	array('application/msword', 'application/vnd.ms-office'),
            'dotx'	=>	array('application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/zip', 'application/msword'),
            'xlsx'	=>	array('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/zip', 'application/vnd.ms-excel', 'application/msword', 'application/x-zip'),
            'word'	=>	array('application/msword', 'application/octet-stream'),
            'word template' => array('application/vnd.openxmlformats-officedocument.wordprocessingml.template'),
            'xl'	=>	'application/excel',
            'eml'	=>	'message/rfc822',
            'json'  =>	array('application/json', 'text/json'),
            'pem'   =>	array('application/x-x509-user-cert', 'application/x-pem-file', 'application/octet-stream'),
            'p10'   =>	array('application/x-pkcs10', 'application/pkcs10'),
            'p12'   =>	'application/x-pkcs12',
            'p7a'   =>	'application/x-pkcs7-signature',
            'p7c'   =>	array('application/pkcs7-mime', 'application/x-pkcs7-mime'),
            'p7m'   =>	array('application/pkcs7-mime', 'application/x-pkcs7-mime'),
            'p7r'   =>	'application/x-pkcs7-certreqresp',
            'p7s'   =>	'application/pkcs7-signature',
            'crt'   =>	array('application/x-x509-ca-cert', 'application/x-x509-user-cert', 'application/pkix-cert'),
            'crl'   =>	array('application/pkix-crl', 'application/pkcs-crl'),
            'der'   =>	'application/x-x509-ca-cert',
            'kdb'   =>	'application/octet-stream',
            'pgp'   =>	'application/pgp',
            'gpg'   =>	'application/gpg-keys',
            'sst'   =>	'application/octet-stream',
            'csr'   =>	'application/octet-stream',
            'rsa'   =>	'application/x-pkcs7',
            'cer'   =>	array('application/pkix-cert', 'application/x-x509-ca-cert'),
            '3g2'   =>	'video/3gpp2',
            '3gp'   =>	array('video/3gp', 'video/3gpp'),
            'mp4'   =>	'video/mp4',
            'm4a'   =>	'audio/x-m4a',
            'f4v'   =>	array('video/mp4', 'video/x-f4v'),
            'flv'	=>	'video/x-flv',
            'webm'	=>	'video/webm',
            'aac'   =>	'audio/x-acc',
            'm4u'   =>	'application/vnd.mpegurl',
            'm3u'   =>	'text/plain',
            'xspf'  =>	'application/xspf+xml',
            'vlc'   =>	'application/videolan',
            'wmv'   =>	array('video/x-ms-wmv', 'video/x-ms-asf'),
            'au'    =>	'audio/x-au',
            'ac3'   =>	'audio/ac3',
            'flac'  =>	'audio/x-flac',
            'ogg'   =>	array('audio/ogg', 'video/ogg', 'application/ogg'),
            'kmz'	=>	array('application/vnd.google-earth.kmz', 'application/zip', 'application/x-zip'),
            'kml'	=>	array('application/vnd.google-earth.kml+xml', 'application/xml', 'text/xml'),
            'ics'	=>	'text/calendar',
            'ical'	=>	'text/calendar',
            'zsh'	=>	'text/x-scriptzsh',
            '7zip'	=>	array('application/x-compressed', 'application/x-zip-compressed', 'application/zip', 'multipart/x-zip'),
            'cdr'	=>	array('application/cdr', 'application/coreldraw', 'application/x-cdr', 'application/x-coreldraw', 'image/cdr', 'image/x-cdr', 'zz-application/zz-winassoc-cdr'),
            'wma'	=>	array('audio/x-ms-wma', 'video/x-ms-asf'),
            'jar'	=>	array('application/java-archive', 'application/x-java-application', 'application/x-jar', 'application/x-compressed'),
            'svg'	=>	array('image/svg+xml', 'application/xml', 'text/xml'),
            'vcf'	=>	'text/x-vcard',
            'srt'	=>	array('text/srt', 'text/plain'),
            'vtt'	=>	array('text/vtt', 'text/plain'),
            'ico'	=>	array('image/x-icon', 'image/x-ico', 'image/vnd.microsoft.icon')
        );
        $extension_nice_name = '';
        foreach($extensions as $key => $extension)
        {
            if(is_array($extension)){
               if( in_array($mime_type,$extension )){
                   $extension_nice_name = $key;
               }

            } elseif ($extension == $mime_type) {
                $extension_nice_name = $key;
            }

        }

        if($extension_nice_name === ""){
            $extension_nice_name = $mime_type;
        }

        return $extension_nice_name;
    }

    /**
     * get_pdf_uri
     * get attachment ID, fetch uri
     * return array json
     */
    public function get_pdf_uri() {
        $data = array();
        $attachmentID = (isset($_POST['pdfID'])) ? intval($_POST['pdfID']) : false;
        $pdf_url = ($attachmentID) ? wp_get_attachment_url( $attachmentID ) : 'not found';
        $plugin_uri_pdf = get_wp_attachment_filter_plugin_uri().'public/js/pdf/';

        array_push($data,$pdf_url );
        array_push($data,$plugin_uri_pdf );


       echo json_encode($data);

        wp_die(); // this is required to terminate immediately and return a proper response
    }
}