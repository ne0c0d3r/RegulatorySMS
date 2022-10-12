<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Mod_upload extends CI_Model{

	public function do_upload($userfile, $module = 'ticketAttach'){
		//var_dump($userfile);

		$this->load->model('Mod_ticket');
		if (!empty($_FILES['attachField'])) {

			$total = count($_FILES['attachField']['name']);

			$isUploadAll = true;
			for ($i=0; $i < $total; $i++) { 
				//$fileName = (isset($userfile['nameInput'][$i]))? $userfile['nameInput'][$i] : $_FILES['attachField']['tmp_name'][$i];
				$fileName = $_FILES['attachField']['name'][$i];
				$tmpName  = $_FILES['attachField']['tmp_name'][$i];
				$fileSize = $_FILES['attachField']['size'][$i];
				$fileType = $_FILES['attachField']['type'][$i];
				$fp      = fopen($tmpName, 'r');
				$content = fread($fp, filesize($tmpName));
				$content = addslashes($content);
				fclose($fp);
				if(!get_magic_quotes_gpc())
				{
				    $fileName = addslashes($fileName);
				}

				$temp = explode(".", $_FILES["attachField"]["name"][$i]);
				$hashFilename = round(microtime(true)) . md5($fileName) . '.' . end($temp);

				$uploaddir =  'resources/uploads/';
				$uploadfile = $uploaddir . $hashFilename;

				$isUploaded = move_uploaded_file($_FILES['attachField']['tmp_name'][$i], $uploadfile);

				if ($isUploaded) {
					$isInsert = $this->Mod_ticket->addInsertAttachFile($fileName, $hashFilename, $module, $userfile);
					if (!$isInsert) {
						$isUploadAll = false;
					}
				}

			}
			$this->session->unset_userdata('ticketid');
			return $isUploadAll; // array('return' => $isUploadAll)
		}
		return true;

  }

  public function creatThumbnail($imageName){
  	$src = "resources/uploaded/" . $imageName;
		$image = imagecreatefromstring(file_get_contents($src));
		$filename = "resources/thumbnails/" . $imageName;

		$thumb_width = 200;
		$thumb_height = 150;

		$width = imagesx($image);
		$height = imagesy($image);

		$original_aspect = $width / $height;
		$thumb_aspect = $thumb_width / $thumb_height;

		if ( $original_aspect >= $thumb_aspect )
		{
		   // If image is wider than thumbnail (in aspect ratio sense)
		   $new_height = $thumb_height;
		   $new_width = $width / ($height / $thumb_height);
		}
		else
		{
		   // If the thumbnail is wider than the image
		   $new_width = $thumb_width;
		   $new_height = $height / ($width / $thumb_width);
		}

		$thumb = imagecreatetruecolor( $thumb_width, $thumb_height );

		// Resize and crop
		imagecopyresampled($thumb,
		                   $image,
		                   0 - ($new_width - $thumb_width) / 2, // Center the image horizontally
		                   0 - ($new_height - $thumb_height) / 2, // Center the image vertically
		                   0, 0,
		                   $new_width, $new_height,
		                   $width, $height);
		imagejpeg($thumb, $filename, 80);
  }

}