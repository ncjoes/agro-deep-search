<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (phoenixlabs.ng@gmail.com)
 * Project: PoliceBlackMarket
 * Date:    12/13/2015
 * Time:    7:12 AM
 **/

namespace System\Utilities;

/**
 * Takes file index in $_FILES super-global and returns an Upload object
  ASSUMPTIONS
 * Max upload size is 50 MB i.e max upload size for most Apache servers
 */
class UploadHandler
{
    private $file_name;
    private $file_size;
    private $file_location;
    private $file_type;
    private $file_extension;
    private $temp_name;
    private $file_status = false;
    private $upload_status = false;
    private $status_message;
    private $upload_directory = "Uploads";
    private $allowed_extensions;
    private $output_file_name;
    private $max_upload_size;

    public function __construct($input_name, $output_name)
    {
        $this->max_upload_size = (ini_get('post_max_size') * 1024 * 1024) - 1024;
        if ($_FILES[$input_name]["error"] == UPLOAD_ERR_OK)
        {
            $this->file_name = $_FILES[$input_name]['name'];
            $this->file_size = $_FILES[$input_name]['size'];
            $this->temp_name = $_FILES[$input_name]['tmp_name'];
            $this->file_type = $_FILES[$input_name]['type'];
            $var = explode('.', $this->file_name);
            $this->file_extension = strtolower($var[sizeof($var) - 1]);
            $this->output_file_name = $output_name;
            $this->file_status = true;
        }
    }

    public function doUpload()
    {
        if ( !($this->file_size <= $this->getMaxUploadSize()))
        {
            $this->status_message = "File is too large: {$this->file_size}. Max size allowed: {$this->getMaxUploadSize()}";
        }
        elseif ( !is_array($this->allowed_extensions) or !in_array($this->file_extension, $this->allowed_extensions))
        {
            $this->status_message = "Unsupported file extension: {$this->file_extension}";
            if(is_array($this->allowed_extensions))
            {
                $this->status_message .= "<br/>Allowed Extensions: ".implode(',', $this->allowed_extensions);
            }
        }
        else
        {
            if(!is_dir($this->upload_directory)) mkdir($this->upload_directory);
            $this->upload_status = move_uploaded_file($this->temp_name, $this->upload_directory.DIRECTORY_SEPARATOR.$this->output_file_name.'.'.$this->file_extension);
            return $this->upload_status;
        }
    }

    public function getMaxUploadSize()
    {
        return $this->max_upload_size;
    }

    public function setMaxUploadSize($size_MB)
    {
        if(is_numeric($size_MB) and $size_MB>0) $this->max_upload_size = $size_MB * 1024 * 1024;
    }
    /**
     * @return string
     */
    public function getUploadDirectory()
    {
        return $this->upload_directory;
    }

    /**
     * @param string $upload_directory
     * @return UploadHandler
     */
    public function setUploadDirectory($upload_directory)
    {
        $this->upload_directory = $upload_directory;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFileName()
    {
        return $this->file_name;
    }

    /**
     * @return mixed
     */
    public function getFileSize()
    {
        return $this->file_size;
    }

    /**
     * @return mixed
     */
    public function getFileLocation()
    {
        return $this->file_location;
    }


    /**
     * @return mixed
     */
    public function getFileType()
    {
        return $this->file_type;
    }

    /**
     * @return mixed
     */
    public function getFileExtension()
    {
        return $this->file_extension;
    }

    /**
     * @return boolean
     */
    public function getFileStatus()
    {
        return $this->file_status;
    }

    /**
     * @return boolean
     */
    public function getUploadStatus()
    {
        return $this->upload_status;
    }

    /**
     * @return mixed
     */
    public function getStatusMessage()
    {
        return $this->status_message;
    }

    /**
     * @return mixed
     */
    public function getAllowedExtensions()
    {
        return $this->allowed_extensions;
    }

    /**
     * @param mixed $allowed_extensions
     * @return UploadHandler
     */
    public function setAllowedExtensions(array $allowed_extensions)
    {
        $this->allowed_extensions = $allowed_extensions;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOutputFileName()
    {
        return $this->output_file_name;
    }
}