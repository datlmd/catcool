<?php

class Image_tool extends CI_model
{


    public function __construct()
    {
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


//		if (!is_file($this->dir_image_path . $image_new) || (filectime($this->dir_image_path . $image_old) > filectime($this->dir_image_path . $image_new))) {
//			list($width_orig, $height_orig, $image_type) = getimagesize($this->dir_image_path . $image_old);
//
//			if (!in_array($image_type, array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF))) {
//				return $this->dir_image_path . $image_old;
//			}
//
//			$path = '';
//
//			$directories = explode('/', dirname($image_new));
//
//			foreach ($directories as $directory) {
//				$path = $path . '/' . $directory;
//
//				if (!is_dir($this->dir_image_path . $path)) {
//					@mkdir($this->dir_image_path . $path, 0777);
//				}
//			}
//
//			if ($width_orig != $width || $height_orig != $height) {
//				$image = new Image($this->dir_image_path . $image_new);
//				$image->resize($this->dir_image_path . $image_new, $width, $height);
//				//$image->save($this->dir_image_path . $image_new);
//			} else {
//				copy($this->dir_image_path . $image_old, $this->dir_image_path . $image_new);
//			}
//		}

		return $image_new;
	}
}
