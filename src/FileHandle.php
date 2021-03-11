<?php
/**
 * 文件处理的类
 * Created by PhpStorm.
 * User: kmrb20181113
 * Date: 2020/10/21
 * Time: 17:48
 */

namespace YxTools;


class FileHandle
{
    /*
     *
     * 递归遍历所有文件夹及其子文件,输出文件夹名和文件名
    */
    public function callFile($path,&$data){

        $handler = opendir($path);
        while( ($filename = readdir($handler)) !== false )
        {
            //略过linux目录的名字为'.'和‘..'的文件
            if($filename != '.' && $filename != '..')
            {
                //输出文件名
                $data[] = $filename;
                $sub_dir = realpath($path.'/'.$filename);
                $checkResult = is_file($sub_dir);
                if(!$checkResult){
                    $this->callFile($sub_dir,$data);
                }
            }
        }

    }
    public function getSingleFile($dir){
        $data=array();
        $this->callFile($dir,$data);
        return   $data;
    }

    /*
     * 递归遍历所有文件夹及其子文件，输出文件名(所有文件夹，数组形式输出。只输出文件路径)
    */
    public function searchDir($path,&$data){
        if(is_dir($path)){
            $dp=dir($path);
            while($file=$dp->read()){
                if($file!='.'&& $file!='..'){
                    $this->searchDir($path.'/'.$file,$data);
                }
            }
            $dp->close();
        }
        if(is_file($path)){
            $data[]=$path;
        }
    }
    public function getDir($dir){
        $data=array();
        $this->searchDir($dir,$data);
        return   $data;
    }

    /*
     * 获取文件信息
     * dirname
     * basename
     * extension
     * filename
    */
    public function getFileInfo($string){
        $file = realpath($string);
        $info = pathinfo($file);
        return   $info;
    }

}