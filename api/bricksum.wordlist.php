<?php

$bricksum_wordlist = setting_fetch('BRICKSUM_WORDLIST', 'comma_2_array');

$data = array(
    'message' => 'Wordlist retrieved successfully.',
    'error' => false, 
    'wordlist' => $bricksum_wordlist,
);
