<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Images extends My_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $computedImage = base_url('media/uploads/files/IMG_4762.JPG');
        $this->load->helper('file');
        $this->output->set_content_type(get_mime_by_extension($computedImage))->set_output(file_get_contents($computedImage));
    }
}
