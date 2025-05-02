<?php
namespace Core;

class Validator {
    private $errors = [];
    private $data;

    public function validate(array $data, array $rules) {
        $this->data = $data;
        
        foreach ($rules as $field => $ruleString) {
            $rules = explode('|', $ruleString);
            
            foreach ($rules as $rule) {
                $this->applyRule($field, $rule);
            }
        }
        
        return empty($this->errors);
    }

    public function errors() {
        return $this->errors;
    }

    private function applyRule($field, $rule) {
        $value = $this->data[$field] ?? null;
        
        if ($rule === 'required' && empty($value)) {
            $this->errors[$field][] = "The {$field} field is required.";
        }
        
        if ($rule === 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field][] = "The {$field} must be a valid email address.";
        }
        
        if (strpos($rule, 'min:') === 0) {
            $min = (int) substr($rule, 4);
            if (strlen($value) < $min) {
                $this->errors[$field][] = "The {$field} must be at least {$min} characters.";
            }
        }
        
        if (strpos($rule, 'max:') === 0) {
            $max = (int) substr($rule, 4);
            if (strlen($value) > $max) {
                $this->errors[$field][] = "The {$field} may not be greater than {$max} characters.";
            }
        }
    }
}