<?php
class Errors
{
    private static function generic(&$message, $id = null, $class = null)
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

    public static function validation_errors(&$errors, $aliases = [])
    {
        // This function is meant to be used to catch all server side error rendering
        // $errors is the generic errors array returned by Controller->validateInputs.
        // ! All possible generic errors must be handled here.
        // $aliases is an optional array with aliases for each field name

        $missing_fields = $errors['missing'] ?? false;
        if ($missing_fields !== false) {
            Errors::switch_aliases($missing_fields, $aliases);
            $plural = count($missing_fields) > 1;
            $message = 'The field' . ($plural ? 's' : '') . ' <b>' . implode(',', $missing_fields) .
                '</b> ' . ($plural ? 'are' : 'is') . ' missing. Please make sure to include ' . ($plural ? 'them.' : 'it.');
            Errors::generic($message);
        }

        $empty_fields = $errors['empty'] ?? false;
        if ($empty_fields !== false) {
            Errors::switch_aliases($empty_fields, $aliases);
            $plural = count($empty_fields) > 1;
            $message = 'The field' . ($plural ? 's' : '') . ' <b>' . implode(',', $empty_fields) .
                '</b> ' . ($plural ? 'are' : 'is') . ' empty. Please make sure to fill ' . ($plural ? 'them.' : 'it.');
            Errors::generic($message);
        }
    }
}