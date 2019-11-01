<?php

class Image_tool extends CI_model
{
    public function __construct()
    {
        $this->load->library('image_lib');

        $this->dir_image_path = get_upload_path();
    }

    public function resize($filename, $width, $height)
    {
        if (!is_file($this->dir_image_path . $filename) || substr(str_replace('\\', '/', realpath($this->dir_image_path . $filename)), 0, strlen($this->dir_image_path)) != $this->dir_image_path) {
            return;
        }

        $extension = pathinfo($filename, PATHINFO_EXTENSION);

        $image_old = $filename;
        $image_new = 'cache/' . substr($filename, 0, strrpos($filename, '.')) . '-' . $width . '_' . $height . '.' . $extension;

        if (!is_file($this->dir_image_path . $image_new)) {
            $path = '';

            $directories = explode('/', dirname($image_new));

            foreach ($directories as $directory) {
                $path = $path . '/' . $directory;

                if (!is_dir($this->dir_image_path . $path)) {
                    @mkdir($this->dir_image_path . $path, 0777);
                }
            }

            $this->load->library('image_lib');

            $config['image_library']  = 'gd2';
            $config['source_image']   = $this->dir_image_path . $image_old;


            $config['new_image'] = $this->dir_image_path . $image_new;

            $config['create_thumb']   = FALSE;
            $config['maintain_ratio'] = TRUE;
            $config['width']          = $width;
            $config['height']         = $height;

            $this->image_lib->clear();
            $this->image_lib->initialize($config);
            $this->image_lib->resize();
        }

        return $image_new;
    }

    public function rotation($filename, $angle = '90')
    {
        if (!is_file($this->dir_image_path . $filename)) {
            return false;
        }

        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $image_new = 'cache/' . substr($filename, 0, strrpos($filename, '.')) . '-' . RESIZE_IMAGE_DEFAULT['width'] . '_' . RESIZE_IMAGE_DEFAULT['height'] . '.' . $extension;
        if (is_file($this->dir_image_path . $image_new)) {
            delete_files(unlink($this->dir_image_path . $image_new));
        }

        $config['image_library']  = 'gd2';
        $config['source_image']   = $this->dir_image_path . $filename;
        $config['rotation_angle'] = $angle;
        $config['quality']        = '100';

        $this->image_lib->clear();
        $this->image_lib->initialize($config);

        if ( ! $this->image_lib->rotate())
        {
            error_log($this->image_lib->display_errors());
            return false;
        }

        return $this->resize($filename, RESIZE_IMAGE_DEFAULT['width'], RESIZE_IMAGE_DEFAULT['height']);
    }
}
