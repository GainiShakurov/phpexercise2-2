<?php
if (isset($_GET['name']) && !empty($_GET['name'])) {

    $path = __DIR__ . '/tests/' . $_GET['name'] . '.json';
    $currentTest = json_decode(file_get_contents($path), true);

    echo '<form action="" method="POST">';
    echo '<input type="hidden" name="sended" value="1"/>';
    foreach ($currentTest as $questionKey => $question) {
        echo '<fieldset>';
        echo '<legend>' . $question['body'] . '</legend>';
        foreach ($question['answers'] as $answerKey => $answer) {
            echo '<label><input type="radio" name="' . $questionKey . '-' . $answerKey . '">' . $answer['body'] . '</label>';
        }
        echo '</fieldset>';
    }
    echo '<input type="submit" value="Отправить"></form>';

    if (isset($_POST['sended']) && !empty($_POST['sended'])) {
        $arr = [];
        $arr = $_POST;
        $correctAnswers = 0;
        foreach ($arr as $key => $value) {
            $parts = explode("-", $key);
            $questId = (string)$parts[0];
            $answerId = (string)$parts[1];

            if ($currentTest[$questId]['answers'][$answerId]['correct']) {
                $correctAnswers++;
            }

        }

        echo '<h4>Кол-во правильных ответов - ' . $correctAnswers . '</h4>';
    }

}
?>
