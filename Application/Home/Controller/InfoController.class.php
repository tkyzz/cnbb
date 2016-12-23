<?php 

namespace Home\Controller;  
use Think\Controller\RestController;  
Class IndexController extends RestController {  
      
    public function index(){  
        // if(__EXT__==""||__EXT__=="html"){  
        //     $type='html';  
        // }else{  
        //     $type=__EXT__;  
        // }  
        // //print_r(__EXT__);  
        // $pyname = $_GET['id'];  
        // switch ($this->_method){        
        //      case 'get': // get请求处理代码           
        // if ($type== 'html'){   
        //      // 'html';die;  
        //       $data=$this->city($pyname);  
        //       //print_r($data);  
        //       //Response方法会自动对data数据进行输出类型编码，目前支持的包括xml/json/html。  
        //       //$this->response($data,'json');  
        //       $result=$this->response($data,'html');  
        //       //print_r($result);  
        //       return $result;  
        //  }elseif($type== 'xml'){   
        //      $data = $this->city($pyname);  
        //      $result = $this->response($data,'xml');  
        //      return $result;  
        //  }elseif($type=='json'){  
        //     $data=file_get_contents("http://192.168.0.114:8081/base/servers");  
        //     $result=$this->response($data,'json');  
        //     return $result;  
        //  }             
        //  break;        
        //  case 'put': // put请求处理代码          
        //  break;        
        //  case 'post': // post请求处理代码            
        //  break;    
        //  }  
          echo 1;
    }  