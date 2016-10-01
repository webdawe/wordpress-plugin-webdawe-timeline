<?php
class WebdaweValidator
{
    /**
     * Validation Errors
     * @var array
     */
    private $errors = array();

    /**
     * Validate Parameters
     * @param  Array  $data  parameters
     * @param  Array  $rules rules
     * @return bool
     */
    public function validate(Array $data, Array $rules)
    {
        $valid  = true;
        foreach ($rules as $key => $ruleset)
        {
            $ruleset = explode('|', $ruleset);

            foreach ($ruleset as $rule)
            {
                $pos = strpos($rule, ':');
                if ($pos !== false)
                {
                    $pos = strpos($rule, ':');
                    $parameter = substr($rule, $pos + 1);
                    $rule = substr($rule, 0, $pos);
                }
                else
                {
                    $parameter = '';
                }

                $methodName = 'validate' . ucfirst($rule);

                $value = isset($data[$key]['value']) ? $data[$key]['value'] : NULL;

                if (method_exists($this, $methodName))
                {

                    $this->$methodName($key, $value, $parameter) OR $valid = false;
                }
            }
        }

        return $valid;
    }

    /**
     * Retrieve Errors
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Validate Required Fields
     * @param  string $item
     * @param  string $value
     * @param  string $parameter
     * @return bool
     */
    private function validateRequired($item, $value, $parameter)
    {
        if ($value === '' || $value === NULL)
        {
            $this->errors[] = 'The ' . $item . ' field is required';
            return false;
        }

        return true;
    }

    /**
     * Validate Email
     * @param  string $item
     * @param  string $value
     * @param  string $parameter
     * @return bool
     */
    private function validateEmail ($item, $value, $parameter)
    {
        if (! filter_var($value, FILTER_VALIDATE_EMAIL))
        {
            $this->errors[] = 'The ' . $item . ' field should be a valid email addres';
            return false;
        }

        return true;
    }
    /**
     * validate Minimum
     * @param  string $item
     * @param  string $value
     * @param  string $parameter
     * @return bool
     */
    private function validateMin ($item, $value, $parameter)
    {
        if (strlen($value) >= $parameter == false)
        {
            $this->errors[] = 'The ' . $item . ' field should have a minimum length of ' . $parameter;
            return false;
        }

        return true;
    }
}