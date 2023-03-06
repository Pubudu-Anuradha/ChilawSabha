<?php
class Errors
{
    public static function generic(&$message, $id = null, $class = null)
    {?>
    <div class="error<?=!is_null($class) ? " $class" : ''?>"
        <?=!is_null($id) ? "id=\"$id\"" : ''?>>
      <?=$message?>
    </div>
  <?php }
    private static function switch_aliases(&$arr, &$aliases)
    {
        for ($i = 0; $i < count($arr); ++$i) {
            $arr[$i] = $aliases[$arr[$i]] ?? $arr[$i];
        }
    }

    private static function switch_aliases_first_index(&$arr, &$aliases)
    {
        for ($i = 0; $i < count($arr); ++$i) {
            $arr[$i][0] = $aliases[$arr[$i][0]] ?? $arr[$i][0];
        }
    }

    public static function validation_errors(&$errors, $aliases = [])
    {
        // This function is meant to be used to catch all server side error rendering
        // $errors is the generic errors array returned by Controller->validateInputs.
        // $aliases is an optional array with aliases for each field name
        // ! All possible generic errors must be handled here.

        // * '?'          <- Optional(can be empty or not given) -> missing|empty
        $missing_fields = $errors['missing'] ?? false;
        if ($missing_fields !== false) {
            Errors::switch_aliases($missing_fields, $aliases);
            $plural = count($missing_fields) > 1;
            $message = 'The field' . ($plural ? 's' : '') . ' <b>' . implode(',', $missing_fields) .
                '</b> ' . ($plural ? 'are' : 'is') . ' missing. Please make sure to include ' .
                ($plural ? 'them.' : 'it.');
            Errors::generic($message);
        }

        $empty_fields = $errors['empty'] ?? false;
        if ($empty_fields !== false) {
            Errors::switch_aliases($empty_fields, $aliases);
            $plural = count($empty_fields) > 1;
            $message = 'The field' . ($plural ? 's' : '') . ' <b>' . implode(',', $empty_fields) .
                '</b> ' . ($plural ? 'are' : 'is') . ' empty. Please make sure to fill ' .
                ($plural ? 'them.' : 'it.');
            Errors::generic($message);
        }

        // * 'i[min:max]' <- Integer in inclusive range(values are both optional) -> min|max|number
        // * 'd[min:max]' <- Same as above but using double -> min|max|number
        $number_errors = $errors['number'] ?? false;
        if ($number_errors !== false) {
            Errors::switch_aliases($number_errors, $aliases);
            $plural = count($number_errors) > 1;
            $message = 'There was an error parsing the number' . ($plural ? 's' : '') . ' in <b>' .
            implode(',', $number_errors) . '</b> Please check those input' . ($plural ? 's.' : '.');
            Errors::generic($message);
        }

        $min_num_errors = $errors['min'] ?? false;
        if($min_num_errors !== false) {
            Errors::switch_aliases_first_index($min_num_errors,$aliases);
            foreach($min_num_errors as $err){
                [$field,$min] = $err;
                Errors::generic("The value in $field must be greater than or equal to $min.");
            }
        }

        $max_num_errors = $errors['max'] ?? false;
        if($max_num_errors !== false) {
            Errors::switch_aliases_first_index($max_num_errors,$aliases);
            foreach($max_num_errors as $err){
                [$field,$max] = $err;
                Errors::generic("The value in $field must be lower than or equal to $max.");
            }
        }
        
        // TODO: min,max and errors below this
        // * 'l[min:max]' <- String length in inclusive range -> min_len|max_len
        // * 'e'          <- Validate Email -> email

    }
}