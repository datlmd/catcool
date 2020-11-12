<?php

class Image_tool extends CI_model
{
    public function __construct()
    {
        $this->load->library('image_lib');

        $this->dir_image_path = get_upload_path();
    }

    /**
     * resize tao hinh thumbnail, hinh goc van khong anh huong
     *
     * @param $filename
     * @param $width
     * @param $height
     * @return string|void
     */
    public function resize($filename, $width = null, $height = null)
    {
        $width = !empty($width) ? $width : (!empty(config_item('image_thumbnail_small_width')) ? config_item('image_thumbnail_small_width') : RESIZE_IMAGE_THUMB_WIDTH);
        $height = !empty($height) ? $height : (!empty(config_item('image_thumbnail_small_height')) ? config_item('image_thumbnail_small_height') : RESIZE_IMAGE_THUMB_HEIGHT);

        if (!is_file($this->dir_image_path . $filename) || substr(str_replace('\\', '/', realpath($this->dir_image_path . $filename)), 0, strlen($this->dir_image_path)) != $this->dir_image_path) {
            return;
        }

        $extension = pathinfo($filename, PATHINFO_EXTENSION);

        $image_old = $filename;
        $image_new = UPLOAD_FILE_CACHE_DIR . substr($filename, 0, strrpos($filename, '.')) . '-' . $width . 'x' . $height . '.' . $extension;

        if (is_file($this->dir_image_path . $image_new)) {
            $file_info_old = get_file_info($this->dir_image_path . $image_old);
            $file_info_new = get_file_info($this->dir_image_path . $image_new);

            if (isset($file_info_old['date']) && isset($file_info_new['date']) && $file_info_old['date'] > $file_info_new['date']) {
                delete_files(unlink($this->dir_image_path . $image_new));
            }
        }

        if (!is_file($this->dir_image_path . $image_new)) {
            $path = '';

            $directories = explode('/', dirname($image_new));

            foreach ($directories as $directory) {
                $path = $path . '/' . $directory;

                if (!is_dir($this->dir_image_path . $path)) {
                    @mkdir($this->dir_image_path . $path, 0777);
                }
            }

            $config = [
                'image_library'  => 'gd2',
                'source_image'   => $this->dir_image_path . $image_old,
                'new_image'      => $this->dir_image_path . $image_new,
                'create_thumb'   => FALSE,
                'maintain_ratio' => TRUE,
                'quality'        => !empty(config_item('image_quality')) ? config_item('image_quality') : 100,
                'width'          => $width,
                'height'         => $height,
            ];

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

        $config['image_library']  = 'gd2';
        $config['source_image']   = $this->dir_image_path . $filename;
        $config['rotation_angle'] = $angle;
        $config['quality']        = !empty(config_item('image_quality')) ? config_item('image_quality') : 100;

        $this->image_lib->clear();
        $this->image_lib->initialize($config);

        if (!$this->image_lib->rotate()) {
            error_log($this->image_lib->display_errors());
            return false;
        }

        return $this->resize($filename);
    }
    
    public function crop($filename, $width, $height, $x_axis, $y_axis, $is_new = false)
    {
        $image_root = $filename;
        if (!is_file($this->dir_image_path . $filename)) {
            return false;
        }
        $source_img = $this->dir_image_path . $filename;

        $config = [
            'image_library'  => 'gd2',
            'source_image'   => $source_img,
            'new_image'      => $source_img,
            'quality'        => !empty(config_item('image_quality')) ? config_item('image_quality') : 100,
            'maintain_ratio' => FALSE,
            'width'          => $width,
            'height'         => $height,
            'x_axis'         => $x_axis,
            'y_axis'         => $y_axis,
        ];

        $this->image_lib->clear();
        $this->image_lib->initialize($config);

        if (!$this->image_lib->crop()) {
            error_log($this->image_lib->display_errors());
            return false;
        }

        return $image_root;
    }
}
