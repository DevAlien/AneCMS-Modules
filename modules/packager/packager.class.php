<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/

/**
 * Description of packagerclass
 *
 * @author Gonçalo
 */
class Packager {

    private $name;
    private $size;
    private $compressed_size;
    private $dir;
    private $type;

    const MODULE = 'modules';
    const WIDGET = 'widgets';
    const TEMPLATE = 'skins';

    public function __construct($name, $type = 'modules') {
        $this->name = $name;
        $this->type = $type;
    }

    /**
     * Add dir
     */
    public function addDir( $dir ) {
        if( $dir == "/" )
            $dir = "";
        //------------------------------------------
        // Read the directory tree
        //------------------------------------------
        if( $files = glob( $dir . "*" ) )
            foreach( $files as $filename ) {
                if( is_dir( $filename ) )
                    $this->addDir( $filename . "/" );
                else
                    $this->addFile( $filename );
            }

        if( is_dir( $dir ))
            $this->dir[$dir] = true;
    }



    /**
     * Add file
     */
    public function addFile( $file ) {
        $this->file[$file] = true;
    }

    /**
     * Compress a file
     */
    public function compressFile( $file ) {

        $contents = file_get_contents( $file );	// read file
        $contents = gzcompress( $contents );	// compress contents
        $contents = base64_encode( $contents );	// convert contents in base64

        $filename 			= basename( $file );
        $dir 				= dirname( $file );
        $ext 				= end( (explode('.', $file)) );
        $name 				= basename( $file, ".".$ext );
        $size 				= filesize( $file );
        $compressed_size                = strlen( $contents );

        $this->size += $size;
        $this->compressed_size += $compressed_size;

        return array( $filename, $dir, $name, $ext, $size, $contents, $compressed_size );

    }



    public function createPackage() {
        //------------------------------------------
        // Open file
        //------------------------------------------
        $header = "<?php" . "\n";
        $header .= '$type = \''.$this->type.'\';';
        $header .= "\n";
        $fp = fopen( './modules/packager/'.$this->type.'/'.$this->name.'.php' , "w" );
        fwrite( $fp, $header, strlen( $header ) );
        
        if( isset( $this->dir ) ) {

            $directory = "//Directory list" . "\n";
            $directory .= "\$directory = array();";

            ksort( $this->dir );
            foreach( $this->dir as $dir => $compress ) {
                // if directory can be compressed
                if( $compress ) {
                    $perms = fileperms( $dir );
                    $directory .= "\n" . "\$directory['../{$dir}'] = array( 'perms' => {$perms} );";
                }
            }

            fwrite( $fp, $directory, strlen( $directory ) );

        }

        //------------------------------------------
        // Compress and write file
        //------------------------------------------
        if( isset( $this->file ) ) {

            $compressed_file =  "\n\n" . "//File list" . "\n";
            $compressed_file .= "\$file= array();";
            fwrite( $fp, $compressed_file, strlen( $compressed_file ) );

            foreach( $this->file as $file => $compress ) {
                list( $basename, $dir, $name, $ext, $size, $contents, $compressed_size ) = $this->compressFile( $file );
                $perms = fileperms( $file );
                $compressed_file = "\n" . "\$file['../$file'] = array( 'basename' => '$basename','dir' =>'$dir','name' =>'$name','ext' =>'$ext','size' =>$size, 'perms' => $perms, 'contents' =>'$contents' ); ";
                fwrite( $fp, $compressed_file, strlen( $compressed_file ) );
            }
        }
        $footer = "\n" . "?>";

        fwrite( $fp, $footer, strlen( $footer ) );
        fclose( $fp );


    }


    public function downloadFile() {
        ob_end_clean();
        header('Content-type: text');

        header('Content-Disposition: attachment; filename="'.$this->name.'.php"');

        readfile('./modules/packager/'.$this->type.'/'.$this->name.'.php');
        die();
    }

}
?>