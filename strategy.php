<?php
ini_set('display_errors', 1);
error_log(E_ALL);

require_once('includes/strategy.php');

$markers = array(new RegexpMarker('/f.ve/'),
                new MatchMarker('five'),
                new MarkLogicMarker('$input equals "five"'));

foreach ($markers as $marker) {
    print get_class($marker).'<br>'.PHP_EOL;
    $question = new TextQuestion('how many beans make five', $marker);
    foreach(array('five', 'four') as $response) {
        print "-> response: $response: ";
        if ($question->mark($response)) {
            print 'well done<br>'.PHP_EOL;
        } else {
            print 'never mind<br>'.PHP_EOL;
        }
    }
}
?>
    </body>
</html>
