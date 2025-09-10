<?php
session_start();
function analyze_sentiment($text) {
    $positive_words = ['happy', 'good', 'love', 'great'];
    $negative_words = ['sad', 'bad', 'hate', 'angry'];

    $score = 0;
    $text = strtolower($text);

    foreach ($positive_words as $word) {
        if (strpos($text, $word) !== false) $score++;
    }

    foreach ($negative_words as $word) {
        if (strpos($text, $word) !== false) $score--;
    }

    return $score;
}

if (isset($_POST['submit'])) {
    $text = trim($_POST['diaryInput']);
    if ($text) {
        $score = analyze_sentiment($text);
        $mood = 'Neutral';
        $emoji = '😐';

        if ($score > 0) { $mood = 'Positive'; $emoji = '😊'; }
        elseif ($score < 0) { $mood = 'Negative'; $emoji = '😞'; }

        $entry = [
            'text' => htmlspecialchars($text),
            'date' => date('Y-m-d H:i:s'),
            'mood' => $mood,
            'emoji' => $emoji
        ];

        $_SESSION['diaryEntries'][] = $entry;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Simple Diary</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1>Simple Smart Diary</h1>

    <form method="POST" action="">
        <textarea name="diaryInput" placeholder="Write your diary entry here..." rows="5" cols="50"></textarea><br><br>
        <button type="submit" name="submit">Save Entry</button>
    </form>

    <h2>Diary Entries</h2>
    <?php include 'entries.php'; ?>
</body>

</html>
