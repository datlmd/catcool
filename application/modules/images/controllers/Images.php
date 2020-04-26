<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Images extends My_Controller
{
    private $_image_path = '';
    private $_image_url  = '';

    public function __construct()
    {
        parent::__construct();

        $this->load->helper('file');

        $this->_image_path = get_upload_path();
        $this->_image_url  = get_upload_url();
    }

    public function index()
    {
        $image_url = $this->input->get("c");

        $width  = (is_mobile()) ? config_item('image_width_mobile') : config_item('image_width_pc');
        $height = (is_mobile()) ? config_item('image_height_mobile') : config_item('image_height_pc');

        $computedImage = image_thumb_url($image_url, $width, $height);

        $this->output->set_content_type(get_mime_by_extension($computedImage))->set_output(file_get_contents($computedImage));
    }

    public function alt($wh = null, $background = null, $foreground = null)
    {
        $params = [];
        if (empty($wh)) {
            $params['width']  = 300;
            $params['height'] = 230;
        } else {
            $wh_tmp = explode("x", strtolower($wh));
            $params['width']  = $wh_tmp[0];
            $params['height'] = isset($wh_tmp[1]) ? $wh_tmp[1] : $wh_tmp[0];
        }

        $params['height']     = (empty($params['height'])) ? $params['width'] : $params['height'];
        $params['text']       = (empty($this->input->get("text", true))) ? $params['width'].' x '. $params['height'] : $this->input->get("text", true);
        $params['background'] = (empty($background)) ? 'CCCCCC' : $background;
        $params['foreground'] = (empty($foreground)) ? '969696' : $foreground;

        $alt_url = 'http://placehold.it/'. $params['width'].'x'. $params['height'].'/'.$params['background'].'/'.$params['foreground'].'?text='. $params['text'];

        $this->output->set_content_type(get_mime_by_extension($alt_url))->set_output(file_get_contents($alt_url));
    }
}
