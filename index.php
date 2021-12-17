<?php
$question = '';
$msg = 'سوال خود را بپرس!';
$en_name = 'hafez';
$fa_name = 'حافظ';
$label = "";
$count =0;
$names = file_get_contents('people.json');
$names_second = json_decode($names,true);
$message= file_get_contents('messages.txt');
$messages = explode(PHP_EOL,$message);
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $question = $_POST["question"];
    $en_name = $_POST["person"];
    $fa_name = $names_second[$en_name];
    $label = "پرسش: ";
    if (strpos($question, "آیا") === 0 && (substr_compare($question, "؟", -strlen("؟")) ===0 || substr_compare($question, "?", -strlen("?")) === 0)){
        $msg=$messages[(intval(md5( $en_name.$question.$fa_name),10) % 16)];
    }else {
        $label = "";
        $question = "";
        $msg= "سوال درستی پرسیده نشده";
    }
}
else {
    $x = rand(0,15);
    $counter = 0;
    foreach($names_second as $key => $value){
        if($counter == $x){
            $en_name = $key;
        }
        $counter++;
    }
    $fa_name = $names_second[$en_name];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="styles/default.css">
    <title>مشاوره بزرگان</title>
</head>
<body>

<p id="copyright">تهیه شده برای درس کارگاه کامپیوتر،دانشکده کامییوتر، دانشگاه صنعتی شریف</p>
<div id="wrapper">
    <div id="title">
        <span id="label"><?php echo $label?></span>
        <span id="question"><?php echo $question ?></span>
    </div>
    <div id="container" >
        <div id="message">
            <p><?php echo $msg ?></p>
        </div>
        <div id="person">
            <div id="person">
                <img src="images/people/<?php echo "$en_name.jpg" ?>"/>
                <p id="person-name"><?php echo $fa_name ?></p>
            </div>
        </div>
    </div>
    <div id="new-q">
        <form method="post">
            سوال
            <input type="text" name="question" value="<?php echo $question ?>" maxlength="150" placeholder="..."/>
            را از
            <select name="person">
                <?php
                /*
                 * Loop over people data and
                 * enter data inside `option` tag.
                 * E.g., <option value="hafez">حافظ</option>
                 */
                $names = file_get_contents('people.json');
                $names_second = json_decode($names);
                foreach($names_second as $key => $value){
                    if ($key == $en_name){
                       echo '<option selected value='."$key".'> '."$value".'</option>';
                    }
                    else{
                        echo '<option value='."$key".'> '."$value".'</option>';
                    }
                }
                ?>
            </select>
            <input type="submit" value="بپرس"/>
        </form>
    </div>
</div>
</body>
</html>