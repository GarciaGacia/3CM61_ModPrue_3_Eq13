<?php

class Media {

 
  //public $imageInfo;
  //public $fileName;
  //public $fileType;
  //public $fileTempPath;
  private $imageInfo;
  private $fileName;
  private $fileType;
  private $fileTempPath;

  public $errors = array();
 	
	# Spanish.-
  public $upload_errors = array(
    0 => 'Sin error, el archivo se subió con éxito',
    1 => 'El tamaño de archivo excede la directiva upload_max_filesize en php.ini',
    2 => 'El tamaño de archivo excede la directiva MAX_FILE_SIZE especificada en el formulario HTML',
    3 => 'El archivo fue subido parcialmente',
    4 => 'No seleccionó el archivo',
    5 => 'No se ha definido la ruta para guardar el archivo',
    6 => 'Se perdió una carpeta temporal',
    7 => 'Falló la escritura del archivo en disco',
    8 => 'Una extensión PHP detuvo la carga del archivo'
  );
  
  private $upload_extensions = array(
   'gif',
   'jpg',
   'jpeg',
   'png',
  );
  
	/* 
	 * Constructor
	 */
	public function __construct() 
  {
		$this->set_paths( );
	}
  public function __destruct() 
  {
    $this->userPath    = "";
    $this->productPath = "";    
  }
 
 	
	private function set_paths() 
  {
    
    $this->userPath    = SITE_ROOT . DS . 'uploads/users';
    $this->productPath = SITE_ROOT . DS . 'uploads/products';    
	}
	
 
  public function is_correct_file_type($filename) 
  {
    return in_array($this->file_ext($filename), $this->upload_extensions);
  }
  private function file_ext($filename) 
  {
    //$ext = strtolower(substr( $filename, strrpos( $filename, '.' ) + 1 ) );   // old-code
    return end(explode('.', $filename));
  }

  public function upload($file)
  {
    if( !$file || empty($file) || !is_array($file) ) {
      $this->errors[] = "Ningún archivo subido.";
      return false;
     }
    elseif( $file['error'] != 0 ) {
      /* error por método de carga de PHP */ 
      $this->errors[] = $this->upload_errors[$file['error']];
      return false;
    }
    elseif( !$this->is_correct_file_type($file['name']) ) {
      $this->errors[] = 'Formato de archivo incorrecto ';
      return false;
    }
    else {
      $this->imageInfo = getimagesize($file['tmp_name']);
      $this->fileName  = basename($file['name']);
      $this->fileType  = $this->imageInfo['mime'];
      $this->fileTempPath = $file['tmp_name'];

     	return true;
   	}
  }

  
	public function check_file() {
    if (!empty($this->errors)) {
      return false;
    }
    elseif (empty($this->fileName) || empty($this->fileTempPath) || empty($this->productPath)) {
      $this->errors[] = "La ubicación del archivo no esta disponible.";
      return false;
    }
    elseif (!is_writable($this->productPath)) {
      $this->errors[] = "Debe tener permisos de escritura";
      return false;
    }
    elseif (file_exists($this->productPath."/".$this->fileName)) {
      $this->errors[] = "El archivo {$this->fileName} ya existe.";
      return false;
    }
    else {
    	return true;
    }
 	}

  public function process_product_media() 
  {
    if (!empty($this->errors)) {
      return false;
    }
    if (empty($this->fileName) || empty($this->fileTempPath) || empty($this->productPath)) {
      $this->errors[] = "La ubicación del archivo no se encuenta disponible.";
      return false;
    }
    if (!is_writable($this->productPath)) {
      $this->errors[] = sprintf("Debe tener permisos de escritura");
      return false;
    }
    if (file_exists($this->productPath.DS.$this->fileName)) {
      $this->errors[] = "El archivo {$this->fileName} ya existe.";
      return false;
    }
    if (move_uploaded_file($this->fileTempPath,$this->productPath.DS.$this->fileName)) {
	    if ($this->insert_media()) {
	      unset($this->fileTempPath);
	      return true;
	    }
    } 
    else {
      $this->errors[] = "Error en la carga del archivo, posiblemente debido a permisos incorrectos en la carpeta de carga.";
      return false;
    }
  }

  /** Reemplazar la imagen asociada a un producto, por otro nombre de archivo
   */
  public function change_product_media($id) 
  {
    global $db;
    if (!empty($this->errors)) {
      return false;
    }
    if (!is_numeric($id) || ($id = intval($id)) < 1) {
      $this->errors[] = "ID de archivo incorrecto.";
      return false;
    }
    if (empty($this->fileName) || empty($this->fileTempPath) || empty($this->productPath)) {
      $this->errors[] = "La ubicación del archivo no se encuenta disponible.";
      return false;
    }
    if (!is_writable($this->productPath)) {
      $this->errors[] = sprintf("Debe tener permisos de escritura");
      return false;
    }
    if (!file_exists($this->productPath.DS.$this->fileName)) {
      ;
    }
    if (move_uploaded_file($this->fileTempPath, $this->productPath.DS.$this->fileName)) {
      // guardar el nombre en el archivo 'antiguo'
      $old_entry = find_by_id('media', $id);
      if (isset($old_entry['file_name'])) 
        $oldFileName = $old_entry['file_name'];
      else
        $oldFileName = '';

      if (!$this->update_media($id)) {
        return false;
      }
      else
        
        $this->fileTempPath = '';

      // limpieza:
      // luego, verifique si alguna otra entrada en la tabla 'media' está usando
      // este nombre de archivo, si no es así, elimine ese archivo
      $sql = "SELECT COUNT(*) as N_entries FROM `media` WHERE `file_name`='{$oldFileName}'";
      if ($r_set = $db->query($sql)) {
        $r = $db->fetch_assoc($r_set);
        if (isset($r['N_entries']) && is_numeric($r['N_entries']) && intval($r['N_entries']) == 0) {
          unlink($this->productPath . DS . $oldFileName);
        }
      }
      return true;
    }
    else {
      $this->errors[] = "Error en la carga del archivo, posiblemente debido a permisos incorrectos en la carpeta de carga.";
      return false;
    }
  }

  /*--------------------------------------------------------------*/
  /* Función para procesar la imagen del usuario
  /*--------------------------------------------------------------*/
  
 	public function process_user_media($id) 
 	{
    global $db;

    if (!empty($this->errors)) {
      return false;
    }
    if (!$id || !is_numeric($id) || intval($id) < 0) {
      $this->errors[] = "ID de usuario incorrecto";
      return false;
    }
    if (empty($this->fileName) || empty($this->fileTempPath)) {
      $this->errors[] = "La ubicación del archivo no se encuentra disponible.";
      return false;
    }
    if (!is_writable($this->userPath)) {
      $this->errors[] = sprintf("Debe tener permisos de escritura");
      return false;
    }

    $ext = $this->file_ext($this->fileName);
    $new_name = randString(8).$id.'.'.$ext;

    $this->fileName = $new_name;
    if ($this->user_image_destroy($id)) {
      if (move_uploaded_file($this->fileTempPath, $this->userPath.DS.$this->fileName)) {
  			if ($this->update_user_image($id)) {
  			  $this->fileTempPath = "";
  			  return true;
  			}
        else {
          $this->errors[] = $db->get_last_error();
          return false;    
        }
      } 
      else {
        $this->errors[] = "Error en la carga del archivo, posiblemente debido a permisos incorrectos en la carpeta de carga.";
        return false;
      }
  	}
    else {
      $this->errors[] = "Error en la carga del archivo, posiblemente debido a permisos incorrectos en la carpeta de carga.";
      return false;
    }
 	}

	/*--------------------------------------------------------------*/
	/* Función para actualizar la imagen del usuario
	/*--------------------------------------------------------------*/
 
  private function update_user_image($id) 
  {
    global $db;
    $sql = "UPDATE users SET";
    $sql .=" image='{$db->escape($this->fileName)}'";
    $sql .=" WHERE id='{$db->escape($id)}'";
    $result = $db->query($sql);
    return ($result && $db->affected_rows() === 1 ? true : false);
  }
  /*--------------------------------------------------------------*/
  /* Función para insertar imagen multimedia
  /*--------------------------------------------------------------*/
 
  private function insert_media()
  {
    global $db;
    //$sql  = "INSERT INTO `media`(`file_name`,`file_type`)";
    //$sql .=" VALUES ";
    //$sql .="(
    //  '{$db->escape($this->fileName)}',
    //  '{$db->escape($this->fileType)}'
    //)";
    $sql  = "INSERT INTO `media` SET";
    $sql .=" `file_name`='{$db->escape($this->fileName)}'";
    $sql .=",`file_type`='{$db->escape($this->fileType)}'";
    return ($db->query($sql) ? true : false);
  }

  private function update_media($id)
  {
    global $db;
    $sql  = "UPDATE `media` SET";
    $sql .=" `file_name`='{$db->escape($this->fileName)}'";
    $sql .=",`file_type`='{$db->escape($this->fileType)}'";
    $sql .=" WHERE `id`=" . $db->escape($id);
    return ($db->query($sql) ? true : false);
  }
	/*--------------------------------------------------------------*/
	/* Función para eliminar la imagen antigua del servidor.
	/*--------------------------------------------------------------*/
  public function user_image_destroy($id) 
  {
		$image = find_by_id('users', $id);
    if (!$image) return true;
		if ($image['image'] === 'no_image.jpg') {
		  return true;
    }
		else {
		  unlink( $this->userPath.DS.$image['image'] );
		  return true;
		}
  }
	/*--------------------------------------------------------------*/
	/* función para eliminar medios por id
	/*--------------------------------------------------------------*/
  public function media_destroy($id, $file_name)
  {
		$this->fileName = $file_name;
		if (empty($this->fileName)) {
			$this->errors[] = "Falta el archivo de foto.";
			return false;
 		}
		if (!$id) {
		 	$this->errors[] = "Falta ID de foto.";
		 	return false;
		}
		if (delete_by_id('media',$id)) {
			return unlink($this->productPath.'/'.$this->fileName);
		}
    else {
			$this->error[] = "Se ha producido un error en la eliminación de fotografías.";
      
			return false;
		}
  }
}
?>