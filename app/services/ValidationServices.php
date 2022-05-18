<?php

namespace App\Services;

class ValidationServices
{
    //Check if input exists
    public function input_exists(array $inputs, array $data)
    {
        $exists = true;
        foreach ($data as $list) {
            if (!array_key_exists($list, $inputs)) {
                $exists = false;
            }
        }

        return $exists;
    }

    //Process Input
    public function process_input($inputs)
    {
        $processed_input = [];

        foreach ($inputs as $input) {
            $input = trim($input);
            $input = stripslashes($input);
            $input = htmlspecialchars($input);

            $processed_input[] = $input;
        }

        return $processed_input;
    }

    //Manage required inputs
    public function requiredInput(array $inputs, array $required_fields)
    {
        $required = true;
        foreach ($required_fields as $fields) {
            $inputs[$fields] = trim($inputs[$fields]);
            $inputs[$fields] = stripslashes($inputs[$fields]);
            $inputs[$fields] = htmlspecialchars($inputs[$fields]);

            if (empty($inputs[$fields])) {
                $required = false;
            }
        }

        return $required;
    }
}
