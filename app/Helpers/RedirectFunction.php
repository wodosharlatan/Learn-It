<?php


function ValidatorRedirect($url, $validator, $webEndpoint)
{

    // return the error message and the input data
    return redirect($url . $webEndpoint)
        ->withErrors($validator)
        ->withInput();
}

?>
