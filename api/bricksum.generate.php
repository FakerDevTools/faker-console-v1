<?php

/*
 * Fetch the current word list and stop words.
 */
$bricksum_wordlist = setting_fetch('BRICKSUM_WORDLIST', 'comma_2_array');
$bricksum_stopwords = setting_fetch('BRICKSUM_STOPWORDS', 'comma_2_array');

/* 
 * Set default length ranges for sentences and paragraphs.
 */
$sentence_minimum = 3;
$sentence_maximum = 9;
$sentence_length = rand($sentence_minimum, $sentence_maximum);

$paragraph_minimum = 2;
$paragraph_maximum = 5;
$paragraph_length = rand($paragraph_minimum, $paragraph_maximum);

/*
 * Create counters for paragraphs, sentences, and words. 
 */
$paragraph = 0;
$sentence = 0;
$word = 0;

/*
 * Create a variable to store the last word used, to prevent having the same word
 * twice in a row.
 */
$last_word = -1;

/*
 * Create an array to store the parapgraph, sentence, and word structure.
 */
$word_array = [];

/*
 * A function that will provide a random word from the Bricksum settings.
 */
function bricksum_random_word($last_word = false)
{

    global $bricksum_stopwords, $bricksum_wordlist;

    if(rand(0,4) == 0)
    {
        do
        {
            $next_word = rand(0, count($bricksum_stopwords) - 1);
        }
        while($bricksum_stopwords[$next_word] == $last_word);

        return $bricksum_stopwords[$next_word];
    }
    else
    {
        do
        {
            $next_word = rand(0, count($bricksum_wordlist) - 1);
        }
        while($bricksum_wordlist[$next_word] == $last_word);

        return $bricksum_wordlist[$next_word];
    }
}

/*
 * Generate bricksum based on word count.
 */
if(isset($_GET['words']))
{

    if(!is_numeric($_GET['words']))
    {
        $data = array(
            'message' => 'Words parameter muct be numeric.',
            'error' => false,
        );
        return;
    }

    while($word < $_GET['words'])
    {

        if(
            isset($word_array[$paragraph]) &&
            count($word_array[$paragraph][$sentence]) > $sentence_length && 
            $word < $_GET['words'] - 3)
        {
            $sentence ++;
            $sentence_length = rand($sentence_minimum, $sentence_maximum);

            if(
                count($word_array[$paragraph]) > $paragraph_length &&
                $word < $_GET['words'] - 10)
            {
                $paragraph ++;
                $paragraph_length = rand($paragraph_minimum, $paragraph_maximum);
            }
        }
        
        $word_array[$paragraph][$sentence][$word] = bricksum_random_word($last_word);

        $last_word = $word_array[$paragraph][$sentence][$word];
    
        $word ++;

    }

    $message = $_GET['words'].' words of Bricksum content has been generated.';

}

/*
 * Generate bricksum based on sentence count.
 */
elseif(isset($_GET['sentences']))
{

    if(!is_numeric($_GET['sentences']))
    {
        $data = array(
            'message' => 'Sentences parameter muct be numeric.',
            'error' => false,
        );
        return;
    }

    while($sentence < $_GET['sentences'])
    {

        if(
            isset($word_array[$paragraph]) &&
            count($word_array[$paragraph]) > $paragraph_length)
        {
            $paragraph ++;
            $paragraph_length = rand($paragraph_minimum, $paragraph_maximum);
        }

        for($word = 0; $word < $sentence_length; $word ++)
        {

            if(rand(0,4) == 0)
            {
                do
                {
                    $next_word = rand(0, count($bricksum_stopwords) - 1);
                }
                while($next_word == $last_word);

                $word_array[$paragraph][$sentence][$word] = $bricksum_stopwords[$next_word];
            }
            else
            {
                do
                {
                    $next_word = rand(0, count($bricksum_wordlist) - 1);
                }
                while($next_word == $last_word);

                $word_array[$paragraph][$sentence][$word] = $bricksum_wordlist[$next_word];
            }

            $last_word = $next_word;
    
        }
    
        $sentence ++;

        $sentence_length = rand($sentence_minimum, $sentence_maximum);

    }

    $message = $_GET['sentences'].' sentences of Bricksum content has been generated.';

}

/*
 * Generate bricksum based on paragraph count.
 */
elseif(isset($_GET['paragraphs']))
{

    if(!is_numeric($_GET['paragraphs']))
    {
        $data = array(
            'message' => 'Paragraphs parameter muct be numeric.',
            'error' => false,
        );
        return;
    }

    while($paragraph < $_GET['paragraphs'])
    {

        for($sentence = 0; $sentence < $paragraph_length; $sentence ++)
        {

            for($word = 0; $word < $sentence_length; $word ++)
            {

                if(rand(0,4) == 0)
                {
                    do
                    {
                        $next_word = rand(0, count($bricksum_stopwords) - 1);
                    }
                    while($next_word == $last_word);

                    $word_array[$paragraph][$sentence][$word] = $bricksum_stopwords[$next_word];
                }
                else
                {
                    do
                    {
                        $next_word = rand(0, count($bricksum_wordlist) - 1);
                    }
                    while($next_word == $last_word);

                    $word_array[$paragraph][$sentence][$word] = $bricksum_wordlist[$next_word];
                }

                $last_word = strtolower($next_word);
        
            }

            $sentence_length = rand($sentence_minimum, $sentence_maximum);

        }

        $paragraph_length = rand($paragraph_minimum, $paragraph_maximum);

        $paragraph ++;

    }
    
    $message = $_GET['paragraphs'].' paragraphs of Bricksum content has been generated.';

}

$text = '';

$paragraph_count = 0;
$sentence_count = 0;
$word_count = 0;

foreach($word_array as $key => $paragraph)
{
    foreach($paragraph as $key => $sentence)
    {
        foreach($sentence as $key => $word)
        {
            if($key == array_keys($sentence)[0]) $text .= ucfirst($word).' ';
            elseif($key == array_key_last($sentence)) $text .= $word.'. ';
            elseif(array_search($key, array_keys($sentence)) == 3 && array_key_last($sentence) > 6 && rand(1,2) == 2) $text .= $word.', ';
            else $text .= $word.' ';

            $word_count ++;
        }

        $sentence_count ++;
    }

    $paragraph_count ++;

    $text .= chr(13);

}

setting_increment('BRICKSUM_PARAGRAPHS_GENERATED', $paragraph_count);
setting_increment('BRICKSUM_SENTENCES_GENERATED', $sentence_count);
setting_increment('BRICKSUM_WORDS_GENERATED', $word_count);

$data = array(
    'message' => $message,
    'error' => false, 
    'wordlist' => $text,
);
