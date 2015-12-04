<?php
/**
 * --- Day 4: The Ideal Stocking Stuffer ---
 *
 * Santa needs help mining some AdventCoins (very similar to bitcoins) to use as gifts for all the economically forward-thinking little girls and boys.
 * To do this, he needs to find MD5 hashes which, in hexadecimal, start with at least five zeroes.
 * The input to the MD5 hash is some secret key (your puzzle input, given below) followed by a number in decimal. To mine AdventCoins,
 * you must find Santa the lowest positive number (no leading zeroes: 1, 2, 3, ...) that produces such a hash.
 *
 * For example:
 * If your secret key is abcdef, the answer is 609043, because the MD5 hash of abcdef609043 starts with five zeroes (000001dbbfa...),
 * and it is the lowest such number to do so.
 * If your secret key is pqrstuv, the lowest number it combines with to make an MD5 hash starting with five zeroes is 1048970; that is,
 * the MD5 hash of pqrstuv1048970 looks like 000006136ef....
 *
 * --- Part Two ---
 *
 * Now find one that starts with six zeroes.
 */

$secretKey = 'iwrupvqb';

/**
 * @param string $secretKey
 * @param int $part
 * @param int $limit (1 billion by default)
 * @return string
 */
function getAnswer($secretKey, $part = 1, $limit = 1000000000)
{
    $answer = 'No AdventCoin found son !';
    $startOfMD5 = $part === 1 ? '00000' : '000000';

    // searching in progress ...
    for ($i = 0; $i < $limit; $i++) {

        // yes ! we found it !
        if (strpos(md5($secretKey.$i), $startOfMD5) === 0) {
            $answer = 'The AdventCoin is : '.$i;
            break;
        }
    }

    return $answer;
}

echo '***** Solution - Day 4 *****'.PHP_EOL.PHP_EOL;

foreach (array(1, 2) as $part) {
    echo '- Part '.($part).' : '.getAnswer($secretKey, $part).PHP_EOL;
}
