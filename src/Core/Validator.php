<?php

namespace App\Core;

class Validator {
        
    /**
     * @var array $patterns
     */
    public $patterns = array(
        'uri'           => '[A-Za-z0-9-\/_?&=]+',
        'url'           => '[A-Za-z0-9-:.\/_?&=#]+',
        'alpha'         => '[\p{L}]+',
        'words'         => '[\p{L}\s]+',
        'alphanum'      => '[\p{L}0-9]+',
        'int'           => '[0-9]+',
        'float'         => '[0-9\.,]+',
        'tel'           => '[0-9+\s()-]+',
        'text'          => '[\p{L}0-9\s-.,;:!"%&()?+\'°#\/@]+',
        'file'          => '[\p{L}\s0-9-_!%&()=\[\]#@,.;+]+\.[A-Za-z0-9]{2,4}',
        'folder'        => '[\p{L}\s0-9-_!%&()=\[\]#@,.;+]+',
        'address'       => '[\p{L}0-9\s.,()°-]+',
        'date_dmy'      => '[0-9]{1,2}\-[0-9]{1,2}\-[0-9]{4}',
        'date_ymd'      => '[0-9]{4}\-[0-9]{1,2}\-[0-9]{1,2}',
        'email'         => '[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+[.]+[a-z-A-Z]{2,4}'
    );
    
    /**
     * @var array $errors
     */
    public $errors = array();
    
    /**
     * Field name
     * 
     * @param string $name
     * @return this
     */
    public function name($name){
        
        $this->name = $name;
        return $this;
    
    }
    
    /**
     * Field value
     * 
     * @param mixed $value
     * @return this
     */
    public function value($value){
        
        $this->value = $value;
        return $this;
    
    }
    
    /**
     * File
     * 
     * @param mixed $value
     * @return this
     */
    public function file($value){
        
        $this->file = $value;
        return $this;
    
    }
    
    /**
     * Pattern to apply to regex recognition
     * 
     * @param string $name pattern name
     * @return this
     */
    public function pattern($name){
        
        if($name == 'array'){
            
            if(!is_array($this->value)){
                $this->errors[] = 'Invalid format for field "'.$this->name.'".';
            }
        
        }else{
        
            $regex = '/^('.$this->patterns[$name].')$/u';
            if($this->value != '' && !preg_match($regex, $this->value)){
                $this->errors[] = 'Invalid format for field "'.$this->name.'".';
            }
            
        }
        return $this;
        
    }
    
    /**
     * Pattern customization
     * 
     * @param string $pattern
     * @return this
     */
    public function customPattern($pattern){
        
        $regex = '/^('.$pattern.')$/u';
        if($this->value != '' && !preg_match($regex, $this->value)){
            $this->errors[] = 'Invalid format for field "'.$this->name.'".';
        }
        return $this;
        
    }
    
    /**
     * Required field
     * 
     * @return this
     */
    public function required(){
        
        if((isset($this->file) && $this->file['error'] == 4) || ($this->value == '' || $this->value == null)){
            $this->errors[] = 'Field "'.$this->name.'" required.';
        }            
        return $this;
        
    }
    
    /**
     * Min length
     * 
     * @param int $min
     * @return this
     */
    public function min($length){
        
        if(is_string($this->value)){
            
            if(strlen($this->value) < $length){
                $this->errors[] = 'Value of the field "'.$this->name.'" is shorter than min authorized length';
            }
        
        }else{
            
            if($this->value < $length){
                $this->errors[] = 'Value of the field "'.$this->name.'" is shorter than min authorized length';
            }
            
        }
        return $this;
        
    }
        
    /**
     * Max length
     * 
     * @param int $max
     * @return this
     */
    public function max($length){
        
        if(is_string($this->value)){
            
            if(strlen($this->value) > $length){
                $this->errors[] = 'Value of the field "'.$this->name.'" is greater than min authorized length';
            }
        
        }else{
            
            if($this->value > $length){
                $this->errors[] = 'Value of the field "'.$this->name.'" is greater than min authorized length';
            }
            
        }
        return $this;
        
    }
    
    /**
     * Compare with the value of another field
     * 
     * @param mixed $value
     * @return this
     */
    public function equal($value){
    
        if($this->value != $value){
            $this->errors[] = 'Value of the field "'.$this->name.'" not matching.';
        }
        return $this;
        
    }
    
    /**
     * Max file size
     *
     * @param int $size
     * @return this 
     */
    public function maxSize($size){
        
        if($this->file['error'] != 4 && $this->file['size'] > $size){
            $this->errors[] = 'File "'.$this->name.'" is greater than '.number_format($size / 1048576, 2).' MB.';
        }
        return $this;
        
    }
    
    /**
     * File extension
     *
     * @param string $extension
     * @return this 
     */
    public function ext($extension){

        if($this->file['error'] != 4 && pathinfo($this->file['name'], PATHINFO_EXTENSION) != $extension && strtoupper(pathinfo($this->file['name'], PATHINFO_EXTENSION)) != $extension){
            $this->errors[] = 'File "'.$this->name.'" isn\'t a '.$extension.'.';
        }
        return $this;
        
    }
    
    /**
     * XSS Blocker
     *
     * @param string $string
     * @return $string
     */
    public function purify($string){
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }
    
    /**
     * Validate
     * 
     * @return boolean
     */
    public function isSuccess(){
        if(empty($this->errors)) return true;
    }

    /**
     * Runs a function if no validation errors
     * 
     * @param function $callback
     * @return boolean
     */
    public function onSuccess($callback){
        if(empty($this->errors)) $callback();
    }
    
    /**
     * Get validation errors
     * 
     * @return array $this->errors
     */
    public function getErrors(){
        if(!$this->isSuccess()) return $this->errors;
    }
    
    /**
     * Get HTML formatted validation errors
     * 
     * @return string $html
     */
    public function displayErrors(){
        if(!$this->getErrors()) return;
        $html = '<ul>';
            foreach($this->getErrors() as $error){
                $html .= '<li>'.$error.'</li>';
            }
        $html .= '</ul>';
        
        echo $html;
        
    }
    
    /**
     * View validation result
     *
     * @return booelan|string
     */
    public function result(){
        
        if(!$this->isSuccess()){
            
            foreach($this->getErrors() as $error){
                echo "$error\n";
            }
            exit;
            
        }else{
            return true;
        }
    
    }
    
    /**
     * Check if value is int
     *
     * @param mixed $value
     * @return boolean
     */
    public static function is_int($value){
        if(filter_var($value, FILTER_VALIDATE_INT)) return true;
    }
    
    /**
     * Check if value is float
     *
     * @param mixed $value
     * @return boolean
     */
    public static function is_float($value){
        if(filter_var($value, FILTER_VALIDATE_FLOAT)) return true;
    }
    
    /**
     * Check if value contains only letters
     *
     * @param mixed $value
     * @return boolean
     */
    public static function is_alpha($value){
        if(filter_var($value, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => "/^[a-zA-Z]+$/")))) return true;
    }
    
    /**
     * Check if value is alphanumeric
     *
     * @param mixed $value
     * @return boolean
     */
    public static function is_alphanum($value){
        if(filter_var($value, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => "/^[a-zA-Z0-9]+$/")))) return true;
    }
    
    /**
     * Check if value respects URL format
     *
     * @param mixed $value
     * @return boolean
     */
    public static function is_url($value){
        if(filter_var($value, FILTER_VALIDATE_URL)) return true;
    }
    
    /**
     * Check if value respects URI format
     *
     * @param mixed $value
     * @return boolean
     */
    public static function is_uri($value){
        if(filter_var($value, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => "/^[A-Za-z0-9-\/_]+$/")))) return true;
    }
    
    /**
     * Check if value is boolean
     *
     * @param mixed $value
     * @return boolean
     */
    public static function is_bool($value){
        if(is_bool(filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE))) return true;
    }
    
    /**
     * Check if value respects email format
     *
     * @param mixed $value
     * @return boolean
     */
    public static function is_email($value){
        if(filter_var($value, FILTER_VALIDATE_EMAIL)) return true;
    }
}