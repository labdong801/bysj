<?php
    class ART_PHPZip
    {
        private $ctrl_dir     = array();
        private $datasec      = array();


        /**********************************************************
         * 压缩部分
         **********************************************************/
        // ------------------------------------------------------ //
        // #遍历指定文件夹
        //
        // $archive  = new PHPZip();
        // $filelist = $archive->visitFile(文件夹路径);
        // print "当前文件夹的文件:<p>\r\n";
        // foreach($filelist as $file)
        //     printf("%s<br>\r\n", $file);
        // ------------------------------------------------------ //
        var $fileList = array();
        public function visitFile($path)
        {
            global $fileList;
            $path = str_replace("\\", "/", $path);
            $fdir = dir($path);

            while(($file = $fdir->read()) !== false)
            {
                if($file == '.' || $file == '..'){ continue; }

                $pathSub    = preg_replace("*/{2,}*", "/", $path."/".$file);  // 替换多个反斜杠
                $fileList[] = is_dir($pathSub) ? $pathSub."/" : $pathSub;
                if(is_dir($pathSub)){ $this->visitFile($pathSub); }
            }
            $fdir->close();
            return $fileList;
        }


        private function unix2DosTime($unixtime = 0)
        {
            $timearray = ($unixtime == 0) ? getdate() : getdate($unixtime);

            if($timearray['year'] < 1980)
            {
                $timearray['year']    = 1980;
                $timearray['mon']     = 1;
                $timearray['mday']    = 1;
                $timearray['hours']   = 0;
                $timearray['minutes'] = 0;
                $timearray['seconds'] = 0;
            }

            return (  ($timearray['year'] - 1980) << 25)
                    | ($timearray['mon'] << 21)
                    | ($timearray['mday'] << 16)
                    | ($timearray['hours'] << 11)
                    | ($timearray['minutes'] << 5)
                    | ($timearray['seconds'] >> 1);
        }


        var $old_offset = 0;
        private function addFile($data, $filename, $time = 0)
        {
            $filename = str_replace('\\', '/', $filename);

            $dtime    = dechex($this->unix2DosTime($time));
            $hexdtime = '\x' . $dtime[6] . $dtime[7]
                      . '\x' . $dtime[4] . $dtime[5]
                      . '\x' . $dtime[2] . $dtime[3]
                      . '\x' . $dtime[0] . $dtime[1];
            eval('$hexdtime = "' . $hexdtime . '";');

            $fr       = "\x50\x4b\x03\x04";
            $fr      .= "\x14\x00";
            $fr      .= "\x00\x00";
            $fr      .= "\x08\x00";
            $fr      .= $hexdtime;
            $unc_len  = strlen($data);
            $crc      = crc32($data);
            $zdata    = gzcompress($data);
            $c_len    = strlen($zdata);
            $zdata    = substr(substr($zdata, 0, strlen($zdata) - 4), 2);
            $fr      .= pack('V', $crc);
            $fr      .= pack('V', $c_len);
            $fr      .= pack('V', $unc_len);
            $fr      .= pack('v', strlen($filename));
            $fr      .= pack('v', 0);
            $fr      .= $filename;

            $fr      .= $zdata;

            $fr      .= pack('V', $crc);
            $fr      .= pack('V', $c_len);
            $fr      .= pack('V', $unc_len);

            $this->datasec[] = $fr;
            $new_offset      = strlen(implode('', $this->datasec));

            $cdrec  = "\x50\x4b\x01\x02";
            $cdrec .= "\x00\x00";
            $cdrec .= "\x14\x00";
            $cdrec .= "\x00\x00";
            $cdrec .= "\x08\x00";
            $cdrec .= $hexdtime;
            $cdrec .= pack('V', $crc);
            $cdrec .= pack('V', $c_len);
            $cdrec .= pack('V', $unc_len);
            $cdrec .= pack('v', strlen($filename) );
            $cdrec .= pack('v', 0 );
            $cdrec .= pack('v', 0 );
            $cdrec .= pack('v', 0 );
            $cdrec .= pack('v', 0 );
            $cdrec .= pack('V', 32 );

            $cdrec .= pack('V', $this->old_offset );
            $this->old_offset = $new_offset;

            $cdrec .= $filename;
            $this->ctrl_dir[] = $cdrec;
        }


        var $eof_ctrl_dir = "\x50\x4b\x05\x06\x00\x00\x00\x00";
        private function file()
        {
            $data    = implode('', $this->datasec);
            $ctrldir = implode('', $this->ctrl_dir);

            return   $data
                   . $ctrldir
                   . $this->eof_ctrl_dir
                   . pack('v', sizeof($this->ctrl_dir))
                   . pack('v', sizeof($this->ctrl_dir))
                   . pack('V', strlen($ctrldir))
                   . pack('V', strlen($data))
                   . "\x00\x00";
        }




        // ------------------------------------------------------ //
        // #压缩并直接下载
        //
        // $archive = new PHPZip();
        // $archive->ZipAndDownload("需压缩的文件所在目录");
        // ------------------------------------------------------ //
        public function ZipAndDownload($dir)
        {
            if(@!function_exists('gzcompress')){ return; }

            ob_end_clean();
            $filelist = $this->visitFile($dir);
            if(count($filelist) == 0){ return; }

            foreach($filelist as $file)
            {
                if(!file_exists($file) || !is_file($file)){ continue; }

                $fd       = fopen($file, "rb");
                $content  = @fread($fd, filesize($file));
                fclose($fd);

                // 1.删除$dir的字符(./folder/file.txt删除./folder/)
                // 2.如果存在/就删除(/file.txt删除/)
                $file = substr($file, strlen($dir));
                if(substr($file, 0, 1) == "\\" || substr($file, 0, 1) == "/"){ $file = substr($file, 1); }

                $this->addFile($content, $file);
            }
            $out = $this->file();

            @header('Content-Encoding: none');
            @header('Content-Type: application/zip');
            @header('Content-Disposition: attachment ; filename=ART'.date("YmdHis", time()).'.zip');
            @header('Pragma: no-cache');
            @header('Expires: 0');
            print($out);
        }
     /////////////////////////////////////////
     //原文件夹，转移的文件夹，文件名数组
     public function select_file($dir,$new_dir,$arr,$new_arr)
     {
     	     if(!file_exists($new_dir))
           {
	          mkdir($new_dir);
           }
        $count=count($arr);
        for($i=0;$i<$count;$i++)
        {
        	copy($dir.$arr[$i],$new_dir.$new_arr[$i]);
        	$i++;
        }

     }

    public   function delete_file($dir)
      {
    	$dh=opendir($dir);
    	while($file=readdir($dh))
       {
	     if($file!="." && $file!="..")
	    {
		  $fulpath=$dir."/".$file;
		  if(!is_dir($fulpath))
		  {
			unlink($fulpath);
		  }
	    }
       }
       rmdir($dir);
      }

    }

?>


