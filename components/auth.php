<?php
function renderAuth($link, $type, $question, $direction = "", $greeting = "", $isRegister = false, $error_message = "") {
    $error_html = '';
    if ($error_message) {
        $error_html = "<div class='error-message show'>
            {$error_message}
            <button class='close-btn'>&times;</button>
        </div>";
    }

    $firstNameInput = "";
    if ($isRegister) {
        $firstNameInput = '
            <p>First name</p>
            <input type="text" name="first_name" required>
        ';
    }
    return "
        <div class='container'>
            <div class='form-container'>
                {$error_html}
                <h1>Blogz</h1>
                <h3>{$greeting}</h3>
                <form method='POST' action=''>
                    {$firstNameInput}
                    <p>Email</p>
                    <input type='email' name='email' required>
                    <p>Password</p>
                    <input type='password' name='password' id='password' maxlength='12' required>
                    <button type='submit'>Sign {$direction}</button>
                    <p>{$question}<a href='{$link}'>Sign {$type}</a></p>
                </form>
            </div>
        </div>

        <script src='js/auth.js'></script>
    ";
}
?>
