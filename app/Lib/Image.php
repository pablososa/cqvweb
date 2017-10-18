<?php

/* TOOLSET BOX */

class Image {

    public static function cropResize($src_path, $dest_path, $dest_width, $dest_height) {
        list($src_width, $src_height) = getimagesize($src_path);

        $src_prop = $src_width / $src_height;
        $dest_prop = $dest_width / $dest_height;

        if ($src_prop > $dest_prop) {
            $tmp_height = $src_height;
            $tmp_width = $tmp_height * $dest_prop;

            $tmp_x = ($src_width - $tmp_width) / 2;
            $tmp_y = 0;
        } else {
            $tmp_width = $src_width;
            $tmp_height = $tmp_width / $dest_prop;

            $tmp_x = 0;
            $tmp_y = ($src_height - $tmp_height) / 2;
        }

        $src_image = Image::createImage($src_path);
        $dst_image = imagecreatetruecolor($dest_width, $dest_height);

        $result = imagecopyresampled($dst_image, $src_image, 0, 0, $tmp_x, $tmp_y, $dest_width, $dest_height, $tmp_width, $tmp_height);

        $return_tmp = false;
        if ($result) {
            if (empty($dest_path)) {
                $dest_path = tempnam(sys_get_temp_dir(), '__file.');
                $return_tmp = true;
            }
            $result &= imagepng($dst_image, $dest_path, 7); // 0 malo 9 bueno
        }
        if ($result && $return_tmp) {
            $result = file_get_contents($dest_path);
            unlink($dest_path);
        }
        return $result;
    }

    public static function createImage($src_path) {
        switch (mime_content_type($src_path)) {
            case 'image/png':
                $src_image = imagecreatefrompng($src_path);
                break;
            case 'image/gif':
                $src_image = imagecreatefromgif($src_path);
                break;
            case 'image/jpeg':
            case 'image/pjpeg':
            default:
                $src_image = imagecreatefromjpeg($src_path);
                break;
        }
        return $src_image;
    }

    public static function checkMimeType($mimeType) {
        $valid_mimeTypes = array(
            'image/jpeg',
            'image/pjpeg',
            'image/png',
            'image/gif',
        );
        return in_array($mimeType, $valid_mimeTypes);
    }

    public static function getPersp($path, $persp) {
        $src_image = Image::createImage($path);
        $back = array(
            0, 0,
            399, 0,
            399, 20,
        );
        imageantialias($src_image, true);
        $bg = imagecolorallocatealpha($src_image, 0, 250, 0, 80);
        $bg = imagecolorallocate($src_image, 0, 250, 0);
        imagefilledpolygon($src_image, $back, 3, $bg);
        imagecolortransparent($src_image, $bg);

        imagepng($src_image);
        die;
        return imagepng($src_image);
    }

    public static function getVehiculoThumb($nro_registro, $estado) {
        $path = APP . 'webroot' . DS . 'img' . DS . 'vehiculo_' . $estado . '.png';
        $image = Image::createImage($path);
        imageAlphaBlending($image, true);
        imageSaveAlpha($image, true);
        $text_color = imagecolorallocate($image, 0, 0, 0);
        $font_size = 5;
        $nro_registro = trim($nro_registro);
        $textWidth = imagefontwidth( $font_size ) * strlen($nro_registro);
        $xLoc = 1 + (30 - $textWidth ) / 2;
        imagestring($image, $font_size, $xLoc, 7, $nro_registro, $text_color);
        imagepng($image);
        imagedestroy($image);
        die;
    }

}
