<?php

if (!function_exists('json_decode'))
{
  function json_decode($content, $assoc = false)
   {
     require_once dirname(__FILE__) . '/../classes/JSON.php';
     if ($assoc)
     {
      $json = new Services_JSON(SERVICES_JSON_LOOSE_TYPE);
     }
     else
     {
       $json = new Services_JSON;
     }
     return $json->decode($content);
    }

}

if (!function_exists('json_encode'))
{

    function json_encode($content)
    {
        require_once dirname(__FILE__) . '/../classes/JSON.php';
        $json = new Services_JSON;
        return $json->encode($content);
    }

}



if (!function_exists("isPictureCust"))
{

    function isPictureCust($file, $types = NULL)
    {
        /* Detect mime content type */
        $mimeType = false;
        if (!$types)
            $types = array('image/gif', 'image/jpg', 'image/jpeg', 'image/pjpeg', 'image/png', 'image/x-png');
        /* Try 4 different methods to determine the mime type */
        if (function_exists('finfo_open'))
        {
            $const = defined('FILEINFO_MIME_TYPE') ? FILEINFO_MIME_TYPE : FILEINFO_MIME;
            $finfo = finfo_open($const);
            $mimeType = finfo_file($finfo, $file['tmp_name']);
            finfo_close($finfo);
        } elseif (function_exists('mime_content_type'))
            $mimeType = mime_content_type($file['tmp_name']);
        elseif (function_exists('exec'))
        {
            $mimeType = trim(exec('file -b --mime-type ' . escapeshellarg($file['tmp_name'])));
            if (!$mimeType)
                $mimeType = trim(exec('file --mime ' . escapeshellarg($file['tmp_name'])));
            if (!$mimeType)
                $mimeType = trim(exec('file -bi ' . escapeshellarg($file['tmp_name'])));
        }
        if (empty($mimeType) OR $mimeType == 'regular file' OR $mimeType == 'text/plain')
            $mimeType = $file['type'];

        /* For each allowed MIME type, we are looking for it inside the current MIME type */

        foreach ($types AS $type)
            if (strstr($mimeType, $type))
                return true;

        return false;
    }

}
if (!function_exists("isPictureOnTheZip"))
{

    function isPictureOnTheZip($file, $types = NULL)
    {
        /* Detect mime content type */
        $mimeType = false;
        if (!$types)
            $types = array('image/gif', 'image/jpg', 'image/jpeg', 'image/pjpeg', 'image/png', 'image/x-png');

        /* Try 4 different methods to determine the mime type */
        if (function_exists('finfo_open'))
        {
            $const = defined('FILEINFO_MIME_TYPE') ? FILEINFO_MIME_TYPE : FILEINFO_MIME;
            $finfo = finfo_open($const);
            $mimeType = finfo_file($finfo, $file);
            finfo_close($finfo);
        } elseif (function_exists('mime_content_type'))
            $mimeType = mime_content_type($file);
        elseif (function_exists('exec'))
        {
            $mimeType = trim(exec('file -b --mime-type ' . escapeshellarg($file)));
            if (!$mimeType)
                $mimeType = trim(exec('file --mime ' . escapeshellarg($file)));
            if (!$mimeType)
                $mimeType = trim(exec('file -bi ' . escapeshellarg($file)));
        }


        foreach ($types AS $type)
            if (strstr($mimeType, $type))
                return true;

        return false;
    }

}



if (!function_exists("imageResizeCust"))
{

    function imageResizeCust($sourceFile, $destFile, $destWidth = NULL, $destHeight = NULL, $fileType = 'jpg', $r, $v, $b)
    {
        list($sourceWidth, $sourceHeight, $type, $attr) = getimagesize($sourceFile);
        if (!$sourceWidth)
            return false;
        if ($destWidth == NULL)
            $destWidth = $sourceWidth;
        if ($destHeight == NULL)
            $destHeight = $sourceHeight;

        $sourceImage = createSrcImageCust($type, $sourceFile);

        $widthDiff = $destWidth / $sourceWidth;
        $heightDiff = $destHeight / $sourceHeight;

        if ($widthDiff > 1 AND $heightDiff > 1)
        {
            $nextWidth = $sourceWidth;
            $nextHeight = $sourceHeight;
        } else
        {
            if (Configuration::get('PS_IMAGE_GENERATION_METHOD') == 2 OR (!Configuration::get('PS_IMAGE_GENERATION_METHOD') AND $widthDiff > $heightDiff))
            {
                $nextHeight = $destHeight;
                $nextWidth = round(($sourceWidth * $nextHeight) / $sourceHeight);
                $destWidth = (int) (!Configuration::get('PS_IMAGE_GENERATION_METHOD') ? $destWidth : $nextWidth);
            } else
            {
                $nextWidth = $destWidth;
                $nextHeight = round($sourceHeight * $destWidth / $sourceWidth);
                $destHeight = (int) (!Configuration::get('PS_IMAGE_GENERATION_METHOD') ? $destHeight : $nextHeight);
            }
        }

        $destImage = imagecreatetruecolor($destWidth, $destHeight);

        $white = imagecolorallocate($destImage, $r, $v, $b);
        imagefilledrectangle($destImage, 0, 0, $destWidth, $destHeight, $white);

        imagecopyresampled($destImage, $sourceImage, (int) (($destWidth - $nextWidth) / 2), (int) (($destHeight - $nextHeight) / 2), 0, 0, $nextWidth, $nextHeight, $sourceWidth, $sourceHeight);
        imagecolortransparent($destImage, $white);
        return (returnDestImageCust($fileType, $destImage, $destFile));
    }

}


if (!function_exists("createSrcImageCust"))
{

    function createSrcImageCust($type, $filename)
    {
        switch ($type)
        {
            case 1:
                return imagecreatefromgif($filename);
                break;
            case 3:
                return imagecreatefrompng($filename);
                break;
            case 2:
            default:
                return imagecreatefromjpeg($filename);
                break;
        }
    }

}


if (!function_exists("createDestImageCust"))
{

    function createDestImageCust($width, $height)
    {
        $image = imagecreatetruecolor($width, $height);
        $white = imagecolorallocate($image, 255, 255, 255);
        imagefill($image, 0, 0, $white);
        return $image;
    }

}

if (!function_exists("returnDestImageCust"))
{

    function returnDestImageCust($type, $ressource, $filename)
    {
        $flag = false;
        switch ($type)
        {
            case 'gif':
                $flag = imagegif($ressource, $filename);
                break;
            case 'png':
                $flag = imagepng($ressource, $filename, 7);
                break;
            case 'jpeg':
            default:
                $flag = imagejpeg($ressource, $filename, 90);
                break;
        }
        imagedestroy($ressource);
        @chmod($filename, 0664);
        return $flag;
    }

}
?>